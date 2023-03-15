import template from './orders-canceled.html.twig';

const { Component, Utils } = Shopware;
const { get, format } = Utils;


Component.register('mo-orders-canceled', {
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