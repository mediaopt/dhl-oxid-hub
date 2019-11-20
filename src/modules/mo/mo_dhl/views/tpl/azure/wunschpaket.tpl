<div style="display: none;">
    [{if $oViewConf->moIsAnyWunschpaketFeatureActivated()}]
        <div id="moDHLWunschpaket"
             class="theme--is-azure"
             data-translatenowunschzeit="[{oxmultilang ident='MO_DHL__NO_WUNSCHZEIT'}]"
             data-translatenowunschtag="[{oxmultilang ident='MO_DHL__NO_WUNSCHTAG'}]"
             data-translatefailedblacklist="[{oxmultilang ident='MO_DHL__FAILED_BLACKLIST'}]"
             data-theme="azure" data-timeanddate="[{$oViewConf->getSslSelfLink()}]cl=MoDHLYellowBox&zip=">
            <img src="[{$oViewConf->getModuleUrl("mo_dhl", "out/src/img/DHL_rgb_265px.png")}]"/>

            <h3>[{oxmultilang ident="MO_DHL__WUNSCHPAKET"}]</h3>

            <p>[{oxmultilang ident="MO_DHL__WUNSCHPAKET_DESCRIPTION"}]</p>
            <dl>
                [{capture name="combinedPriceFormatted" assign="combinedPriceFormatted"}]
                    [{assign var="combinedCosts" value=$oView->moDHLGetCostsForCombinedWunschtagAndWunschzeit()}]
                    [{if $oViewConf->isFunctionalityEnabled('blShowVATForDelivery')}]
                        [{oxprice price=$combinedCosts->getNettoPrice() currency=$currency}]
                    [{else}]
                        [{oxprice price=$combinedCosts->getBruttoPrice() currency=$currency}]
                    [{/if}]
                [{/capture}]

                [{capture name="inCombinationWithWunschzeit" assign="inCombinationWithWunschzeit"}]
                    [{if $oViewConf->moIsWunschtagActivated() && $oViewConf->moIsWunschzeitActivated()}]
                        , [{oxmultilang ident="MO_DHL__IN_COMBINATION_WITH_WUNSCHZEIT"}] [{$combinedPriceFormatted|trim}]
                    [{/if}]
                [{/capture}]

                [{capture name="inCombinationWithWunschtag" assign="inCombinationWithWunschtag"}]
                    [{if $oViewConf->moIsWunschtagActivated() && $oViewConf->moIsWunschzeitActivated()}]
                        , [{oxmultilang ident="MO_DHL__IN_COMBINATION_WITH_WUNSCHTAG"}] [{$combinedPriceFormatted|trim}]
                    [{/if}]
                [{/capture}]

                [{assign var="wunschtagCosts" value=$oView->moDHLGetWunschtagCosts()}]
                <dt id="moDHL--wunschtag-info"
                    class="tooltip [{if !$oViewConf->moIsWunschtagActivated()}]moDHL--deactivated[{/if}]">
                    <label>
                        <input type="checkbox" id="moDHLWunschtagCheckbox" value=""/>
                        [{oxmultilang ident="MO_DHL__WUNSCHTAG_LABEL_HEADLINE"}]
                        [{oxmultilang ident="MO_DHL__WUNSCHTAG_LABEL_CONTENT"}]
                        <div class="ttip"
                             data-tooltip="[{oxmultilang ident="MO_DHL__WUNSCHTAG_TOOLTIP"}]"></div>
                        [{if $wunschtagCosts && $wunschtagCosts->getPrice() > 0}]
                            <span class="font-weight--normal">
                            <br/>
                            [{if $oViewConf->isFunctionalityEnabled('blShowVATForDelivery')}]
                                ([{oxmultilang ident="MO_DHL__SURCHARGE_NET" suffix="COLON"}]
                                <span class="text-style--nbsp">
                                    [{oxprice price=$wunschtagCosts->getNettoPrice() currency=$currency}][{$inCombinationWithWunschzeit|trim}])
                                </span>
                            [{else}]
                                ([{oxmultilang ident="MO_DHL__SURCHARGE_GROSS" suffix="COLON"}]
                                <span class="text-style--nbsp">
                                    [{oxprice price=$wunschtagCosts->getBruttoPrice() currency=$currency}][{$inCombinationWithWunschzeit|trim}])
                                </span>
                            [{/if}]
                            </span>
                        [{/if}]
                    </label>
                </dt>
                <dd id="moDHL--wunschtag-values"
                    [{if !$oViewConf->moIsWunschtagActivated()}] class="moDHL--deactivated" [{/if}]>
                    <ul id="moDHLWunschtag">
                        <li>
                            <input type="radio" name="moDHLWunschtag" id="wunschtag:none" value=""/>
                            <label class="wunschtag--label wunschtag--none wunschpaket--theme-azure"
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
                                <label class="wunschtag--label wunschpaket--theme-azure">
                                    [{$option.label}]
                                </label>
                            </li>
                        [{/foreach}]
                    </ul>
                </dd>

                [{assign var="wunschzeitCosts" value=$oView->moDHLGetWunschzeitCosts()}]
                <dt id="moDHL--wunschzeit-info"
                    class="tooltip [{if !$oViewConf->moIsWunschzeitActivated()}]moDHL--deactivated[{/if}]">
                    <label>
                        <input type="checkbox" id="moDHLTimeCheckbox" value=""/>
                        [{oxmultilang ident="MO_DHL__WUNSCHZEIT_LABEL_HEADLINE"}]
                        [{oxmultilang ident="MO_DHL__WUNSCHZEIT_LABEL_CONTENT"}]
                        <div class="ttip"
                             data-tooltip="[{oxmultilang ident="MO_DHL__WUNSCHZEIT_TOOLTIP"}]"></div>
                        [{if $wunschzeitCosts && $wunschzeitCosts->getPrice() > 0}]
                        <span class="font-weight--normal">
                            <br/>
                            [{if $oViewConf->isFunctionalityEnabled('blShowVATForDelivery')}]
                                ([{oxmultilang ident="MO_DHL__SURCHARGE_NET" suffix="COLON"}]
                                <span class="text-style--nbsp">
                                    [{oxprice price=$wunschzeitCosts->getNettoPrice() currency=$currency}][{$inCombinationWithWunschtag|trim}])
                                </span>
                            [{else}]
                                ([{oxmultilang ident="MO_DHL__SURCHARGE_GROSS" suffix="COLON"}]
                                <span class="text-style--nbsp">
                                    [{oxprice price=$wunschzeitCosts->getBruttoPrice() currency=$currency}][{$inCombinationWithWunschtag|trim}])
                                </span>
                            [{/if}]
                        </span>
                        [{/if}]
                    </label>
                </dt>
                <dd id="moDHL--wunschzeit-values"
                    [{if !$oViewConf->moIsWunschzeitActivated()}] class="moDHL--deactivated" [{/if}]>
                    <ul id="moDHLWunschzeit">
                        <li>
                            <input type="radio" name="moDHLTime" id="wunschzeit:none" value=""/>
                            <label class="wunschzeit--label wunschpaket--theme-azure"
                                   for="wunschzeit:none">[{oxmultilang ident="MO_DHL__NO_WUNSCHZEIT"}]</label>
                        </li>
                        [{foreach from=$oView->moDHLGetWunschzeitOptions() key="optionId" item="option"}]
                            <li>
                                [{assign var="radioId" value="option:"|cat:$optionId}]
                                <input type="radio"
                                       name="moDHLTime"
                                       id="[{$radioId}]"
                                       value="[{$optionId}]"
                                />
                                <label class="wunschzeit--label wunschpaket--theme-azure">[{$option}]</label>
                            </li>
                        [{/foreach}]
                    </ul>
                </dd>

                [{assign var="location" value=$oView->moDHLGetLocation()}]
                <dt class="tooltip [{if !$oViewConf->moIsWunschortActivated()}]moDHL--deactivated[{/if}]">
                    <label>
                        <input type="checkbox" id="moDHLWunschortCheckbox" value=""/>
                        [{oxmultilang ident="MO_DHL__WUNSCHORT_LABEL_HEADLINE"}]
                        [{oxmultilang ident="MO_DHL__WUNSCHORT_LABEL_CONTENT"}]
                        <div class="ttip"
                             data-tooltip="[{oxmultilang ident="MO_DHL__WUNSCHORT_TOOLTIP"}]"></div>
                    </label>
                </dt>
                <dd [{if !$oViewConf->moIsWunschortActivated()}] class="moDHL--deactivated" [{/if}]>
                    <input type="text"
                           maxlength="80"
                           id="moDHLWunschort"
                           name="moDHLWunschort"
                           class="js-oxValidate js-oxValidate_preferredWunschort"
                           placeholder="[{oxmultilang ident="MO_DHL__WUNSCHORT_PLACEHOLDER"}]"
                           value="[{if $location[0] == 'Wunschort'}][{$location[1]}][{/if}]"
                           [{if $location[0] != 'Wunschort' && $location[0]}]disabled="disabled" [{/if}]
                    />
                    <p class="moShowOnError">[{oxmultilang ident="MO_DHL__WRONG_OR_MISSING_INPUT"}]</p>
                </dd>
                <dt class="tooltip [{if !$oViewConf->moIsWunschnachbarActivated()}]moDHL--deactivated[{/if}]">
                    <label>
                        <input type="checkbox" id="moDHLWunschnachbarCheckbox" value=""/>
                        [{oxmultilang ident="MO_DHL__WUNSCHNACHBAR_LABEL_HEADLINE"}]
                        [{oxmultilang ident="MO_DHL__WUNSCHNACHBAR_LABEL_CONTENT"}]
                        <div class="ttip"
                             data-tooltip="[{oxmultilang ident="MO_DHL__WUNSCHNACHBAR_TOOLTIP"}]"></div>
                    </label>
                </dt>
                <dd [{if !$oViewConf->moIsWunschnachbarActivated()}] class="moDHL--deactivated" [{/if}]
                        style="margin-bottom: 5px;">
                    <input type="text"
                           maxlength="25"
                           id="moDHLWunschnachbarName"
                           name="moDHLWunschnachbarName"
                           class="js-oxValidate js-oxValidate_preferredNeighboursName"
                           placeholder="[{oxmultilang ident="MO_DHL__WUNSCHNACHBAR_NAME_PLACEHOLDER"}]"
                           value="[{if $location[0] == 'Wunschnachbar'}][{$location[2]}][{/if}]"
                           [{if $location[0] != 'Wunschnachbar' && $location[0]}]disabled="disabled" [{/if}]
                    />
                    <p class="moShowOnError">[{oxmultilang ident="MO_DHL__WRONG_OR_MISSING_INPUT"}]</p>
                </dd>
                <dd [{if !$oViewConf->moIsWunschnachbarActivated()}] class="moDHL--deactivated" [{/if}]>
                    <input type="text"
                           maxlength="55"
                           id="moDHLWunschnachbarAddress"
                           name="moDHLWunschnachbarAddress"
                           class="js-oxValidate js-oxValidate_preferredNeighboursAddress"
                           placeholder="[{oxmultilang ident="MO_DHL__WUNSCHNACHBAR_ADDRESS_PLACEHOLDER"}]"
                           value="[{if $location[0] == 'Wunschnachbar'}][{$location[1]}][{/if}]"
                           [{if $location[0] != 'Wunschnachbar' && $location[0]}]disabled="disabled"[{/if}]
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
                </dd>
            </dl>
        </div>
    [{/if}]
</div>
