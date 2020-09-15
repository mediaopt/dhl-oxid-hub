[{assign var="shop"      value=$oEmailView->getShop()}]
[{assign var="oViewConf" value=$oEmailView->getViewConfig()}]

[{capture assign="style"}]
    table.retourlabels th {
    white-space: nowrap;
    }

    table.retourlabels th, table.retourlabels td {
    border: 1px solid #d4d4d4;
    font-size: 13px;
    padding:5px;
    }

    table.retourlabels {
    border-collapse: collapse;
    }

    table.retourlabels thead th {
    background-color: #ebebeb;
    }
[{/capture}]

[{include file="email/html/header.tpl" title="MO_DHL__RETOURE_LABEL_HEADING"|oxmultilangassign|cat:"  #"|cat:$order->oxorder__oxordernr->value style=$style}]

[{block name="email_html_ordershipped_sendemail"}]
    [{oxmultilang ident="MO_DHL__HELLO"}] [{ $order->oxorder__oxbillsal->value|oxmultilangsal }] [{ $order->oxorder__oxbillfname->value }] [{ $order->oxorder__oxbilllname->value }],
    <p>[{oxmultilang ident="MO_DHL__RETOURE_LABEL_CREATED"}]</p>
[{/block}]

[{if $labels}]
    [{block name="email_html_retoure_label"}]
    <table  class="retourlabels" border="0" cellspacing="0" cellpadding="0" width="100%">
        [{foreach from=$labels  item='label' name='labels'}]
            [{if $label->isRetoure()}]
                <tr valign="top">
                    <td>
                        <p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0;">
                            [{oxmultilang ident="MO_DHL__RETOURE_LABEL"}]
                        </p>
                    </td>
                    <td>
                        <p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0;">
                            <a target="_blank" rel="noopener noreferrer"
                               href="[{$label->getFieldData('labelUrl')}]">[{$label->getFieldData('shipmentNumber')}]</a>
                        </p>
                    </td>
                </tr>
                [{if $label->getFieldData('qrLabelUrl')}]
                    <tr valign="top">
                        <td>
                            <p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0;">
                                [{oxmultilang ident="MO_DHL__RETOURE_QR_LABEL"}]
                            </p>
                        </td>
                        <td>
                            <p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0;">
                                <a target="_blank" rel="noopener noreferrer"
                                   href="[{$label->getFieldData('qrLabelUrl')}]">[{$label->getFieldData('shipmentNumber')}]</a>
                            </p>
                        </td>
                    </tr>
                [{/if}]
            [{/if}]
        [{/foreach}]
    </table>
    [{/block}]
[{/if}]
<br/>
[{block name="email_html_ordershipped_infofooter"}]
    <p>[{oxmultilang ident="YOUR_TEAM" args=$shop->oxshops__oxname->value}]</p><br/>
[{/block}]

[{include file="email/html/footer.tpl"}]