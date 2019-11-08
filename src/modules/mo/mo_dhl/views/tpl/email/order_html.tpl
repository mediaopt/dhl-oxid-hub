[{if $moDHLSurchargeLabel}]
    [{if $oViewConf->moHasAncestorTheme('azure')}]
        [{if $oViewConf->isFunctionalityEnabled('blShowVATForDelivery')}]
            <tr valign="top">
                <td style="padding: 5px; border-bottom: 1px solid #ccc;">
                    <p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0;">
                        [{oxmultilang ident=$moDHLSurchargeLabel suffix='COLON'}]
                    </p>
                </td>
                <td style="padding: 5px; border-bottom: 1px solid #ccc;" align="right">
                    <p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0;">
                        [{oxprice price=$moDHLSurcharge->getNettoPrice() currency=$currency}]
                    </p>
                </td>
            </tr>
            [{if $moDHLSurcharge->getVatValue()}]
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
                                [{oxmultilang ident="VAT_PLUS_PERCENT_AMOUNT" suffix="COLON" args=$moDHLSurcharge->getVat()}]
                            </p>
                        </td>
                    [{/if}]
                    <td style="padding: 5px; border-bottom: 2px solid #ddd;" align="right">
                        <p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0;">
                            [{oxprice price=$moDHLSurcharge->getVatValue() currency=$currency}]
                        </p>
                    </td>
                </tr>
            [{/if}]
        [{else}]
            <tr valign="top">
                <td style="padding: 5px; border-bottom: 2px solid #ccc;">
                    <p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0;">
                        [{oxmultilang ident=$moDHLSurchargeLabel suffix='COLON'}]
                    </p>
                </td>
                <td style="padding: 5px; border-bottom: 2px solid #ccc;" align="right">
                    <p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0;">
                        [{oxprice price=$moDHLSurcharge->getBruttoPrice() currency=$currency}]
                    </p>
                </td>
            </tr>
        [{/if}]
    [{elseif $oViewConf->moHasAncestorTheme('flow') || $oViewConf->moHasAncestorTheme('wave')}]
        [{if $oViewConf->isFunctionalityEnabled('blShowVATForDelivery')}]
            <tr valign="top" bgcolor="#ebebeb">
                <td colspan="[{$iFooterColspan}]"
                    class="odd text-right">[{oxmultilang ident=$moDHLSurchargeLabel}]</td>
                <td align="right"
                    class="odd text-right">[{oxprice price=$moDHLSurcharge->getNettoPrice() currency=$currency}]</td>
            </tr>
            [{if $moDHLSurcharge->getVatValue()}]
                <tr valign="top" bgcolor="#ebebeb">
                    [{if $basket->isProportionalCalculationOn()}]
                        <td colspan="[{$iFooterColspan}]"
                            class="odd text-right">[{oxmultilang ident="BASKET_TOTAL_PLUS_PROPORTIONAL_VAT"}]:
                        </td>
                    [{else}]
                        <td colspan="[{$iFooterColspan}]"
                            class="odd text-right">[{oxmultilang ident="PLUS_VAT"}] [{$moDHLSurcharge->getVat()}][{oxmultilang ident="SHIPPING_VAT2"}]</td>
                    [{/if}]
                    <td align="right"
                        class="odd text-right">[{oxprice price=$moDHLSurcharge->getVatValue() currency=$currency}]</td>
                </tr>
            [{/if}]
        [{else}]
            <tr valign="top" bgcolor="#ebebeb">
                <td colspan="[{$iFooterColspan}]"
                    class="odd text-right">[{oxmultilang ident=$moDHLSurchargeLabel}]</td>
                <td align="right"
                    class="odd text-right">[{oxprice price=$moDHLSurcharge->getBruttoPrice() currency=$currency}]</td>
            </tr>
        [{/if}]
    [{/if}]
[{/if}]
