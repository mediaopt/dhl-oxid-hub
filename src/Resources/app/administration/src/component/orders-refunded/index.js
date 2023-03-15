import template from './orders-refunded.html.twig';

const { Component, Utils } = Shopware;
const { get, format } = Utils;


Component.register('mo-orders-refunded', {
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