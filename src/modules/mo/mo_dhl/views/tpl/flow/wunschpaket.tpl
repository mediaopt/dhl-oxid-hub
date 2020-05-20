<div style="display: none">
    [{if $oViewConf->moIsAnyWunschpaketFeatureActivated()}]
        <div id="moDHLWunschpaket" class="moDHLWunschpaketFlow col-lg-offset-3"
             data-translatenowunschtag="[{oxmultilang ident='MO_DHL__NO_WUNSCHTAG'}]"
             data-translatefailedblacklist="[{oxmultilang ident='MO_DHL__FAILED_BLACKLIST'}]"
             data-theme="flow" data-dateajax="[{$oViewConf->getSslSelfLink()}]cl=MoDHLYellowBox&zip=">
            <img src="[{$oViewConf->getModuleURL("mo_dhl", "out/src/img/DHL_rgb_265px.png")}]"/>

            <h3>[{oxmultilang ident="MO_DHL__WUNSCHPAKET"}]</h3>

            <p>[{oxmultilang ident="MO_DHL__WUNSCHPAKET_DESCRIPTION"}]</p>

            <dl>
                [{assign var="wunschtagCosts" value=$oView->moDHLGetWunschtagCosts()}]
                <dt id="moDHL--wunschtag-info"
                        [{if !$oViewConf->moIsWunschtagActivated()}] class="moDHL--deactivated" [{/if}]>
                    <label>
                        <input type="checkbox" id="moDHLWunschtagCheckbox" value=""/>
                        <strong>[{oxmultilang ident="MO_DHL__WUNSCHTAG_LABEL_HEADLINE"}]
                            [{oxmultilang ident="MO_DHL__WUNSCHTAG_LABEL_CONTENT"}]</strong>
                        <div class="ttip"
                             data-tooltip="[{oxmultilang ident="MO_DHL__WUNSCHTAG_TOOLTIP"}]"></div>
                        [{if $wunschtagCosts && $wunschtagCosts->getPrice() > 0}]
                            <br/>
                            [{if $oViewConf->isFunctionalityEnabled('blShowVATForDelivery')}]
                                ([{oxmultilang ident="MO_DHL__SURCHARGE_NET" suffix="COLON"}]
                                [{oxprice price=$wunschtagCosts->getNettoPrice() currency=$currency}])
                            [{else}]
                                ([{oxmultilang ident="MO_DHL__SURCHARGE_GROSS" suffix="COLON"}]
                                [{oxprice price=$wunschtagCosts->getBruttoPrice() currency=$currency}])
                            [{/if}]
                        [{/if}]
                    </label>
                </dt>
                <dd id="moDHL--wunschtag-values"
                    [{if !$oViewConf->moIsWunschtagActivated()}] class="moDHL--deactivated" [{/if}]>
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
                </dd>

                [{assign var="location" value=$oView->moDHLGetLocation()}]
                <dt [{if !$oViewConf->moIsWunschortActivated()}] class="moDHL--deactivated" [{/if}]>
                    <label>
                        <input type="checkbox" id="moDHLWunschortCheckbox" value=""/>
                        <strong>[{oxmultilang ident="MO_DHL__WUNSCHORT_LABEL_HEADLINE"}]
                        [{oxmultilang ident="MO_DHL__WUNSCHORT_LABEL_CONTENT"}]</strong>
                        <div class="ttip"
                             data-tooltip="[{oxmultilang ident="MO_DHL__WUNSCHORT_TOOLTIP"}]"></div>
                    </label>
                </dt>
                <dd [{if !$oViewConf->moIsWunschortActivated()}] class="moDHL--deactivated" [{/if}]>
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
                </dd>
                <dt [{if !$oViewConf->moIsWunschnachbarActivated()}] class="moDHL--deactivated" [{/if}]>
                    <label>
                        <input type="checkbox" id="moDHLWunschnachbarCheckbox" value=""/>
                        <strong>[{oxmultilang ident="MO_DHL__WUNSCHNACHBAR_LABEL_HEADLINE"}]
                        [{oxmultilang ident="MO_DHL__WUNSCHNACHBAR_LABEL_CONTENT"}]</strong>
                        <div class="ttip"
                             data-tooltip="[{oxmultilang ident="MO_DHL__WUNSCHNACHBAR_TOOLTIP"}]"></div>
                    </label>
                </dt>
                <dd [{if !$oViewConf->moIsWunschnachbarActivated()}] class="moDHL--deactivated" [{/if}]>
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
                </dd>
            </dl>
        </div>
    [{/if}]
</div>
