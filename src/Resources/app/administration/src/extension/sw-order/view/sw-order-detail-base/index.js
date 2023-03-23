import template from './sw-order-detail-base.html.twig';
import './my-styles.scss'


const { Component } = Shopware;


Component.override('sw-order-detail-base', {
    template,

    inject: ['transactionsControl'],

    data() {
        return {
            activeTab: 'unprocessed',
            tabs: [
                {name: 'unprocessed'},
                {name: 'paid'},
                {name: 'refunded'},
                {name: 'cancel'},
            ],
            transactionStatus: false,
            transactionLogs: '',
            worldlinePaymentStatus: [],
            isLoading: false,
            unwatchOrder: null,
            isUnpaidAdminOrder: false,
            adminPayFinishUrl: '',
            adminPayErrorUrl: '',
            swAccessKey: '',
            worldlineOnlinePaymentId: '',
        };
    },

    created() {
        this.unwatchOrder = this.$watch('order', (newOrder) => {
            if (newOrder?.lineItems?.length) {
                this.initializePanel();
            }
        });
    },

    computed: {
        transactionId() {
            return this.order.customFields?.payment_transaction_id;
        },

        paymentMethod() {
            return this.order.customFields?.worldline_payment_method_id;
        },

        transactionStatus() {
            return this.order.customFields?.payment_transaction_status;
        },

        getOrderId() {
            return this.order.id;
        },

        isWorldlineOnlinePayment() {
            return this.paymentMethod === this.worldlineOnlinePaymentId;
        },

        isAdminOrder() {
            return this.order.createdBy !== null;
        },

        isNoTransactionPresent() {
            return this.transactionId === null;
        },

        isNoCompleteTransactionPresent() {
            if (this.isNoTransactionPresent) return true;
            return this.transactionStatus === '0';
        },
    },

    methods: {
        setActiveTab(tab) {
            this.activeTab = tab.name;
        },

        getPanelConfig() {
            this.transactionsControl.getConfig({'salesChannelId': this.order.salesChannelId}).then((res) => {
                this.adminPayFinishUrl = res.adminPayFinishUrl;
                this.adminPayErrorUrl = res.adminPayErrorUrl;
                this.worldlineOnlinePaymentId = res.worldlineOnlinePaymentId;
                this.swAccessKey = res.swAccessKey;
            }).finally(() => {
                this.isUnpaidAdminOrder = (this.isAdminOrder && this.isWorldlineOnlinePayment && this.isNoCompleteTransactionPresent);
                this.statusCheck();
            });
        },

        initializePanel() {
            this.unwatchOrder();
            this.getPanelConfig();
        },

        getValues() {
            if (this.transactionId === null) {
                this.isLoading = false
                return;
            }
            this.transactionsControl.enableButtons({'transactionId': this.transactionId}).then((res) => {
                if (res.success) {
                    this.transactionStatus = true;
                    this.worldlinePaymentStatus = res.worldlinePaymentStatus;
                    this.transactionLogs = res.log;

                } else {
                    this.createNotificationError({
                        title: this.$tc('worldline.check-status-button.title'),
                        message: this.$tc('worldline.check-status-button.error') + res.message
                    });
                }
            }).finally(() => this.isLoading = false);
        },

        statusCheck() {
            this.isLoading = true;
            this.transactionsControl.statusCheck(
                {'transactionId': this.transactionId}
            ).then((res) => {
                if (res.success) {
                    this.getValues();
                } else {
                    if (!this.isUnpaidAdminOrder) {
                        this.transactionStatus = false;
                        this.createNotificationError({
                            title: this.$tc('worldline.check-status-button.title'),
                            message: this.$tc('worldline.check-status-button.error') + res.message
                        });
                    }
                    this.isLoading = false;
                }
            });
        },

        payByAdmin() {
            this.isLoading = true;
            const payload = {
                orderId: this.getOrderId,
                finishUrl: this.adminPayFinishUrl,
                errorUrl: this.adminPayErrorUrl,
            };

            fetch('/store-api/handle-payment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'sw-access-key': this.swAccessKey
                },
                body: JSON.stringify(payload),
            }).then((response) => {
                if (response.ok) {
                    response.json().then(r => {
                        let popup = null
                        let invId = null
                        let invFunc = () => {
                            if (popup.closed) {
                                clearInterval(invId);
                                location.reload();
                            }
                        }
                        popup = open(r.redirectUrl);
                        invId = setInterval(invFunc, 500);
                    });
                } else {
                    console.error(response);
                    this.createNotificationError({
                        title: this.$tc('worldline.check-status-button.title'),
                        message: this.$tc('worldline.transaction-control.buttons.error')
                    });
                }
            }).catch((error) => {
                console.error(error);
                this.createNotificationError({
                    title: this.$tc('worldline.check-status-button.title'),
                    message: this.$tc('worldline.check-status-button.error') + error
                });
            }).finally(() => {
                this.isLoading = false;
            });
        },
    },

})
