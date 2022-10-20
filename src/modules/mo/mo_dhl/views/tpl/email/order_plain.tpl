[{if $moDHLSurchargeLabel}][{strip}]
    [{if $oViewConf->isFunctionalityEnabled('blShowVATForDelivery')}]
        [{oxmultilang ident=$moDHLSurchargeLabel suffix='COLON'}] [{oxprice price=$moDHLSurcharge->getNettoPrice() currency=$currency}]
        [{if $basket->isProportionalCalculationOn()}][{oxmultilang ident="BASKET_TOTAL_PLUS_PROPORTIONAL_VAT"}][{else}][{oxmultilang ident="VAT_PLUS_PERCENT_AMOUNT" suffix="COLON" args=$moDHLSurcharge->getVat()}][{/if}][{oxprice price=$moDHLSurcharge->getVatValue() currency=$currency}]
    [{else}]
        [{oxmultilang ident=$moDHLSurchargeLabel suffix='COLON'}] [{oxprice price=$moDHLSurcharge->getBruttoPrice() currency=$currency}]
    [{/if}]
[{/strip}][{/if}]