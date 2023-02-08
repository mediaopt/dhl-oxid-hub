[{if ($oViewConf->moHasAncestorTheme('flow') || $oViewConf->moHasAncestorTheme('wave')) && $oViewConf->isDhlFinderAvailable()}]
    <div id="addressTypeSelectToMove" class="hidden">
        <div class="panel panel-default dd-add-delivery-address">
            <div class="panel-body text-center">
                <i class="fa fa-plus-circle"></i><br/>

                <div class="btn btn-default btn-block input-group container moContainerNoBorders dd-add-delivery-address-input">
                    <select id="addressId" class="selectpicker form-control">
                        <option id="selectregular" value="-1">[{oxmultilang ident="NEW_ADDRESS"}]</option>
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
[{/if}]
[{$smarty.block.parent}]
