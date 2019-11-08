[{if $module_var == 'mo_dhl__logfiles'}]
    <ul>
        [{foreach from=$oView->moGetLogs() item='logfile'}]
            <li>
                <a href="[{$oViewConf->getSslSelfLink()}]cl=mo_dhl__module_config&fnc=moDownload&log=[{$logfile}]">[{$logfile}]</a>
            </li>
        [{/foreach}]
    </ul>
[{elseif $module_var == 'mo_dhl__excludedPaymentOptions'}]
    <ul>
        [{foreach from=$oView->moGetPaymentOptions() key='oxid' item='payment'}]
            <li>
                <input type="checkbox" id="payment-[{$oxid}]" name="payment[]"
                       value="[{$oxid}]"[{if $payment->oxpayments__mo_dhl_excluded->rawValue}] checked="checked"[{/if}]>
                <label for="payment-[{$oxid}]">[{$payment->oxpayments__oxdesc}]</label>
            </li>
        [{/foreach}]
    </ul>
[{elseif $module_var == 'mo_dhl__excludedDeliverySetOptions'}]
    [{oxmultilang ident="MO_DHL__EXCLUDED_DELIVERYSETOPTIONS_MOVED"}]
[{elseif $module_var == 'mo_dhl__excludedDeliveryOptions'}]
    <ul>
        [{foreach from=$oView->moGetDeliveryOptions() key='oxid' item='delivery'}]
            <li>
                <input type="checkbox" id="delivery-[{$oxid}]" name="delivery[]"
                       value="[{$oxid}]"[{if $delivery->oxdelivery__mo_dhl_excluded->rawValue}] checked="checked"[{/if}]>
                <label for="delivery-[{$oxid}]">[{$delivery->oxdelivery__oxtitle}]</label>
            </li>
        [{/foreach}]
    </ul>
[{elseif $module_var == 'mo_dhl__handing_over_help'}]
[{else}]
    [{$smarty.block.parent}]
[{/if}]
