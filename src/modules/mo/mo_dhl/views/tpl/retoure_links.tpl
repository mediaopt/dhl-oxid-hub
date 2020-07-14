[{if $order->moDHLHasRetoure()}]
<div>
    [{assign value=$order->moDHLGetRetoure() var="moDHLRetoure"}]
    <form class="moDHLShowRetoure" action="[{$oViewConf->getSelfActionLink()}]" name="moDHLShowRetoure" method="get" novalidate="novalidate">
        <div class="hidden">
            [{$oViewConf->getHiddenSid()}]
            [{$oViewConf->getNavFormParams()}]
            <input type="hidden" name="fnc" value="moDHLShowRetoure">
            <input type="hidden" name="cl" value="account_order">
            <input type="hidden" name="retoureId" value="[{$moDHLRetoure->getId()}]">
        </div>
        <button class="btn btn-primary" type="submit">
            [{oxmultilang ident="MO_DHL__RETOURE_LABEL"}]
        </button>
    </form>
    [{if $moDHLRetoure->getFieldData('qrLabelUrl')}]
        <form class="moDHLShowRetoure" action="[{$oViewConf->getSelfActionLink()}]" name="moDHLShowRetoure" method="get" novalidate="novalidate">
            <div class="hidden">
                [{$oViewConf->getHiddenSid()}]
                [{$oViewConf->getNavFormParams()}]
                <input type="hidden" name="fnc" value="moDHLShowRetoure">
                <input type="hidden" name="cl" value="account_order">
                <input type="hidden" name="retoureId" value="[{$moDHLRetoure->getId()}]">
                <input type="hidden" name="format" value="qr">
            </div>
            <button class="btn btn-primary" type="submit">
                [{oxmultilang ident="MO_DHL__RETOURE_QR_LABEL"}]
            </button>
        </form>
    [{/if}]
</div>
[{/if}]
