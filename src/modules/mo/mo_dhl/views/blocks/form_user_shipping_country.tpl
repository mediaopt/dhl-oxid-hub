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
                                [{oxmultilang ident="MO_EMPFAENGERSERVICES__NEW_PACKSTATION"}]
                            </option>
                        [{/if}]
                        [{if $oViewConf->moCanFilialeBeSelected()}]
                            <option id="selectFiliale">
                                [{oxmultilang ident="MO_EMPFAENGERSERVICES__NEW_FILIALE"}]
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
    <div class="form-group[{if $aErrors.oxaddress__oxcountryid}] oxInValid[{/if}]">
        <label class="control-label col-lg-3[{if $oView->isFieldRequired(oxaddress__oxcountryid)}] req[{/if}]"
               for="delCountrySelect">[{oxmultilang ident="COUNTRY"}]</label>
        <div class="col-lg-9" id="dropdownCountry">
            <select class="form-control[{if $oView->isFieldRequired(oxaddress__oxcountryid)}] js-oxValidate js-oxValidate_notEmpty[{/if}] selectpicker"
                    id="delCountrySelect"
                    name="deladr[oxaddress__oxcountryid]"[{if $oView->isFieldRequired(oxaddress__oxcountryid)}] required=""[{/if}]>
                <option value="">-</option>
                [{assign var="blCountrySelected" value=false}]
                [{foreach from=$oViewConf->getCountryList() item=country key=country_id}]
                    [{assign var="sCountrySelect" value=""}]
                    [{if !$blCountrySelected}]
                        [{if (isset($deladr.oxaddress__oxcountryid) && $deladr.oxaddress__oxcountryid == $country->oxcountry__oxid->value) ||
                        (!isset($deladr.oxaddress__oxcountryid) && ($delivadr->oxaddress__oxcountry->value == $country->oxcountry__oxtitle->value or
                        $delivadr->oxaddress__oxcountry->value == $country->oxcountry__oxid->value or
                        $delivadr->oxaddress__oxcountryid->value == $country->oxcountry__oxid->value))}]
                            [{assign var="blCountrySelected" value=true}]
                            [{assign var="sCountrySelect" value="selected"}]
                        [{/if}]
                    [{/if}]
                    <option value="[{$country->oxcountry__oxid->value}]" [{$sCountrySelect}]>[{$country->oxcountry__oxtitle->value}]</option>
                [{/foreach}]
            </select>
            [{if $oView->isFieldRequired(oxaddress__oxcountryid)}]
                [{include file="message/inputvalidation.tpl" aErrors=$aErrors.oxaddress__oxcountryid}]
                <div class="help-block"></div>
            [{/if}]
        </div>
        <div class="col-lg-9" id="staticCountry" style="display: none">
            <input class="form-control" id="[{$oViewConf->getGermanyId()}]" value="" readonly>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-3"
               for="[{$countrySelectId}]">[{oxmultilang ident="DD_USER_SHIPPING_LABEL_STATE"}]</label>
        <div class="col-lg-9">
            [{include file="form/fieldset/state.tpl"
            countrySelectId="delCountrySelect"
            stateSelectName="deladr[oxaddress__oxstateid]"
            selectedStateIdPrim=$deladr.oxaddress__oxstateid
            selectedStateId=$delivadr->oxaddress__oxstateid->value
            class="form-control selectpicker"}]
        </div>
    </div>
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
                                [{oxmultilang ident="MO_EMPFAENGERSERVICES__NEW_PACKSTATION"}]
                            </option>
                        [{/if}]
                        [{if $oViewConf->moCanFilialeBeSelected()}]
                            <option id="selectFiliale">
                                [{oxmultilang ident="MO_EMPFAENGERSERVICES__NEW_FILIALE"}]
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
    <div class="form-group[{if $aErrors.oxaddress__oxcountryid}] oxInValid[{/if}]">
        <label class="control-label col-lg-3[{if $oView->isFieldRequired(oxaddress__oxcountryid)}] req[{/if}]" for="delCountrySelect">[{oxmultilang ident="COUNTRY"}]</label>
        <div class="col-lg-9" id="dropdownCountry">
            <select class="form-control[{if $oView->isFieldRequired(oxaddress__oxcountryid)}] js-oxValidate js-oxValidate_notEmpty[{/if}]" id="delCountrySelect" name="deladr[oxaddress__oxcountryid]"[{if $oView->isFieldRequired(oxaddress__oxcountryid)}] required=""[{/if}]>
                <option value="">-</option>
                [{assign var="blCountrySelected" value=false}]
                [{foreach from=$oViewConf->getCountryList() item=country key=country_id}]
                    [{assign var="sCountrySelect" value=""}]
                    [{if !$blCountrySelected}]
                        [{if (isset($deladr.oxaddress__oxcountryid) && $deladr.oxaddress__oxcountryid == $country->oxcountry__oxid->value) ||
                        (!isset($deladr.oxaddress__oxcountryid) && ($delivadr->oxaddress__oxcountry->value == $country->oxcountry__oxtitle->value or
                        $delivadr->oxaddress__oxcountry->value == $country->oxcountry__oxid->value or
                        $delivadr->oxaddress__oxcountryid->value == $country->oxcountry__oxid->value))}]
                            [{assign var="blCountrySelected" value=true}]
                            [{assign var="sCountrySelect" value="selected"}]
                        [{/if}]
                    [{/if}]
                    <option value="[{$country->oxcountry__oxid->value}]" [{$sCountrySelect}]>[{$country->oxcountry__oxtitle->value}]</option>
                [{/foreach}]
            </select>
            [{if $oView->isFieldRequired(oxaddress__oxcountryid)}]
                [{include file="message/inputvalidation.tpl" aErrors=$aErrors.oxaddress__oxcountryid}]
                <div class="help-block"></div>
            [{/if}]
        </div>
        <div class="col-lg-9" id="staticCountry" style="display: none">
            <input class="form-control" id="[{$oViewConf->getGermanyId()}]" value="" readonly>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-3" for="[{$countrySelectId}]">[{oxmultilang ident="DD_USER_LABEL_STATE" suffix="COLON"}]</label>
        <div class="col-lg-9">
            [{include file="form/fieldset/state.tpl"
            countrySelectId="delCountrySelect"
            stateSelectName="deladr[oxaddress__oxstateid]"
            selectedStateIdPrim=$deladr.oxaddress__oxstateid
            selectedStateId=$delivadr->oxaddress__oxstateid->value
            class="form-control"}]
        </div>
    </div>
[{else}]
    [{$smarty.block.parent}]
[{/if}]
