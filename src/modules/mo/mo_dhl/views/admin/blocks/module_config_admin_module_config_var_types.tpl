[{if $module_var == 'mo_empfaengerservices__logfiles'}]
    <ul>
        [{foreach from=$oView->moGetLogs() item='logfile'}]
            <li>
                <a href="[{$oViewConf->getSslSelfLink()}]cl=mo_empfaengerservices__module_config&fnc=moDownload&log=[{$logfile}]">[{$logfile}]</a>
            </li>
        [{/foreach}]
    </ul>
[{elseif $module_var == 'mo_empfaengerservices__excludedPaymentOptions'}]
    <ul>
        [{foreach from=$oView->moGetPaymentOptions() key='oxid' item='payment'}]
            <li>
                <input type="checkbox" id="payment-[{$oxid}]" name="payment[]"
                       value="[{$oxid}]"[{if $payment->oxpayments__mo_empfaengerservices_excluded->rawValue}] checked="checked"[{/if}]>
                <label for="payment-[{$oxid}]">[{$payment->oxpayments__oxdesc}]</label>
            </li>
        [{/foreach}]
    </ul>
[{elseif $module_var == 'mo_empfaengerservices__excludedDeliverySetOptions'}]
    <ul>
        [{foreach from=$oView->moGetDeliverySetOptions() key='oxid' item='delivery'}]
            <li>
                <input type="checkbox" id="deliveryset-[{$oxid}]" name="deliveryset[]"
                       value="[{$oxid}]"[{if $delivery->oxdeliveryset__mo_empfaengerservices_excluded->rawValue}] checked="checked"[{/if}]>
                <label for="deliveryset-[{$oxid}]">[{$delivery->oxdeliveryset__oxtitle}]</label>
            </li>
        [{/foreach}]
    </ul>
[{elseif $module_var == 'mo_empfaengerservices__excludedDeliveryOptions'}]
    <ul>
        [{foreach from=$oView->moGetDeliveryOptions() key='oxid' item='delivery'}]
            <li>
                <input type="checkbox" id="delivery-[{$oxid}]" name="delivery[]"
                       value="[{$oxid}]"[{if $delivery->oxdelivery__mo_empfaengerservices_excluded->rawValue}] checked="checked"[{/if}]>
                <label for="delivery-[{$oxid}]">[{$delivery->oxdelivery__oxtitle}]</label>
            </li>
        [{/foreach}]
    </ul>
[{elseif $module_var == 'mo_empfaengerservices__handing_over_help'}]
[{elseif $module_var == 'mo_empfaengerservices__processAndParticipation'}]
    <ul>
        [{foreach from=$oView->moGetDeliveryOptions() key='oxid' item='delivery'}]
            <li>
                <label for="processIdentifier-[{$oxid}]">[{$delivery->oxdeliveryset__oxtitle}]:</label>
                <br/>
                <select id="processIdentifier-[{$oxid}]" name="processIdentifier[[{$oxid}]]">
                    <option selected disabled>[{oxmultilang ident="MO_EMPFAENGERSERVICES__PROCESS_IDENTIFIER"}]</option>
                    <option value="">-</option>
                    [{foreach from=$processes key='identifier' item='label'}]
                        <option value="[{$identifier}]"[{if $identifier === $delivery->oxdeliveryset__mo_empfaengerservices_process->rawValue}] selected[{/if}]>
                            [{$label}]
                        </option>
                    [{/foreach}]
                </select>
                <input name="participationNumber[[{$oxid}]]" maxlength="2"
                       placeholder="[{oxmultilang ident="MO_EMPFAENGERSERVICES__PARTICIPATION_NUMBER"}]"
                       value="[{$delivery->oxdeliveryset__mo_empfaengerservices_participation->rawValue}]"
                />
            </li>
        [{/foreach}]
    </ul>
[{else}]
    [{$smarty.block.parent}]
[{/if}]
