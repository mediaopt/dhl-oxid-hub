[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]

[{if $readonly}]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]

<form name="transfer" id="transfer" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="cl" value="[{$oView->getClassName()}]">
    <input type="hidden" name="language" value="[{$actlang}]">
</form>


<form name="myedit" id="myedit" action="[{$oViewConf->getSelfLink()}]" method="post">
[{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="[{$oView->getClassName()}]">
<input type="hidden" name="fnc" value="">
<input type="hidden" name="oxid" value="[{$oxid}]">
<input type="hidden" name="editval[oxdeliveryset__oxid]" value="[{$oxid}]">
<input type="hidden" name="language" value="[{$actlang}]">

<table id="mo_dhl_process_settings" class="[{$edit->oxdeliveryset__mo_dhl_process->rawValue}]" cellspacing="0" cellpadding="0" border="0" width="98%">
<tr>

    <td valign="top" class="edittext">

        <table cellspacing="0" cellpadding="0" border="0">
        [{if $oxid != "-1"}]
            <tr>
                <td class="edittext">
                    [{oxmultilang ident="MO_DHL__EXCLUDED"}]
                </td>
                <td class="edittext">
                    <input type="hidden" name="editval[oxdeliveryset__mo_dhl_excluded]" value="0">
                    <input class="edittext" type="checkbox" name="editval[oxdeliveryset__mo_dhl_excluded]" value='1' [{if $edit->oxdeliveryset__mo_dhl_excluded->value == 1}]checked[{/if}] [{$readonly}]>
                    [{oxinputhelp ident="HELP_MO_DHL__EXCLUDED"}]
                </td>
            </tr>
            <tr>
                <td class="edittext" width="140">
                [{oxmultilang ident="MO_DHL__PROCESS_IDENTIFIER"}]
                </td>
                <td class="edittext" width="250">
                    <select class="processIdentifier" id="processIdentifier-[{$oxid}]" name="editval[oxdeliveryset__mo_dhl_process]">
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
                    <div class="show-internetmarke">
                    [{oxmultilang ident="MO_DHL__INTERNETMARKE_PRODUCT_NUMBER"}]
                    </div>
                    <div class="hide-internetmarke">
                        [{oxmultilang ident="MO_DHL__PARTICIPATION_NUMBER"}]
                    </div>
                </td>
                <td class="edittext" width="250">
                    <input name="editval[oxdeliveryset__mo_dhl_participation]" maxlength="5"
                           value="[{$edit->oxdeliveryset__mo_dhl_participation->rawValue}]"
                           [{$readonly}]
                    />
                    <div class="show-internetmarke">
                        [{oxinputhelp ident="HELP_MO_DHL__INTERNETMARKE_PRODUCT_NUMBER"}]
                    </div>
                    <div class="hide-internetmarke">
                        [{oxinputhelp ident="HELP_MO_DHL__PARTICIPATION_NUMBER"}]
                    </div>
                </td>
            </tr>
            <tr class="hide-internetmarke">
                <td class="edittext">
                    [{oxmultilang ident="MO_DHL__IDENT_CHECK"}]
                </td>
                <td class="edittext">
                    <input type="hidden" name="editval[oxdeliveryset__mo_dhl_ident_check]" value="0">
                    <input class="edittext" type="checkbox" name="editval[oxdeliveryset__mo_dhl_ident_check]"
                           value='1'
                           [{if $edit->oxdeliveryset__mo_dhl_ident_check->value == 1}]checked[{/if}] [{$readonly}]>
                    [{oxinputhelp ident="HELP_MO_DHL__IDENT_CHECK"}]
                </td>
            </tr>
            <tr class="hide-internetmarke">
                <td class="edittext">
                    [{oxmultilang ident="MO_DHL__ADDITIONAL_INSURANCE"}]
                </td>
                <td class="edittext">
                    <input type="hidden" name="editval[oxdeliveryset__mo_dhl_additional_insurance]" value="0">
                    <input class="edittext" type="checkbox" name="editval[oxdeliveryset__mo_dhl_additional_insurance]"
                           value='1'
                           [{if $edit->oxdeliveryset__mo_dhl_additional_insurance->value == 1}]checked[{/if}] [{$readonly}]>
                    [{oxinputhelp ident="HELP_MO_DHL__ADDITIONAL_INSURANCE"}]
                </td>
            </tr>
            <tr class="hide-internetmarke">
                <td class="edittext" width="140">
                    [{oxmultilang ident="MO_DHL__OPERATOR"}]
                </td>
                <td class="edittext" width="250">
                    <input name="editval[oxdeliveryset__mo_dhl_operator]" maxlength="40"
                           value="[{$edit->oxdeliveryset__mo_dhl_operator->rawValue}]"
                           [{$readonly}]
                    />
                    [{oxinputhelp ident="HELP_MO_DHL__OPERATOR"}]
                </td>
            </tr>
            <tr class="hide-internetmarke show-paket-international">
                <td class="edittext">
                    [{oxmultilang ident="MO_DHL__PDDP"}]
                </td>
                <td class="edittext">
                    <input type="hidden" name="editval[oxdeliveryset__mo_dhl_pddp]" value="0">
                    <input class="edittext" type="checkbox" name="editval[oxdeliveryset__mo_dhl_pddp]"
                           value='1'
                           [{if $edit->oxdeliveryset__mo_dhl_pddp->value == 1}]checked[{/if}] [{$readonly}]>
                    [{oxinputhelp ident="HELP_MO_DHL__PDDP"}]
                </td>
            </tr>
            <tr class="hide-internetmarke show-paket-international">
                <td class="edittext">
                    [{oxmultilang ident="MO_DHL__ECONOMY"}]
                </td>
                <td class="edittext">
                    <input type="hidden" name="editval[oxdeliveryset__mo_dhl_economy]" value="0">
                    <input class="edittext deliverySettings" type="checkbox" name="editval[oxdeliveryset__mo_dhl_economy]"
                           value='1'
                           [{if $edit->oxdeliveryset__mo_dhl_economy->value == 1}]checked[{/if}] [{$readonly}]>
                    [{oxinputhelp ident="HELP_MO_DHL__ECONOMY"}]
                </td>
            </tr>
            <tr class="hide-internetmarke show-paket-international">
                <td class="edittext">
                    [{oxmultilang ident="MO_DHL__CDP"}]
                </td>
                <td class="edittext">
                    <input type="hidden" name="editval[oxdeliveryset__mo_dhl_cdp]" value="0">
                    <input class="edittext deliverySettings" type="checkbox" name="editval[oxdeliveryset__mo_dhl_cdp]"
                           value='1'
                           [{if $edit->oxdeliveryset__mo_dhl_cdp->value == 1}]checked[{/if}] [{$readonly}]>
                    [{oxinputhelp ident="HELP_MO_DHL__CDP"}]
                </td>
            </tr>
            <tr class="hide-internetmarke show-warenpost-international show-paket-international">
                <td class="edittext">
                    [{oxmultilang ident="MO_DHL__PREMIUM"}]
                </td>
                <td class="edittext">
                    <input type="hidden" name="editval[oxdeliveryset__mo_dhl_premium]" value="0">
                    <input class="edittext deliverySettings" type="checkbox" name="editval[oxdeliveryset__mo_dhl_premium]"
                           value='1'
                           [{if $edit->oxdeliveryset__mo_dhl_premium->value == 1}]checked[{/if}] [{$readonly}]>
                    [{oxinputhelp ident="HELP_MO_DHL__PREMIUM"}]
                </td>
            </tr>
            <tr class="hide-internetmarke">
                <td class="edittext">
                    [{oxmultilang ident="MO_DHL__NAMED_PERSON_ONLY"}]
                </td>
                <td class="edittext">
                    <input type="hidden" name="editval[oxdeliveryset__mo_dhl_named_person_only]" value="0">
                    <input class="edittext" type="checkbox" name="editval[oxdeliveryset__mo_dhl_named_person_only]"
                           value='1'
                           [{if $edit->oxdeliveryset__mo_dhl_named_person_only->value == 1}]checked[{/if}] [{$readonly}]>
                </td>
            </tr>
            <tr class="hide-internetmarke">
                <td class="edittext">
                    [{oxmultilang ident="MO_DHL__ENDORSEMENT"}]
                </td>
                <td class="edittext">
                    <select id="endorsement" name="editval[oxdeliveryset__mo_dhl_endorsement]">
                        [{foreach from=$endorsements key='identifier' item='label'}]
                            <option value="[{$identifier}]"[{if $identifier == $edit->oxdeliveryset__mo_dhl_endorsement->rawValue}] selected[{/if}]>
                                [{$label}]
                            </option>
                        [{/foreach}]
                    </select>
                    [{oxinputhelp ident="HELP_MO_DHL__ENDORSEMENT"}]
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
<script type="application/javascript" src="[{$oViewConf->getModuleUrl("mo_dhl", "out/src/js/admin/mo_dhl_process.js")}]"></script>
<link rel="stylesheet" type="text/css" href="[{$oViewConf->getModuleUrl("mo_dhl", "out/src/css/admin/mo_dhl_process.css")}]">
</form>

[{include file="bottomnaviitem.tpl"}]

[{include file="bottomitem.tpl"}]
