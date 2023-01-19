[{if $oViewConf->isDhlFinderAvailable()}]
    [{if $oViewConf->moHasAncestorTheme('flow') || $oViewConf->moHasAncestorTheme('wave')}]
        <div class="moDhlAddressChange [{if $oViewConf->moHasAncestorTheme('flow')}]is--flow[{else}]is--wave[{/if}]">
            <input type="radio" class="hidden" name="moDhlAddressChange" value="1" id="moDhlSameAddressBtn">
            <label class="moDhlAddressChangeButton btn" type="button" for="moDhlSameAddressBtn">
                [{oxmultilang ident="USE_BILLINGADDRESS_FOR_SHIPPINGADDRESS"}]
            </label>

            <input type="radio" class="hidden" name="moDhlAddressChange" value="0" id="moDhlDifferentAddressBtn">
            <label class="moDhlAddressChangeButton btn" type="button" for="moDhlDifferentAddressBtn">
                [{oxmultilang ident="MO_DHL__SHIPPING_ADDRESS_DIFFERENT"}]
            </label>

            <input type="radio" class="hidden" name="moDhlAddressChange" value="0" id="moDhlBranchAddressBtn">
            <label class="moDhlAddressChangeButton btn hidden" id="moDhlBranchAddress" type="button" for="moDhlBranchAddressBtn">
                <span>[{oxmultilang ident="MO_DHL__SHIPPING_TO_SHOP_FILIALE"}]</span>
                <span class="moDhlPickupDistance">[{oxmultilang ident="MO_DHL__SHIPPING_PICKUP_DISTANCE"}]</span>
            </label>

            <input type="radio" class="hidden" name="moDhlAddressChange" value="0" id="moDhlPackstationAddressBtn">
            <label class="moDhlAddressChangeButton btn hidden" id="moDhlPackstationAddress" type="button" for="moDhlPackstationAddressBtn">
                <span>[{oxmultilang ident="MO_DHL__SHIPPING_TO_PACKSTATION"}]</span>
                <span class="moDhlPickupDistance">[{oxmultilang ident="MO_DHL__SHIPPING_PICKUP_DISTANCE"}]</span>
            </label>
        </div>
    [{/if}]
[{/if}]
[{$smarty.block.parent}]