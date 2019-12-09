[{$smarty.block.parent}]

[{if $oView->moDHLShowCheckboxForNotificationAllowance()}]
    <input type="checkbox" id="moDHLAllowNotification"
           [{if $oView->moDHLIsNotificationAllowanceActive()}]checked[{/if}]>
    <label>[{oxmultilang ident="MO_DHL__ALLOW_NOTIFICATION"}]</label>
[{/if}]
[{oxscript add="$('#moDHLAllowNotification').click(function(){ $('#moDHLAllowNotificationHidden').val($(this).is(':checked') ? '1' : '0');});"}]
