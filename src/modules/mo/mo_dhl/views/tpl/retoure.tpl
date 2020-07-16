[{if $oView->moDHLShowRetoureActions($order)}]
    <strong>[{oxmultilang ident="MO_DHL__RETOURE"}]</strong>
    [{if !$order->moDHLHasRetoure()}]
        [{include file="mo_dhl__retoure_button.tpl"}]
    [{else}]
        [{include file="mo_dhl__retoure_links.tpl"}]
    [{/if}]
[{/if}]
