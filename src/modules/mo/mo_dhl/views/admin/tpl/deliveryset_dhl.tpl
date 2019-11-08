[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]

[{if $readonly}]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]

<form name="transfer" id="transfer" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="oxidCopy" value="[{$oxid}]">
    <input type="hidden" name="cl" value="MoDHLDeliverySetDHL">
    <input type="hidden" name="language" value="[{$actlang}]">
</form>


<form name="myedit" id="myedit" action="[{$oViewConf->getSelfLink()}]" method="post">
[{$oViewConf->getHiddenSid()}]
<input type="hidden" name="cl" value="MoDHLDeliverySetDHL">
<input type="hidden" name="fnc" value="">
<input type="hidden" name="oxid" value="[{$oxid}]">
<input type="hidden" name="editval[oxdeliveryset__oxid]" value="[{$oxid}]">
<input type="hidden" name="language" value="[{$actlang}]">

<table cellspacing="0" cellpadding="0" border="0" width="98%">
<tr>

    <td valign="top" class="edittext">

        <table cellspacing="0" cellpadding="0" border="0">
        [{if $oxid != "-1"}]
            <tr>
                <td class="edittext">
                    [{oxmultilang ident="MO_DHL__EXCLUDED"}]
                </td>
                <td class="edittext">
                    <input class="edittext" type="checkbox" name="editval[oxdeliveryset__mo_dhl_excluded]" value='1' [{if $edit->oxdeliveryset__mo_dhl_excluded->value == 1}]checked[{/if}] [{$readonly}]>
                    [{oxinputhelp ident="HELP_GENERAL_ACTIVE"}]
                </td>
            </tr>
            <tr>
                <td class="edittext" width="140">
                [{oxmultilang ident="MO_DHL__PROCESS_IDENTIFIER"}]
                </td>
                <td class="edittext" width="250">
                    <select id="processIdentifier-[{$oxid}]" name="editval[oxdeliveryset__mo_dhl_process]">
                        <option selected value="">-</option>
                        [{foreach from=$processes key='identifier' item='label'}]
                            <option value="[{$identifier}]"[{if $identifier === $edit->oxdeliveryset__mo_dhl_process->rawValue}] selected[{/if}]>
                                [{$label}]
                            </option>
                        [{/foreach}]
                    </select>
                </td>
            </tr>

            <tr>
                <td class="edittext" width="140">
                [{oxmultilang ident="MO_DHL__PARTICIPATION_NUMBER"}]
                </td>
                <td class="edittext" width="250">
                <input name="editval[oxdeliveryset__mo_dhl_participation]" maxlength="2"
                       value="[{$edit->oxdeliveryset__mo_dhl_participation->rawValue}]"
                        [{$readonly}]
                />
                [{oxinputhelp ident="HELP_MO_DHL__PARTICIPATION_NUMBER"}]
                </td>
            </tr>
            <tr>
                <td class="edittext">
                </td>
                <td class="edittext"><br>
                <input type="submit" class="edittext" name="save" value="[{oxmultilang ident="GENERAL_SAVE"}]" onClick="Javascript:document.myedit.fnc.value='save'"" [{$readonly}]><br>
                </td>
            </tr>
        [{/if}]
        </table>
    </td>
    </tr>
</table>

</form>

[{include file="bottomnaviitem.tpl"}]

[{include file="bottomitem.tpl"}]
