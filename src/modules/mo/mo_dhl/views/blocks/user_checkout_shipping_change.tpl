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

            [{if $oxcmp_user}]
                [{assign var="aUserAddresses" value=$oxcmp_user->getUserAddresses()}]
                [{if $aUserAddresses|@count == 0}]
                    <div class="moDhlNoAddressesNewAddresses">
                        <div>
                            <button class="btn btn-primary moDhlNewAddressButton" type="button" id="moDhlNewAddressButton"
                                    data-toggle="modal" data-target="#moDHLFinder">
                                Add new shipping address
                            </button>
                        </div>
                        <div>
                            <div class="moDhlNewAddressCard">
                                <div class="moDhlAddressCard">
                                    <div class="moDhlAddressCardAddress">
                                <span class="moDhlAddressSpanFName">
                                    <input type="text" class="js-oxValidate js-oxValidate_notEmpty form-control" maxlength="255" required name="moDhlNewAddressFName" placeholder="Vorname">
                                </span>
                                        <span class="moDhlAddressSpanLName">
                                    <input type="text" class="js-oxValidate js-oxValidate_notEmpty form-control" maxlength="255" required name="moDhlNewAddressLName" placeholder="Nachname">
                                </span>
                                        <span class="moDhlAddressSpanStreetAdditional">
                                    <input type="text" class="js-oxValidate js-oxValidate_notEmpty form-control" maxlength="255" required name="moDhlNewAddressStreetAdditional" placeholder="Adresszusatz">
                                </span>
                                        <span class="moDhlAddressSpanStreet"></span>
                                        <span class="moDhlAddressSpanZipCity"></span>
                                        <span class="moDhlAddressSpanCountry"></span>
                                        <span class="moDhlAddressSpanSave text-right">
                                    <button class="btn btn-primary moDhlNewAddressSaveButton" type="button">Save</button>
                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                [{/if}]
            [{/if}]

        </div>
    [{/if}]
[{/if}]
[{$smarty.block.parent}]