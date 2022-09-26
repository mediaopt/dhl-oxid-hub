[{$smarty.block.parent}]

[{if $oView->moDHLShowCheckboxForNotificationAllowance()}]
    <div>
        <input type="checkbox" id="moDHLAllowNotification"
               [{if $oView->moDHLIsNotificationAllowanceActive()}]checked[{/if}]>
        <label>[{oxmultilang ident="MO_DHL__ALLOW_NOTIFICATION"}]</label>
    </div>
[{/if}]
[{oxscript add="$('#moDHLAllowNotification').click(function(){ $('#moDHLAllowNotificationHidden').val($(this).is(':checked') ? '1' : '0');});"}]

[{if $oView->moDHLShowIdentCheckFields()}]
    <div class="row form-group[{if $mo_dhl_birthday_errors}] text-danger[{/if}]">

        <label class="control-label col-lg-3 req">[{oxmultilang ident="MO_DHL__BIRTHDAY"}]</label>
        <div class="col-lg-9">
            <input class="form-control" type="text" id="moDHLIdentCheckBirthday"
                   value="[{$oView->moDHLGetBirthday()}]">
            [{include file="message/inputvalidation.tpl" aErrors=$mo_dhl_birthday_errors}]
            <div class="help-block"></div>
        </div>
    </div>
[{/if}]
[{oxscript add="$('#moDHLIdentCheckBirthday').change(function(){ $('#moDHLIdentCheckBirthdayHidden').val($(this).val());});"}]

[{if $oView->moDHLShowPhoneNumberField()}]
    <div class="row form-group[{if $mo_dhl_phone_number_errors}] text-danger[{/if}]">

        <label class="control-label col-lg-3 req">[{oxmultilang ident="MO_DHL__PHONE_NUMBER"}]</label>
        <div class="col-lg-9">
            <input class="form-control" type="text" id="moDHLPhoneNumber"
                   value="[{$oView->moDHLGetPhoneNumber()}]">
            [{include file="message/inputvalidation.tpl" aErrors=$mo_dhl_phone_number_errors}]
            <div class="help-block"></div>
        </div>
    </div>
    [{/if}]
[{oxscript add="$('#moDHLPhoneNumber').change(function(){ $('#moDHLPhoneNumberHidden').val($(this).val());});"}]
