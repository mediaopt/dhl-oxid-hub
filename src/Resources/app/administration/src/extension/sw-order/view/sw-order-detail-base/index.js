import template from './sw-order-detail-base.html.twig';
import './my-styles.scss'


const { Component, Utils } = Shopware;
const { get, format } = Utils;


Component.override('sw-order-detail-base', {
    template,

    inject: ['transactionsControl'],

    data() {
        return {
            transactionStatus: false,
            transactionSuccess: {
                capture: false,
                refund: false,
                cancel: false,
            },
            transactionLogs: '',
            amountCancelable: 0,
            amountRefundable: 0,
            maxAmountCaptureable: 0,
            Selection: [],
            isLoading: false,
            itemPrices: [],
            amountToCapture: 0,
        };
    },

    created() {
        this.order.lineItems.forEach(item => {
            this.itemPrices.push(0);
            this.Selection.push(0);
        });
    },

    mounted() {
        this.statusCheck();
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

        orderLineItems() {
            return this.order.lineItems;
        },

        taxStatus() {
            return get(this.order, 'taxStatus', '');
        },

        unitPriceLabel() {
            return 'Unit Price';
            if (this.taxStatus === 'net') {
                return this.$tc('sw-order.detailBase.columnPriceNet');
            }

            if (this.taxStatus === 'tax-free') {
                return this.$tc('sw-order.detailBase.columnPriceTaxFree');
            }

            return this.$tc('sw-order.detailBase.columnPriceGross');
        },

        linePriceLabel() {
            return this.taxStatus === 'gross' ?
                'sw-order.detailBase.columnTotalPriceGross' :
                'sw-order.detailBase.columnTotalPriceNet';
        },

        getLineItemColumns() {
            const columnDefinitions = [{
                property: 'quantity',
                dataIndex: 'quantity',
                label: 'sw-order.detailBase.columnQuantity',
                allowResize: false,
                align: 'right',
                width: '150px',
            }, {
                property: 'label',
                dataIndex: 'label',
                label: 'sw-order.detailBase.columnProductName',
                allowResize: false,
                primary: true,
                multiLine: true,
            }, {
                property: 'unitPrice',
                dataIndex: 'unitPrice',
                label: this.unitPriceLabel,
                allowResize: false,
                align: 'right',
                width: '120px',
            }];

            return [...columnDefinitions, {
                property: 'totalPrice',
                dataIndex: 'totalPrice',
                label: this.linePriceLabel,
                allowResize: false,
                align: 'right',
                width: '120px',
            }];
        },
    },

    methods: {
        getValues() {
            if (this.transactionId === null) {
                this.isLoading = false
                return;
            }
            this.transactionsControl.enableButtons({'transactionId': this.transactionId}).then((res) => { //@ todo new endpoint with response we actually need
                if (res.success) {
                    this.transactionStatus = true;
                    this.amountCancelable = res.allowedAmounts.WorldlineCancelAmount;
                    this.amountRefundable = res.allowedAmounts.WorldlineRefundAmount;
                    this.maxAmountCaptureable = res.allowedAmounts.WorldlineCaptureAmount
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

        capture() {
            const payload = {
                transactionId: this.transactionId,
                amount: this.amountToCapture,
            }
            this.transactionsControl.capture(payload)
                .then((res) => {
                    if (res.success) {
                        this.transactionSuccess.capture = true;
                        /*this.createNotificationSuccess({
                            title: this.$tc('worldline.capture-payment-button.title'),
                            message: this.$tc('worldline.capture-payment-button.success')
                        });*/
                        setTimeout(() => {
                            location.reload(); // @todo why the reload? Is there a better way?
                        }, 1000);
                    } else {
                        /*this.createNotificationError({
                            title: this.$tc('worldline.capture-payment-button.title'),
                            message: this.$tc('worldline.capture-payment-button.error') + res.message
                        });*/
                    }
                })
                .finally(() => {
                });
        },

        refund() {
            this.isLoading = true;
            const payload = {
                transactionId: this.transactionId,
                amount: this.amountRefundable,
            }
            this.transactionsControl.refund(payload)
                .then((res) => {
                    if (res.success) {
                        this.transactionSuccess.refund = true;
                        /*this.createNotificationSuccess({
                            title: this.$tc('worldline.refund-payment-button.title'),
                            message: this.$tc('worldline.refund-payment-button.success')
                        });*/
                        setTimeout(() => {
                            location.reload(); // @todo why the reload? Is there a better way?
                        }, 1000);
                    } else {
                        /*this.createNotificationError({
                            title: this.$tc('worldline.refund-payment-button.title'),
                            message: this.$tc('worldline.refund-payment-button.error') + res.message
                        });*/
                    }
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },

        cancel() {
            this.isLoading = true;
            const payload = {
                transactionId: this.transactionId,
                amount: this.amountCancelable,
            }
            this.transactionsControl.cancel(payload)
                .then((res) => {
                    if (res.success) {
                        this.transactionSuccess.refund = true;
                        /*this.createNotificationSuccess({
                            title: this.$tc('worldline.refund-payment-button.title'),
                            message: this.$tc('worldline.refund-payment-button.success')
                        });*/
                        setTimeout(() => {
                            location.reload(); // @todo why the reload? Is there a better way?
                        }, 1000);
                    } else {
                        /*this.createNotificationError({
                            title: this.$tc('worldline.refund-payment-button.title'),
                            message: this.$tc('worldline.refund-payment-button.error') + res.message
                        });*/
                    }
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },

        setPriceSum() {
            this.amountToCapture = Math.min(this.itemPrices.reduce((accumulator, currentValue) => accumulator + currentValue), this.maxAmountCaptureable); // @todo only for now until proper value handling
        },

        setLinePrice(index, amount, price) {
            this.itemPrices[index] = price * amount;
            this.setPriceSum();
        },
    },

})
