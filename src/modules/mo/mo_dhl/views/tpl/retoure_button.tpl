[{if !$order->moDHLHasRetoure()}]
<form class="moDHLCreateRetoure" action="[{$oViewConf->getSelfActionLink()}]" name="moDHLCreateRetoure" method="post" novalidate="novalidate">
    <div class="hidden">
        [{$oViewConf->getHiddenSid()}]
        [{$oViewConf->getNavFormParams()}]
        <input type="hidden" name="fnc" value="moDHLCreateRetoure">
        <input type="hidden" name="cl" value="[{$oViewConf->getActiveClassName()}]">
        <input type="hidden" name="orderId" value="[{$order->getId()}]">
        [{if isset($uid)}]
            <input type="hidden" name="uid" value="[{$uid}]">
            <input type="hidden" name="checkUser" value=false>
        [{else}]
            <input type="hidden" name="checkUser" value=true>
        [{/if}]
    </div>
    <button class="btn btn-primary" type="submit">
        [{oxmultilang ident="MO_DHL__CREATE_RETOURE"}]
    </button>
</form>
[{/if}]
