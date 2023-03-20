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
            worldlinePaymentStatus: [
                {
                    label: 'Main product',
                    id: '231',
                    unitPrice: 100,
                    quantity: 2,
                    unprocessed: 1,
                    paid: 1,
                    refunded: 0,
                    canceled: 0,
                },
                {
                    label: 'Product with properties',
                    id: '321',
                    unitPrice: 10,
                    quantity: 3,
                    unprocessed: 0,
                    paid: 1,
                    refunded: 1,
                    canceled: 1,
                },
                {
                    label: 'Just another product',
                    id: '123',
                    unitPrice: 13.99,
                    quantity: 7,
                    unprocessed: 0,
                    paid: 2,
                    refunded: 3,
                    canceled: 2,
                }
            ],
            isLoading: false,
            unwatchOrder: null,
            isUnpaidAdminOrder: false,
            wordlineOnlinePaymentName: 'Worldline | Worldline Online Payments',
            adminPayFinishUrl: 'https://127.0.0.1:8000/worldline/payment/finalize-transaction',
            adminPayErrorUrl: 'https://127.0.0.1:8000/worldline/payment/finalize-transaction',
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
            for (let i = 0; i < this.order.transactions.length; i += 1) {
                if (!['cancelled', 'failed'].includes(this.order.transactions[i].stateMachineState.technicalName)) {
                    var transaction = this.order.transactions[i].customFields;
                    if (transaction === null) {
                        return null;
                    }
                    return transaction.payment_transaction_id;
                }
            }
            return this.order.transactions.last().customFields.payment_transaction_id;
        },

        paymentMethod() {
            return this.order.transactions.last().paymentMethod.translated.distinguishableName;
        },

        getOrderId() {
            return this.order.id;
        },

        isWorldlineOnlinePayment() {
            return this.paymentMethod === this.wordlineOnlinePaymentName;
        },

        isAdminOrder() {
            return this.order.createdBy !== null;
        },

        isNoTransactionPresent() {
            return this.transactionId === null;
        },
    },

    methods: {
        setActiveTab(tab) {
            this.activeTab = tab.name;
        },

        initializePanel() {
            this.isUnpaidAdminOrder = (this.isAdminOrder && this.isWorldlineOnlinePayment && this.isNoTransactionPresent);
            this.unwatchOrder();
            this.statusCheck();
        },

        getValues() {
            if (this.transactionId === null) {
                this.isLoading = false
                return;
            }
            this.transactionsControl.enableButtons({'transactionId': this.transactionId}).then((res) => { //@ todo new endpoint with response we actually need
                if (res.success) {
                    this.transactionStatus = true;
                    // this.worldlinePaymentStatus = res.paymentStatus; //@todo need new data from backend
                    if (Object.entries(res.log).length > 0) {
                        this.transactionLogs = res.log.join('\r\n');
                    }
                } else {
                    /*this.createNotificationError({
                        title: this.$tc('worldline.check-status-button.title'),
                        message: this.$tc('worldline.check-status-button.error') + res.message
                    });*/
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
                    this.transactionStatus = false;
                    this.createNotificationError({
                        title: this.$tc('worldline.check-status-button.title'),
                        message: this.$tc('worldline.check-status-button.error') + res.message
                    });
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
                    'sw-access-key': 'SWSCVMDPAK1UWVR4T3V3CEFKSA'
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
                    /*this.createNotificationError({
                        title: this.$tc('worldline.check-status-button.title'),
                        message: this.$tc('worldline.check-status-button.error') + res.message
                    });*/
                }
            }).catch((error) => {
                console.log(error)
                /*this.createNotificationError({
                        title: this.$tc('worldline.check-status-button.title'),
                        message: this.$tc('worldline.check-status-button.error') + res.message
                    });*/
            }).finally(() => {
                this.isLoading = false;
            });
        },
    },

})
