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
                    unitPrice: 100,
                    quantity: 2,
                    unprocessed: 1,
                    paid: 1,
                    refunded: 0,
                    canceled: 0,
                },
                {
                    label: 'Product with properties',
                    unitPrice: 10,
                    quantity: 3,
                    unprocessed: 0,
                    paid: 1,
                    refunded: 1,
                    canceled: 1,
                },
                {
                    label: 'Just another product',
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
    },

    methods: {
        setActiveTab(tab) {
            this.activeTab = tab.name;
        },

        initializePanel() {
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
                    // this.worldlinePaymentStatus = res.paymentStatus;
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
                    // this.transactionStatus = true;
                    /*this.createNotificationSuccess({
                         title: this.$tc('worldline.check-status-button.title'),
                         message: this.$tc('worldline.check-status-button.success')
                     });*/
                    this.getValues();
                } else {
                    this.transactionStatus = false;
                    /*this.createNotificationError({
                        title: this.$tc('worldline.check-status-button.title'),
                        message: this.$tc('worldline.check-status-button.error') + res.message
                    });*/
                    this.isLoading = false;
                }
            });
        },
    },

})
