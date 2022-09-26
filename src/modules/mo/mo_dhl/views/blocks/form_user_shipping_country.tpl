[{if $oViewConf->moHasAncestorTheme('flow') && $oViewConf->isDhlFinderAvailable()}]
    [{if $onChangeClass == 'user'}]
        <div class="col-lg-9 col-lg-offset-3">
    [{/if}]
    <div class="col-xs-12 col-md-6 col-lg-4" id="addressTypeSelectToMove">
        <div class="panel panel-default dd-add-delivery-address">
            <div class="panel-body text-center">
                <i class="fa fa-plus-circle"></i><br/>

                <div class="btn btn-default btn-block input-group container moContainerNoBorders dd-add-delivery-address-input">
                    <select id="addressId" class="selectpicker form-control">
                        <option value="-1">[{oxmultilang ident="NEW_ADDRESS"}]</option>
                        [{if $oViewConf->moCanPackstationBeSelected()}]
                            <option id="selectPackstation">
                                [{oxmultilang ident="MO_DHL__NEW_PACKSTATION"}]
                            </option>
                        [{/if}]
                        [{if $oViewConf->moCanFilialeBeSelected()}]
                            <option id="selectFiliale">
                                [{oxmultilang ident="MO_DHL__NEW_FILIALE"}]
                            </option>
                        [{/if}]
                    </select>
                </div>

            </div>
            <div class="panel-footer">
                <label class="btn btn-default btn-block dd-add-delivery-address-input">
                    <input type="radio" name="oxaddressid" value="-1" class="hidden" autocomplete="off"><i
                            class="fa fa-check"></i> [{oxmultilang ident="DD_USER_SHIPPING_SELECT_ADDRESS"}]
                </label>
            </div>
        </div>
    </div>
    [{if $onChangeClass == 'user'}]
        </div>
    [{/if}]
[{elseif $oViewConf->moHasAncestorTheme('wave') && $oViewConf->isDhlFinderAvailable()}]
    [{if $onChangeClass == 'user'}]
        <div class="col-lg-9 col-lg-offset-3">
    [{/if}]
    <div class="col-12 col-md-6 col-lg-4" id="addressTypeSelectToMove">
        <div class="card dd-add-delivery-address">
            <div class="card-body text-center">
                <i class="fa fa-plus-circle"></i><br/>

                <div class="btn btn-default btn-block input-group container moContainerNoBorders dd-add-delivery-address-input">
                    <select id="addressId" class="form-control">
                        <option value="-1">[{oxmultilang ident="NEW_ADDRESS"}]</option>
                        [{if $oViewConf->moCanPackstationBeSelected()}]
                            <option id="selectPackstation">
                                [{oxmultilang ident="MO_DHL__NEW_PACKSTATION"}]
                            </option>
                        [{/if}]
                        [{if $oViewConf->moCanFilialeBeSelected()}]
                            <option id="selectFiliale">
                                [{oxmultilang ident="MO_DHL__NEW_FILIALE"}]
                            </option>
                        [{/if}]
                    </select>
                </div>

            </div>
            <div class="card-footer">
                <label class="btn btn-outline-dark btn-block active dd-add-delivery-address-input">
                    <input type="radio" name="oxaddressid" value="-1" class="hidden" autocomplete="off"><i
                            class="fa fa-check"></i> [{oxmultilang ident="DD_USER_SHIPPING_SELECT_ADDRESS"}]
                </label>
            </div>
        </div>
    </div>
    [{if $onChangeClass == 'user'}]
        </div>
    [{/if}]
[{/if}]
[{$smarty.block.parent}]
