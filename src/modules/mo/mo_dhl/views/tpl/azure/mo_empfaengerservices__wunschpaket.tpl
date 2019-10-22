<div style="display: none;">
    [{if $oViewConf->moIsAnyWunschpaketFeatureActivated()}]
        <div id="moEmpfaengerservicesWunschpaket"
             class="theme--is-azure"
             data-translatenowunschzeit="[{oxmultilang ident='MO_EMPFAENGERSERVICES__NO_WUNSCHZEIT'}]"
             data-translatenowunschtag="[{oxmultilang ident='MO_EMPFAENGERSERVICES__NO_WUNSCHTAG'}]"
             data-theme="azure" data-timeanddate="[{$oViewConf->getSslSelfLink()}]cl=MoEmpfaengerservicesYellowBox&zip=">
            <img src="[{$oViewConf->getModuleUrl("mo_empfaengerservices", "out/src/img/DHL_rgb_265px.png")}]"/>

            <h3>[{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHPAKET"}]</h3>

            <p>[{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHPAKET_DESCRIPTION"}]</p>
            <dl>
                [{capture name="combinedPriceFormatted" assign="combinedPriceFormatted"}]
                    [{assign var="combinedCosts" value=$oView->mo_empfaengerservices__getCostsForCombinedWunschtagAndWunschzeit()}]
                    [{if $oViewConf->isFunctionalityEnabled('blShowVATForDelivery')}]
                        [{oxprice price=$combinedCosts->getNettoPrice() currency=$currency}]
                    [{else}]
                        [{oxprice price=$combinedCosts->getBruttoPrice() currency=$currency}]
                    [{/if}]
                [{/capture}]

                [{capture name="inCombinationWithWunschzeit" assign="inCombinationWithWunschzeit"}]
                    [{if $oViewConf->moIsWunschtagActivated() && $oViewConf->moIsWunschzeitActivated()}]
                        , [{oxmultilang ident="MO_EMPFAENGERSERVICES__IN_COMBINATION_WITH_WUNSCHZEIT"}] [{$combinedPriceFormatted|trim}]
                    [{/if}]
                [{/capture}]

                [{capture name="inCombinationWithWunschtag" assign="inCombinationWithWunschtag"}]
                    [{if $oViewConf->moIsWunschtagActivated() && $oViewConf->moIsWunschzeitActivated()}]
                        , [{oxmultilang ident="MO_EMPFAENGERSERVICES__IN_COMBINATION_WITH_WUNSCHTAG"}] [{$combinedPriceFormatted|trim}]
                    [{/if}]
                [{/capture}]

                [{assign var="wunschtagCosts" value=$oView->mo_empfaengerservices__getWunschtagCosts()}]
                <dt id="moEmpfaengerservices--wunschtag-info"
                    class="tooltip [{if !$oViewConf->moIsWunschtagActivated()}]moEmpfaengerservices--deactivated[{/if}]">
                    <label>
                        <input type="checkbox" id="moEmpfaengerservicesWunschtagCheckbox" value=""/>
                        [{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHTAG_LABEL_HEADLINE"}]
                        [{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHTAG_LABEL_CONTENT"}]
                        <div class="ttip"
                             data-tooltip="[{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHTAG_TOOLTIP"}]"></div>
                        [{if $wunschtagCosts && $wunschtagCosts->getPrice() > 0}]
                            <span class="font-weight--normal">
                            <br/>
                            [{if $oViewConf->isFunctionalityEnabled('blShowVATForDelivery')}]
                                ([{oxmultilang ident="MO_EMPFAENGERSERVICES__SURCHARGE_NET" suffix="COLON"}]
                                <span class="text-style--nbsp">
                                    [{oxprice price=$wunschtagCosts->getNettoPrice() currency=$currency}][{$inCombinationWithWunschzeit|trim}])
                                </span>
                            [{else}]
                                ([{oxmultilang ident="MO_EMPFAENGERSERVICES__SURCHARGE_GROSS" suffix="COLON"}]
                                <span class="text-style--nbsp">
                                    [{oxprice price=$wunschtagCosts->getBruttoPrice() currency=$currency}][{$inCombinationWithWunschzeit|trim}])
                                </span>
                            [{/if}]
                            </span>
                        [{/if}]
                    </label>
                </dt>
                <dd id="moEmpfaengerservices--wunschtag-values"
                    [{if !$oViewConf->moIsWunschtagActivated()}] class="moEmpfaengerservices--deactivated" [{/if}]>
                    <ul id="moEmpfaengerservicesWunschtag">
                        <li>
                            <input type="radio" name="moEmpfaengerservicesWunschtag" id="wunschtag:none" value=""/>
                            <label class="wunschtag--label wunschtag--none wunschpaket--theme-azure"
                                   for="wunschtag:none">[{oxmultilang ident="MO_EMPFAENGERSERVICES__NO_WUNSCHTAG"}]</label>
                        </li>
                        [{foreach from=$oView->mo_empfaengerservices__getWunschtagOptions() key="optionId" item="option"}]
                            <li>
                                [{assign var="radioId" value="wunschtag:"|cat:$optionId}]
                                <input type="radio"
                                       name="moEmpfaengerservicesWunschtag"
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

                [{assign var="wunschzeitCosts" value=$oView->mo_empfaengerservices__getWunschzeitCosts()}]
                <dt id="moEmpfaengerservices--wunschzeit-info"
                    class="tooltip [{if !$oViewConf->moIsWunschzeitActivated()}]moEmpfaengerservices--deactivated[{/if}]">
                    <label>
                        <input type="checkbox" id="moEmpfaengerservicesTimeCheckbox" value=""/>
                        [{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHZEIT_LABEL_HEADLINE"}]
                        [{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHZEIT_LABEL_CONTENT"}]
                        <div class="ttip"
                             data-tooltip="[{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHZEIT_TOOLTIP"}]"></div>
                        [{if $wunschzeitCosts && $wunschzeitCosts->getPrice() > 0}]
                        <span class="font-weight--normal">
                            <br/>
                            [{if $oViewConf->isFunctionalityEnabled('blShowVATForDelivery')}]
                                ([{oxmultilang ident="MO_EMPFAENGERSERVICES__SURCHARGE_NET" suffix="COLON"}]
                                <span class="text-style--nbsp">
                                    [{oxprice price=$wunschzeitCosts->getNettoPrice() currency=$currency}][{$inCombinationWithWunschtag|trim}])
                                </span>
                            [{else}]
                                ([{oxmultilang ident="MO_EMPFAENGERSERVICES__SURCHARGE_GROSS" suffix="COLON"}]
                                <span class="text-style--nbsp">
                                    [{oxprice price=$wunschzeitCosts->getBruttoPrice() currency=$currency}][{$inCombinationWithWunschtag|trim}])
                                </span>
                            [{/if}]
                        </span>
                        [{/if}]
                    </label>
                </dt>
                <dd id="moEmpfaengerservices--wunschzeit-values"
                    [{if !$oViewConf->moIsWunschzeitActivated()}] class="moEmpfaengerservices--deactivated" [{/if}]>
                    <ul id="moEmpfaengerservicesWunschzeit">
                        <li>
                            <input type="radio" name="moEmpfaengerservicesTime" id="wunschzeit:none" value=""/>
                            <label class="wunschzeit--label wunschpaket--theme-azure"
                                   for="wunschzeit:none">[{oxmultilang ident="MO_EMPFAENGERSERVICES__NO_WUNSCHZEIT"}]</label>
                        </li>
                        [{foreach from=$oView->mo_empfaengerservices__getWunschzeitOptions() key="optionId" item="option"}]
                            <li>
                                [{assign var="radioId" value="option:"|cat:$optionId}]
                                <input type="radio"
                                       name="moEmpfaengerservicesTime"
                                       id="[{$radioId}]"
                                       value="[{$optionId}]"
                                />
                                <label class="wunschzeit--label wunschpaket--theme-azure">[{$option}]</label>
                            </li>
                        [{/foreach}]
                    </ul>
                </dd>

                [{assign var="location" value=$oView->mo_empfaengerservices__getLocation()}]
                <dt class="tooltip [{if !$oViewConf->moIsWunschortActivated()}]moEmpfaengerservices--deactivated[{/if}]">
                    <label>
                        <input type="checkbox" id="moEmpfaengerservicesWunschortCheckbox" value=""/>
                        [{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHORT_LABEL_HEADLINE"}]
                        [{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHORT_LABEL_CONTENT"}]
                        <div class="ttip"
                             data-tooltip="[{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHORT_TOOLTIP"}]"></div>
                    </label>
                </dt>
                <dd [{if !$oViewConf->moIsWunschortActivated()}] class="moEmpfaengerservices--deactivated" [{/if}]>
                    <input type="text"
                           maxlength="80"
                           id="moEmpfaengerservicesWunschort"
                           name="moEmpfaengerservicesWunschort"
                           class="js-oxValidate js-oxValidate_preferredWunschort"
                           placeholder="[{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHORT_PLACEHOLDER"}]"
                           value="[{if $location[0] == 'Wunschort'}][{$location[1]}][{/if}]"
                           [{if $location[0] != 'Wunschort' && $location[0]}]disabled="disabled" [{/if}]
                    />
                    <p class="moShowOnError">[{oxmultilang ident="MO_EMPFAENGERSERVICES__WRONG_OR_MISSING_INPUT"}]</p>
                </dd>
                <dt class="tooltip [{if !$oViewConf->moIsWunschnachbarActivated()}]moEmpfaengerservices--deactivated[{/if}]">
                    <label>
                        <input type="checkbox" id="moEmpfaengerservicesWunschnachbarCheckbox" value=""/>
                        [{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHNACHBAR_LABEL_HEADLINE"}]
                        [{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHNACHBAR_LABEL_CONTENT"}]
                        <div class="ttip"
                             data-tooltip="[{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHNACHBAR_TOOLTIP"}]"></div>
                    </label>
                </dt>
                <dd [{if !$oViewConf->moIsWunschnachbarActivated()}] class="moEmpfaengerservices--deactivated" [{/if}]
                        style="margin-bottom: 5px;">
                    <input type="text"
                           maxlength="25"
                           id="moEmpfaengerservicesWunschnachbarName"
                           name="moEmpfaengerservicesWunschnachbarName"
                           class="js-oxValidate js-oxValidate_preferredNeighboursName"
                           placeholder="[{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHNACHBAR_NAME_PLACEHOLDER"}]"
                           value="[{if $location[0] == 'Wunschnachbar'}][{$location[2]}][{/if}]"
                           [{if $location[0] != 'Wunschnachbar' && $location[0]}]disabled="disabled" [{/if}]
                    />
                    <p class="moShowOnError">[{oxmultilang ident="MO_EMPFAENGERSERVICES__WRONG_OR_MISSING_INPUT"}]</p>
                </dd>
                <dd [{if !$oViewConf->moIsWunschnachbarActivated()}] class="moEmpfaengerservices--deactivated" [{/if}]>
                    <input type="text"
                           maxlength="55"
                           id="moEmpfaengerservicesWunschnachbarAddress"
                           name="moEmpfaengerservicesWunschnachbarAddress"
                           class="js-oxValidate js-oxValidate_preferredNeighboursAddress"
                           placeholder="[{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHNACHBAR_ADDRESS_PLACEHOLDER"}]"
                           value="[{if $location[0] == 'Wunschnachbar'}][{$location[1]}][{/if}]"
                           [{if $location[0] != 'Wunschnachbar' && $location[0]}]disabled="disabled"[{/if}]
                    />
                    <p class="moShowOnError">[{oxmultilang ident="MO_EMPFAENGERSERVICES__WRONG_OR_MISSING_INPUT"}]</p>
                    [{assign var="privacyLink" value=$oViewConf->moGetPrivacyLinkForWunschpaket()}]
                    [{if $privacyLink}]
                        <p class="moEmpfaengerservicesPrivacy">
                            <a href="[{$privacyLink}]" target="_blank">
                                [{oxmultilang ident="MO_EMPFAENGERSERVICES__PRIVACY_LINK_SHORT"}]
                            </a>
                        </p>
                    [{/if}]
                </dd>
            </dl>
        </div>
    [{/if}]
</div>
