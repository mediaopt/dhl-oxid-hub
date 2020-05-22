[{assign var="wunschtagCosts" value=$oxcmp_basket->moDHLGetWunschtagCosts()}]

[{assign var="moWunschtagText" value=$oView->moDHLGetSurchargeTranslation('mo_dhl__wunschtag_surcharge_text')}]

[{if $wunschtagCosts && $wunschtagCosts->getPrice() >= 0.01}]
    [{if $oViewConf->isFunctionalityEnabled('blShowVATForDelivery')}]
        <tr>
            <th class="text-right">[{$moWunschtagText}]&colon;</th class="text-right">
            <td id="moDHLWunschtagCosts" class="text-right">
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
            <th class="text-right">[{$moWunschtagText}]&colon;</th class="text-right">
            <td id="moDHLWunschtagCosts" class="text-right">
                [{oxprice price=$wunschtagCosts->getBruttoPrice() currency=$currency}]
            </td>
        </tr>
    [{/if}]
[{/if}]
