[{if $module_var == 'mo_dhl__logfiles'}]
    <ul>
        [{foreach from=$oView->moGetLogs() item='logfile'}]
            <li>
                <a href="[{$oViewConf->getSslSelfLink()}]cl=module_config&fnc=moDownload&log=[{$logfile}]">[{$logfile}]</a>
            </li>
        [{/foreach}]
    </ul>
[{elseif $module_var == 'mo_dhl__account_check'}]
    <input type="submit" class="confinput" name="check" value="[{oxmultilang ident="MO_DHL_SAVE_AND_CHECK"}]"
           onClick="Javascript:document.module_configuration.fnc.value='moSaveAndCheckLogin'" [{$readonly}]>
    [{elseif $module_var == 'mo_dhl__internetmarke_check'}]
<input type="submit" class="confinput" name="check" value="[{oxmultilang ident="MO_DHL_SAVE_AND_CHECK"}]"
       onClick="Javascript:document.module_configuration.fnc.value='moSaveAndCheckInternetmarkeLogin'" [{$readonly}]>
[{elseif $module_var == 'mo_dhl__handing_over_help'}]
[{elseif $module_var =='mo_dhl__wunschtag_surcharge_text'}]
    [{assign var="texts" value=$oView->moDHLGetSurchargeTexts($module_var)}]
    <ul>
        [{foreach from=$texts key='lang' item='text'}]
            <li>
                [{$oView->moDHLGetLanguageName($lang)}]
                <input type=text class="txt" style="width: 250px;" name="confarrs[[{$module_var}]][[{$lang}]]"
                       value="[{$text}]"
                       placeholder="[{$oView->moDHLGetPlaceholder($module_var, $lang)}]" [{$readonly}]>
            </li>
        [{/foreach}]
    </ul>
[{elseif $module_var == 'mo_dhl__paketankuendigung_custom'}]
[{else}]
    [{$smarty.block.parent}]
[{/if}]
