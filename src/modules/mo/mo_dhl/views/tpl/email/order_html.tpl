[{if $moEmpfaengerservicesSurchargeLabel}]
    [{if $oViewConf->moHasAncestorTheme('azure')}]
        [{if $oViewConf->isFunctionalityEnabled('blShowVATForDelivery')}]
            <tr valign="top">
                <td style="padding: 5px; border-bottom: 1px solid #ccc;">
                    <p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0;">
                        [{oxmultilang ident=$moEmpfaengerservicesSurchargeLabel suffix='COLON'}]
                    </p>
                </td>
                <td style="padding: 5px; border-bottom: 1px solid #ccc;" align="right">
                    <p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0;">
                        [{oxprice price=$moEmpfaengerservicesSurcharge->getNettoPrice() currency=$currency}]
                    </p>
                </td>
            </tr>
            [{if $moEmpfaengerservicesSurcharge->getVatValue()}]
                <tr valign="top">
                    [{if $basket->isProportionalCalculationOn()}]
                        <td style="padding: 5px; border-bottom: 2px solid #ccc;">
                            <p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0;">
                                [{oxmultilang ident="BASKET_TOTAL_PLUS_PROPORTIONAL_VAT" suffix="COLON"}]
                            </p>
                        </td>
                    [{else}]
                        <td style="padding: 5px; border-bottom: 2px solid #ccc;">
                            <p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0;">
                                [{oxmultilang ident="VAT_PLUS_PERCENT_AMOUNT" suffix="COLON" args=$moEmpfaengerservicesSurcharge->getVat()}]
                            </p>
                        </td>
                    [{/if}]
                    <td style="padding: 5px; border-bottom: 2px solid #ddd;" align="right">
                        <p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0;">
                            [{oxprice price=$moEmpfaengerservicesSurcharge->getVatValue() currency=$currency}]
                        </p>
                    </td>
                </tr>
            [{/if}]
        [{else}]
            <tr valign="top">
                <td style="padding: 5px; border-bottom: 2px solid #ccc;">
                    <p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0;">
                        [{oxmultilang ident=$moEmpfaengerservicesSurchargeLabel suffix='COLON'}]
                    </p>
                </td>
                <td style="padding: 5px; border-bottom: 2px solid #ccc;" align="right">
                    <p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0;">
                        [{oxprice price=$moEmpfaengerservicesSurcharge->getBruttoPrice() currency=$currency}]
                    </p>
                </td>
            </tr>
        [{/if}]
    [{elseif $oViewConf->moHasAncestorTheme('flow') || $oViewConf->moHasAncestorTheme('wave')}]
        [{if $oViewConf->isFunctionalityEnabled('blShowVATForDelivery')}]
            <tr valign="top" bgcolor="#ebebeb">
                <td colspan="[{$iFooterColspan}]"
                    class="odd text-right">[{oxmultilang ident=$moEmpfaengerservicesSurchargeLabel}]</td>
                <td align="right"
                    class="odd text-right">[{oxprice price=$moEmpfaengerservicesSurcharge->getNettoPrice() currency=$currency}]</td>
            </tr>
            [{if $moEmpfaengerservicesSurcharge->getVatValue()}]
                <tr valign="top" bgcolor="#ebebeb">
                    [{if $basket->isProportionalCalculationOn()}]
                        <td colspan="[{$iFooterColspan}]"
                            class="odd text-right">[{oxmultilang ident="BASKET_TOTAL_PLUS_PROPORTIONAL_VAT"}]:
                        </td>
                    [{else}]
                        <td colspan="[{$iFooterColspan}]"
                            class="odd text-right">[{oxmultilang ident="PLUS_VAT"}] [{$moEmpfaengerservicesSurcharge->getVat()}][{oxmultilang ident="SHIPPING_VAT2"}]</td>
                    [{/if}]
                    <td align="right"
                        class="odd text-right">[{oxprice price=$moEmpfaengerservicesSurcharge->getVatValue() currency=$currency}]</td>
                </tr>
            [{/if}]
        [{else}]
            <tr valign="top" bgcolor="#ebebeb">
                <td colspan="[{$iFooterColspan}]"
                    class="odd text-right">[{oxmultilang ident=$moEmpfaengerservicesSurchargeLabel}]</td>
                <td align="right"
                    class="odd text-right">[{oxprice price=$moEmpfaengerservicesSurcharge->getBruttoPrice() currency=$currency}]</td>
            </tr>
        [{/if}]
    [{/if}]
[{/if}]
