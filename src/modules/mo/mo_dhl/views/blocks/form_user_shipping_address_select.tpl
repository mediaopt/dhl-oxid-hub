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
    <div class="row dd-available-addresses moDhlAvailableAddresses" data-toggle="buttons">
        [{foreach from=$aUserAddresses item=address name="shippingAdresses"}]
            <div class="col-12">
                <div class="moDhlAddressCard [{if $address->isSelected()}]active[{/if}]">
                    [{if !$address->isSelected()}]
                        <label>
                            <div class="moDhlAddressCardAddress [{if $delivadr->oxaddress__oxstreet->value}][{/if}]">
                                [{include file="mo_dhl__shipping_address.tpl" delivadr=$address}]
                            </div>
                        </label>
                        <input type="radio" name="oxaddressid" value="[{$address->oxaddress__oxid->value}]" class="hidden"
                               autocomplete="off">
                    [{else}]
                        <div class="moDhlAddressCardAddress">
                            [{include file="mo_dhl__shipping_address.tpl" delivadr=$address}]
                        </div>
                    [{/if}]
                    [{block name="form_user_shipping_address_actions"}]
                        [{if $address->isSelected()}]
                            <div class="moDhlAddressCardOption">
                                <i class="fa fa-ellipsis-v"></i>
                            </div>
                            <div class="moDhlAddressCardActions">
                                [{block name="form_user_shipping_address_edit_action"}]
                                <button class="btn btn-warning btn-sm hasTooltip float-right dd-action dd-edit-shipping-address edit-button"
                                        title="[{oxmultilang ident="CHANGE"}]">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                [{/block}]
                                [{block name="form_user_shipping_address_delete_action"}]
                                <button class="btn btn-danger btn-sm hasTooltip float-right dd-action dd-delete-shipping-address edit-button"
                                        title="[{oxmultilang ident="DD_DELETE"}]"
                                        data-toggle="modal"
                                        data-target="#delete_shipping_address_[{$smarty.foreach.shippingAdresses.iteration}]">
                                    <i class="fa fa-trash"></i>
                                </button>
                                [{/block}]
                            </div>
                        [{/if}]
                    [{/block}]
                </div>
            </div>
        [{/foreach}]
    </div>
[{else}]
    [{$smarty.block.parent}]
[{/if}]
