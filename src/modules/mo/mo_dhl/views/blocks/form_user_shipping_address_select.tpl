[{if $oViewConf->moHasAncestorTheme('azure') && $oViewConf->isDhlFinderAvailable()}]
    <select id="addressId" name="oxaddressid">
        <option value="-1">[{oxmultilang ident="NEW_ADDRESS"}]</option>
        [{if $oViewConf->moCanPackstationBeSelected()}]
            <option id="selectPackstation" value="-1">
                [{oxmultilang ident="MO_EMPFAENGERSERVICES__NEW_PACKSTATION"}]
            </option>
        [{/if}]
        [{if $oViewConf->moCanFilialeBeSelected()}]
            <option id="selectFiliale" value="-1">
                [{oxmultilang ident="MO_EMPFAENGERSERVICES__NEW_FILIALE"}]
            </option>
        [{/if}]
        [{if $oxcmp_user}]
            [{foreach from=$oxcmp_user->getUserAddresses() item=address}]
                <option value="[{$address->oxaddress__oxid->value}]"
                        [{if $address->isSelected()}]SELECTED[{/if}]>[{$address}]</option>
            [{/foreach}]
        [{/if}]
    </select>
[{elseif $oViewConf->moHasAncestorTheme('flow') && $oViewConf->isDhlFinderAvailable()}]
    <div class="row dd-available-addresses" data-toggle="buttons">
        [{foreach from=$aUserAddresses item=address}]
            <div class="col-xs-12 col-md-6 col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        [{if $address->isSelected()}]
                            <button class="btn btn-warning btn-xs hasTooltip pull-right dd-edit-shipping-address"
                                    title="[{oxmultilang ident="CHANGE"}]">
                                <i class="fa fa-pencil"></i>
                            </button>
                        [{/if}]
                        [{include file="widget/address/shipping_address.tpl" delivadr=$address}]
                    </div>
                    <div class="panel-footer">
                        <label class="btn btn-default btn-block[{if $address->isSelected()}] active[{/if}]">
                            <input type="radio" name="oxaddressid" value="[{$address->oxaddress__oxid->value}]"
                                   class="hidden" autocomplete="off" [{if $address->isSelected()}]checked[{/if}]><i
                                    class="fa fa-check"></i> [{oxmultilang ident="DD_USER_SHIPPING_SELECT_ADDRESS"}]
                        </label>
                    </div>
                </div>
            </div>
        [{/foreach}]
    </div>
[{elseif $oViewConf->moHasAncestorTheme('wave') && $oViewConf->isDhlFinderAvailable()}]
    <div class="row dd-available-addresses" data-toggle="buttons">
        [{foreach from=$aUserAddresses item=address name="shippingAdresses"}]
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        [{block name="form_user_shipping_address_actions"}]
                            [{if $address->isSelected()}]
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
                            [{/if}]
                        [{/block}]
                        [{include file="widget/address/shipping_address.tpl" delivadr=$address}]
                    </div>
                    <div class="card-footer" >
                        <label class="btn btn-outline-dark btn-block[{if $address->isSelected()}] active[{/if}]">
                            <input type="radio" name="oxaddressid" value="[{$address->oxaddress__oxid->value}]" class="hidden" autocomplete="off" [{if $address->isSelected()}]checked[{/if}]><i class="fa fa-check"></i> [{oxmultilang ident="DD_USER_SHIPPING_SELECT_ADDRESS"}]
                        </label>
                    </div>
                </div>
            </div>
        [{/foreach}]
    </div>
[{else}]
    [{$smarty.block.parent}]
[{/if}]
