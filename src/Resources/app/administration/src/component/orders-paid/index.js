import template from './orders-paid.html.twig';

const { Component, Utils } = Shopware;
const { get, format } = Utils;


Component.register('mo-orders-paid', {
    template,

    inject: ['transactionsControl'],

    props: {
        order: {
            type: Object,
            required: true,
        },
        transactionId: {
            type: String,
            required: true,
        }
    },
});