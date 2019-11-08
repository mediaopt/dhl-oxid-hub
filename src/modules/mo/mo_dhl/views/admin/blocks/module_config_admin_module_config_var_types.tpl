[{if $module_var == 'mo_dhl__logfiles'}]
    <ul>
        [{foreach from=$oView->moGetLogs() item='logfile'}]
            <li>
                <a href="[{$oViewConf->getSslSelfLink()}]cl=mo_dhl__module_config&fnc=moDownload&log=[{$logfile}]">[{$logfile}]</a>
            </li>
        [{/foreach}]
    </ul>
[{elseif $module_var == 'mo_dhl__handing_over_help'}]
[{else}]
    [{$smarty.block.parent}]
[{/if}]
