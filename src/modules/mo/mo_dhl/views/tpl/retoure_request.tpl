<form class="moDHLRetoureRequest" action="[{$oViewConf->getSelfActionLink()}]" name="moDHLRetoureRequest" method="post" novalidate="novalidate">
    <div class="hidden">
        [{$oViewConf->getHiddenSid()}]
        [{$oViewConf->getNavFormParams()}]
        <input type="hidden" name="fnc" value="moDHLRetoureRequest">
        <input type="hidden" name="cl" value="account_order">
        <input type="hidden" name="orderId" value="[{$order->getId()}]">
    </div>

    [{if ($order->moDHLIsRetoureRequested())}]
        [{oxmultilang ident="MO_DHL__RETOURE_REQUESTED"}]
        <br/>
        <button class="btn btn-primary" type="submit">
            [{oxmultilang ident="MO_DHL__RETOURE_CANCEL"}]
        </button>
    [{else}]
        <button class="btn btn-primary" type="submit">
            [{oxmultilang ident="MO_DHL__RETOURE_REQUEST"}]
        </button>
    [{/if}]
</form>