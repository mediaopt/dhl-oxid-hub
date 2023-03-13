import template from './sw-order-detail-base.html.twig';

const { Component } = Shopware;

Component.override('sw-order-detail-base', {
    template,

    inject: ['transactionsControl'],
    data() {
        return {
            isLoading: false,
            isSaveSuccessful: false,
        };
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
        }
    },
    methods: {
        getData(element) {
            return {
                'transactionId': this.transactionId,
                'amount': document.getElementById(element).value
            }
        },
        statusCheck() {
            this.isLoading = true;
            this.transactionsControl.statusCheck(
                {'transactionId': document.getElementById('payment_transaction_id').value}
            ).then((res) => {
                if (res.success) {
                    this.isSaveSuccessful = true;
                    this.createNotificationSuccess({
                        title: this.$tc('worldline.check-status-button.title'),
                        message: this.$tc('worldline.check-status-button.success')
                    });
                    location.reload();
                } else {
                    this.createNotificationError({
                        title: this.$tc('worldline.check-status-button.title'),
                        message: this.$tc('worldline.check-status-button.error') + res.message
                    });
                }

                this.isLoading = false;
            });
        },
        capture() {
            this.isLoading = true;
            this.transactionsControl.capture(this.getData('WorldlineCaptureAmount')).then((res) => {
                if (res.success) {
                    this.isSaveSuccessful = true;
                    this.createNotificationSuccess({
                        title: this.$tc('worldline.capture-payment-button.title'),
                        message: this.$tc('worldline.capture-payment-button.success')
                    });
                    location.reload();
                } else {
                    this.createNotificationError({
                        title: this.$tc('worldline.capture-payment-button.title'),
                        message: this.$tc('worldline.capture-payment-button.error') + res.message
                    });
                }

                this.isLoading = false;
            });
        },
        cancel() {
            this.isLoading = true;
            this.transactionsControl.cancel(this.getData('WorldlineCancelAmount')).then((res) => {
                if (res.success) {
                    this.isSaveSuccessful = true;
                    this.createNotificationSuccess({
                        title: this.$tc('worldline.cancel-payment-button.title'),
                        message: this.$tc('worldline.cancel-payment-button.success')
                    });
                    location.reload();
                } else {
                    this.createNotificationError({
                        title: this.$tc('worldline.cancel-payment-button.title'),
                        message: this.$tc('worldline.cancel-payment-button.error') + res.message
                    });
                }

                this.isLoading = false;
            });
        },
        refund() {
            this.isLoading = true;
            this.transactionsControl.refund(this.getData('WorldlineRefundAmount')).then((res) => {
                if (res.success) {
                    this.isSaveSuccessful = true;
                    this.createNotificationSuccess({
                        title: this.$tc('worldline.refund-payment-button.title'),
                        message: this.$tc('worldline.refund-payment-button.success')
                    });
                    location.reload();
                } else {
                    this.createNotificationError({
                        title: this.$tc('worldline.refund-payment-button.title'),
                        message: this.$tc('worldline.refund-payment-button.error') + res.message
                    });
                }

                this.isLoading = false;
            });
        },
        enableButtons() {
            var transactionId = this.transactionId;
            if (this.transactionId === null) {
                var control = document.getElementById('WorldlineTransactionControl');
                if (control !== null) {
                    control.remove();
                }
                return;
            }

            //Disabling buttons via twig add some classes and make enabling much more complicated
            document.getElementById("WorldlineBtnCapture").disabled = true;
            document.getElementById("WorldlineBtnCancel").disabled = true;
            document.getElementById("WorldlineBtnRefund").disabled = true;
            document.getElementById("WorldlineCaptureAmount").disabled = true;
            document.getElementById("WorldlineCancelAmount").disabled = true;
            document.getElementById("WorldlineRefundAmount").disabled = true;

            this.transactionsControl.enableButtons({'transactionId': transactionId}).then((res) => {
                if (res.message.length > 0) {
                    for (const element of res.message) {
                        document.getElementById(element).disabled = false;
                    }
                }
                if (Object.entries(res.allowedAmounts).length > 0) {
                    for (const [element, value] of Object.entries(res.allowedAmounts)) {
                        document.getElementById(element).value = value;
                        if (value > 0) {
                            document.getElementById(element).disabled = false;
                        }
                    }
                }
                if (Object.entries(res.log).length > 0) {
                    document.getElementById('WorldlineTransactionsLog').innerHTML = res.log.join('<br/>');
                }
            });
        }
    },
    updated() {
        this.enableButtons();
    }
});
