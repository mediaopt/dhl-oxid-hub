[{assign var="wunschtagCosts" value=$oxcmp_basket->moDHLGetWunschtagCosts()}]
[{assign var="wunschzeitCosts" value=$oxcmp_basket->moDHLGetWunschzeitCosts()}]
[{assign var="combinedCosts" value=$oxcmp_basket->moDHLGetCostsForCombinedWunschtagAndWunschzeit()}]

[{if $combinedCosts && $combinedCosts->getPrice() >= 0.01}]
    [{if $oViewConf->isFunctionalityEnabled('blShowVATForDelivery')}]
        <tr>
            <th class="text-right">[{oxmultilang ident="MO_DHL__COMBINATION_SURCHARGE_NET" suffix="COLON"}]</th class="text-right">
            <td id="moEmpfaengerservicesWunschtagCosts" class="text-right">
                [{oxprice price=$combinedCosts->getNettoPrice() currency=$currency}]
            </td>
        </tr>
        [{if $combinedCosts->getVatValue()}]
            <tr>
                <th class="text-right">
                    [{if $oxcmp_basket->isProportionalCalculationOn()}]
                        [{oxmultilang ident="BASKET_TOTAL_PLUS_PROPORTIONAL_VAT" suffix="COLON"}]
                    [{else}]
                        [{oxmultilang ident="VAT_PLUS_PERCENT_AMOUNT" suffix="COLON" args=$combinedCosts->getVat()}]
                    [{/if}]
                </th class="text-right">
                <td class="text-right">[{oxprice price=$combinedCosts->getVatValue() currency=$currency}]</td>
            </tr>
        [{/if}]
    [{else}]
        <tr>
            <th class="text-right">[{oxmultilang ident="MO_DHL__COMBINATION_SURCHARGE_GROSS" suffix="COLON"}]</th class="text-right">
            <td id="moEmpfaengerservicesWunschtagCosts" class="text-right">
                [{oxprice price=$combinedCosts->getBruttoPrice() currency=$currency}]
            </td>
        </tr>
    [{/if}]
[{elseif $wunschtagCosts && $wunschtagCosts->getPrice() >= 0.01}]
    [{if $oViewConf->isFunctionalityEnabled('blShowVATForDelivery')}]
        <tr>
            <th class="text-right">[{oxmultilang ident="MO_DHL__WUNSCHTAG_COSTS_NET" suffix="COLON"}]</th class="text-right">
            <td id="moEmpfaengerservicesWunschtagCosts" class="text-right">
                [{oxprice price=$wunschtagCosts->getNettoPrice() currency=$currency}]
            </td>
        </tr>
        [{if $wunschtagCosts->getVatValue()}]
            <tr>
                <th class="text-right">
                    [{if $oxcmp_basket->isProportionalCalculationOn()}]
                        [{oxmultilang ident="BASKET_TOTAL_PLUS_PROPORTIONAL_VAT" suffix="COLON"}]
                    [{else}]
                        [{oxmultilang ident="VAT_PLUS_PERCENT_AMOUNT" suffix="COLON" args=$wunschtagCosts->getVat()}]
                    [{/if}]
                </th class="text-right">
                <td class="text-right">[{oxprice price=$wunschtagCosts->getVatValue() currency=$currency}]</td>
            </tr>
        [{/if}]
    [{else}]
        <tr>
            <th class="text-right">[{oxmultilang ident="MO_DHL__WUNSCHTAG_COSTS_GROSS" suffix="COLON"}]</th class="text-right">
            <td id="moEmpfaengerservicesWunschtagCosts" class="text-right">
                [{oxprice price=$wunschtagCosts->getBruttoPrice() currency=$currency}]
            </td>
        </tr>
    [{/if}]
[{elseif $wunschzeitCosts && $wunschzeitCosts->getPrice() >= 0.01}]
    [{if $oViewConf->isFunctionalityEnabled('blShowVATForDelivery')}]
        <tr>
            <th class="text-right">[{oxmultilang ident="MO_DHL__WUNSCHZEIT_COSTS_NET" suffix="COLON"}]</th class="text-right">
            <td id="moEmpfaengerservicesWunschzeitCosts" class="text-right">
                [{oxprice price=$wunschzeitCosts->getNettoPrice() currency=$currency}]
            </td>
        </tr>
        [{if $wunschzeitCosts->getVatValue()}]
            <tr>
                <th class="text-right">
                    [{if $oxcmp_basket->isProportionalCalculationOn()}]
                        [{oxmultilang ident="BASKET_TOTAL_PLUS_PROPORTIONAL_VAT" suffix="COLON"}]
                    [{else}]
                        [{oxmultilang ident="VAT_PLUS_PERCENT_AMOUNT" suffix="COLON" args=$wunschzeitCosts->getVat()}]
                    [{/if}]
                </th class="text-right">
                <td class="text-right">[{oxprice price=$wunschzeitCosts->getVatValue() currency=$currency}]</td>
            </tr>
        [{/if}]
    [{else}]
        <tr>
            <th class="text-right">[{oxmultilang ident="MO_DHL__WUNSCHZEIT_COSTS_GROSS" suffix="COLON"}]</th class="text-right">
            <td id="moEmpfaengerservicesWunschzeitCosts" class="text-right">
                [{oxprice price=$wunschzeitCosts->getBruttoPrice() currency=$currency}]
            </td>
        </tr>
    [{/if}]
[{/if}]
