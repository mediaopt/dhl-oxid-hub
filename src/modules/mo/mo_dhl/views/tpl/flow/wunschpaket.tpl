<div style="display: none">
    [{if $oViewConf->moIsAnyWunschpaketFeatureActivated()}]
        <div id="moDHLWunschpaket" class="moDHLWunschpaketFlow form-group"
             data-translatenowunschtag="[{oxmultilang ident='MO_DHL__NO_WUNSCHTAG'}]"
             data-translatefailedblacklist="[{oxmultilang ident='MO_DHL__FAILED_BLACKLIST'}]"
             data-theme="flow" data-dateajax="[{$oViewConf->getSslSelfLink()}]cl=MoDHLYellowBox&zip=">

            <span class="col-lg-3 col-xs-12 moDhlWunschpaketServiceHeadline">[{oxmultilang ident='MO_DHL__SHIPPING_OPTIONS'}]</span>

            <div class="col-lg-9 col-xs-12">
                [{assign var="wunschtagCosts" value=$oView->moDHLGetWunschtagCosts()}]
                <div id="moDHL--wunschtag-info"
                    class="moDhlWunschpaketServiceOption [{if !$oViewConf->moIsWunschtagActivated()}] moDHL--deactivated [{/if}]">
                    <label class="collapsed moDhlWunschpaketServiceLabel" data-toggle="collapse" data-target="#moDHL--wunschtag-values">
                        <input type="checkbox" id="moDHLWunschtagCheckbox" value=""/>
                        <strong>[{oxmultilang ident="MO_DHL__WUNSCHTAG_LABEL_CONTENT"}]</strong>
                        <i class="fa fa-caret-up"></i>
                        <i class="fa fa-caret-down"></i>
                    </label>
                </div>
                <div class="collapse [{if !$oViewConf->moIsWunschtagActivated()}] moDHL--deactivated[{/if}]" id="moDHL--wunschtag-values">
                    <span class="moDHL--wunschtag-surcharge">
                        [{if $wunschtagCosts && $wunschtagCosts->getPrice() > 0}]
                            [{if $oViewConf->isFunctionalityEnabled('blShowVATForDelivery')}]
                                ([{oxmultilang ident="MO_DHL__SURCHARGE_NET" suffix="COLON"}]
                                [{oxprice price=$wunschtagCosts->getNettoPrice() currency=$currency}])
                            [{else}]
                                ([{oxmultilang ident="MO_DHL__SURCHARGE_GROSS" suffix="COLON"}]
                                [{oxprice price=$wunschtagCosts->getBruttoPrice() currency=$currency}])
                            [{/if}]
                        [{/if}]
                    </span>
                    <ul id="moDHLWunschtag">
                        <li>
                            <input type="radio" name="moDHLWunschtag" id="wunschtag:none" value=""/>
                            <label class="wunschtag--label wunschtag--none wunschpaket--theme-flow"
                                   for="wunschtag:none">[{oxmultilang ident="MO_DHL__NO_WUNSCHTAG"}]</label>
                        </li>
                        [{foreach from=$oView->moDHLGetWunschtagOptions() key="optionId" item="option"}]
                        <li>
                            [{assign var="radioId" value="wunschtag:"|cat:$optionId}]
                            <input type="radio"
                                   name="moDHLWunschtag"
                                   id="[{$radioId}]"
                                   value="[{$optionId}]"
                                   [{if $option.excluded}]disabled="disabled"[{/if}]
                            />
                            <label class="wunschtag--label wunschpaket--theme-flow">
                                [{$option.label}]
                            </label>
                        </li>
                        [{/foreach}]
                    </ul>
                </div>

                [{assign var="location" value=$oView->moDHLGetLocation()}]
                <div class="moDhlWunschpaketServiceOption [{if !$oViewConf->moIsWunschortActivated()}] moDHL--deactivated [{/if}]">
                    <label class="collapsed moDhlWunschpaketServiceLabel" data-toggle="collapse" data-target="#moDHL--wunschort-values">
                        <input type="checkbox" id="moDHLWunschortCheckbox" value=""/>
                        <strong>[{oxmultilang ident="MO_DHL__WUNSCHORT_LABEL_CONTENT"}]</strong>
                        <i class="fa fa-caret-up"></i>
                        <i class="fa fa-caret-down"></i>
                    </label>
                </div>
                <div class="collapse [{if !$oViewConf->moIsWunschortActivated()}]moDHL--deactivated[{/if}]" id="moDHL--wunschort-values">
                    <div class="form-group">
                        <input type="text"
                               maxlength="80"
                               id="moDHLWunschort"
                               class="form-control"
                               name="moDHLWunschort"
                               data-validation-callback-callback="mo_dhl.validatePreferredAddress"
                               placeholder="[{oxmultilang ident="MO_DHL__WUNSCHORT_PLACEHOLDER"}]"
                               value="[{if $location[0] == 'Wunschort'}][{$location[1]}][{/if}]"
                               [{if $location[0] != 'Wunschort' && $location[0]}]disabled="disabled" [{/if}]
                        />
                        <p class="moShowOnError">[{oxmultilang ident="MO_DHL__WRONG_OR_MISSING_INPUT"}]</p>
                    </div>
                </div>
                <div class="moDhlWunschpaketServiceOption [{if !$oViewConf->moIsWunschnachbarActivated()}] moDHL--deactivated [{/if}]">
                    <label class="collapsed moDhlWunschpaketServiceLabel" data-toggle="collapse" data-target="#moDHL--wunschnachbar-values">
                        <input type="checkbox" id="moDHLWunschnachbarCheckbox" value=""/>
                        <strong>[{oxmultilang ident="MO_DHL__WUNSCHNACHBAR_LABEL_CONTENT"}]</strong>
                        <i class="fa fa-caret-up"></i>
                        <i class="fa fa-caret-down"></i>
                    </label>
                </div>
                <div class="collapse [{if !$oViewConf->moIsWunschnachbarActivated()}]moDHL--deactivated[{/if}]" id="moDHL--wunschnachbar-values">
                    <div class="form-group">
                        <input type="text"
                               maxlength="25"
                               id="moDHLWunschnachbarName"
                               class="form-control"
                               name="moDHLWunschnachbarName"
                               data-validation-callback-callback="mo_dhl.validatePreferredAddress"
                               placeholder="[{oxmultilang ident="MO_DHL__WUNSCHNACHBAR_NAME_PLACEHOLDER"}]"
                               value="[{if $location[0] == 'Wunschnachbar'}][{$location[2]}][{/if}]"
                               [{if $location[0] != 'Wunschnachbar' && $location[0]}]disabled="disabled" [{/if}]
                        />
                        <p class="moShowOnError">[{oxmultilang ident="MO_DHL__WRONG_OR_MISSING_INPUT"}]</p>
                    </div>
                    <div class="form-group">
                        <input type="text" style="margin-top: 5px"
                               maxlength="55"
                               id="moDHLWunschnachbarAddress"
                               class="form-control"
                               name="moDHLWunschnachbarAddress"
                               data-validation-callback-callback="mo_dhl.validatePreferredAddress"
                               placeholder="[{oxmultilang ident="MO_DHL__WUNSCHNACHBAR_ADDRESS_PLACEHOLDER"}]"
                               value="[{if $location[0] == 'Wunschnachbar'}][{$location[1]}][{/if}]"
                               [{if $location[0] != 'Wunschnachbar' && $location[0]}]disabled="disabled" [{/if}]
                        />
                        <p class="moShowOnError">[{oxmultilang ident="MO_DHL__WRONG_OR_MISSING_INPUT"}]</p>
                        [{assign var="privacyLink" value=$oViewConf->moGetPrivacyLinkForWunschpaket()}]
                        [{if $privacyLink}]
                        <p class="moDHLPrivacy">
                            <a href="[{$privacyLink}]" target="_blank">
                                [{oxmultilang ident="MO_DHL__PRIVACY_LINK_SHORT"}]
                            </a>
                        </p>
                        [{/if}]
                    </div>
                </div>
            </div>
        </div>
    [{/if}]
</div>
[{capture assign="moNoValidationForDhlDeliveryServices"}]
    [{strip}]
        $('#moDHLWunschpaket').find('input,select,textarea').jqBootstrapValidation('destroy');
    [{/strip}]
[{/capture}]

[{oxscript add=$moNoValidationForDhlDeliveryServices}]