[{assign var="shop"      value=$oEmailView->getShop()}]
[{assign var="oViewConf" value=$oEmailView->getViewConfig()}]

[{oxmultilang ident="MO_DHL__HELLO"}] [{ $order->oxorder__oxbillsal->value|oxmultilangsal }] [{ $order->oxorder__oxbillfname->value }] [{ $order->oxorder__oxbilllname->value }],

[{oxmultilang ident="MO_DHL__RETOURE_LABEL_CREATED"}]

[{block name="email_plain_ordershipped_oxordernr"}]
[{oxmultilang ident="ORDER_NUMBER" suffix="COLON"}] [{$order->oxorder__oxordernr->value}]
[{/block}]
[{if $labels}]
[{block name="email_html_retoure_label"}]
[{foreach from=$labels  item='label' name='labels'}]
[{if $label->isRetoure()}]
    [{oxmultilang ident="MO_DHL__RETOURE_LABEL"}] [{$label->getFieldData('shipmentNumber')}]:
    [{$label->getFieldData('labelUrl')}]
[{if $label->getFieldData('qrLabelUrl')}]
    [{oxmultilang ident="MO_DHL__RETOURE_QR_LABEL"}] [{$label->getFieldData('shipmentNumber')}]:
    [{$label->getFieldData('qrLabelUrl')}]
[{/if}]
[{/if}]
[{/foreach}]
[{/block}]
[{/if}]
[{block name="email_plain_ordershipped_infofooter"}]
[{oxmultilang ident="YOUR_TEAM" args=$shop->oxshops__oxname->getRawValue()}]
[{/block}]
[{oxcontent ident="oxemailfooterplain"}]