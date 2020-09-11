[{if $order->moDHLHasRetoure()}]
    <strong>[{oxmultilang ident="MO_DHL__RETOURE"}]</strong>
    [{include file="mo_dhl__retoure_links.tpl"}]
[{else}]
    [{if $oView->moDHLCanUserCreateRetoure($order)}]
        <strong>[{oxmultilang ident="MO_DHL__RETOURE"}]</strong>
        [{if $oView->moDHLShouldUserAskForRetoure()}]
            [{if $order->moDHLIsRetoureDeclined()}]
                <br/>
                [{oxmultilang ident="MO_DHL__RETOURE_DECLINED"}]
            [{else}]
                [{include file="mo_dhl__retoure_request.tpl"}]
            [{/if}]
        [{else}]
            [{include file="mo_dhl__retoure_button.tpl"}]
        [{/if}]
    [{/if}]
[{/if}]
