[{if $order->moDHLHasRetoure()}]
    <strong>[{oxmultilang ident="MO_DHL__RETOURE"}]</strong>
    [{include file="mo_dhl__retoure_links.tpl"}]
[{else}]
    [{if $oView->moDHLShowRetoureActions($order)}]
        <strong>[{oxmultilang ident="MO_DHL__RETOURE"}]</strong>
        [{include file="mo_dhl__retoure_button.tpl"}]
    [{/if}]
[{/if}]
