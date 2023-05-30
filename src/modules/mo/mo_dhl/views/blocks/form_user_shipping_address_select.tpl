[{if $oViewConf->moHasAncestorTheme('azure') && $oViewConf->isDhlFinderAvailable()}]
    <select id="addressId" name="oxaddressid">
        <option value="-1">[{oxmultilang ident="NEW_ADDRESS"}]</option>
        [{if $oViewConf->moCanPackstationBeSelected()}]
            <option id="selectPackstation" value="-1">
                [{oxmultilang ident="MO_DHL__NEW_PACKSTATION"}]
            </option>
        [{/if}]
        [{if $oViewConf->moCanFilialeBeSelected()}]
            <option id="selectFiliale" value="-1">
                [{oxmultilang ident="MO_DHL__NEW_FILIALE"}]
            </option>
        [{/if}]
        [{if $oxcmp_user}]
            [{foreach from=$oxcmp_user->getUserAddresses() item=address}]
                <option value="[{$address->oxaddress__oxid->value}]"
                        [{if $address->isSelected()}]SELECTED[{/if}]>[{$address}]</option>
            [{/foreach}]
        [{/if}]
    </select>
[{*elseif ($oViewConf->moHasAncestorTheme('wave') || $oViewConf->moHasAncestorTheme('flow')) && $oViewConf->isDhlFinderAvailable()*}]
[{elseif $oViewConf->moHasAncestorTheme('wave') || $oViewConf->moHasAncestorTheme('flow')}]
    <div class="row dd-available-addresses moDhlAvailableAddresses">
        [{foreach from=$aUserAddresses item=address name="shippingAdresses"}]
            <div class="col-12">
                <div class="moDhlAddressCard [{if $address->isSelected()}]active[{/if}]">
                    [{if !$address->isSelected()}]
                        <label for="radio_[{$address->oxaddress__oxid->value}]">
                            <span class="moDhlAddressCardAddress [{if $delivadr->oxaddress__oxstreet->value}][{/if}]">
                                [{include file="mo_dhl__shipping_address.tpl" delivadr=$address}]
                            </span>
                        </label>
                        <input type="radio" name="oxaddressid" value="[{$address->oxaddress__oxid->value}]" class="hidden"
                               autocomplete="off" id="radio_[{$address->oxaddress__oxid->value}]">
                    [{else}]
                        <div class="moDhlAddressCardAddress">
                            [{include file="mo_dhl__shipping_address.tpl" delivadr=$address selected=$address->isSelected()}]
                        </div>
                    [{/if}]
                    [{block name="form_user_shipping_address_actions"}]
                        [{if $address->isSelected()}]
                            <div class="moDhlAddressCardOption">
                                <i class="fa fa-ellipsis-v"></i>
                                <div class="moDhlAddressCardActions">
                                    <div class="moDhlAddressChangeName moDhlAddressCardOptionSkip">[{oxmultilang ident="MO_DHL__ADDRESS_CHANGE_NAME"}]</div>
                                    <div class="moDhlAddressChangeAddress moDhlAddressCardOptionSkip hidden">[{oxmultilang ident="MO_DHL__ADDRESS_CHANGE_ADDRESS"}]</div>
                                    <div class="moDhlAddressChangeDelete moDhlAddressCardOptionSkip">
                                        <span class="btn btn-danger"
                                                title="[{oxmultilang ident="DD_DELETE"}]"
                                                data-toggle="modal"
                                                data-target="#delete_shipping_address_[{$smarty.foreach.shippingAdresses.iteration}]">
                                            <i class="fa fa-trash"></i> [{oxmultilang ident="MO_DHL__ADDRESS_CHANGE_DELETE"}]
                                        </span>
                                    </div>
                                    [{block name="form_user_shipping_address_edit_action"}][{/block}]
                                    [{block name="form_user_shipping_address_delete_action"}][{/block}]
                                </div>
                            </div>
                            <span class="moDhlAddressChangeSpanSave text-right">
                                <button class="btn btn-primary moDhlNewAddressSaveButton" type="button">Save</button>
                            </span>
                        [{/if}]
                    [{/block}]
                </div>
            </div>
        [{/foreach}]
    </div>
    <div class="row">
        <button class="btn btn-primary moDhlNewAddressButton" type="button" id="moDhlNewAddressButton"
                data-toggle="modal" data-target="#moDHLFinder">
            Add new shipping address
        </button>
    </div>
    <div class="row">
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
[{else}]
    [{$smarty.block.parent}]
[{/if}]
