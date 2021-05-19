[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]

[{if $readonly}]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]
<script>
    function optionsSets() {
        var visibility = 'hidden'
        var val = document.getElementById("processIdentifier-[{$oxid}]").value;
        if (val === 'WARENPOST_INTERNATIONAL') {
            visibility = 'visible';
        }
        for (let el of document.querySelectorAll('.warenpost')) el.style.visibility = visibility;
    }
    window.onload = optionsSets;
</script>

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
                    <select id="processIdentifier-[{$oxid}]" name="editval[oxdeliveryset__mo_dhl_process]" onchange="optionsSets()">
                        <option selected value="">-</option>
                        [{foreach from=$processes key='identifier' item='label'}]
                            <option value="[{$identifier}]"[{if $identifier === $edit->oxdeliveryset__mo_dhl_process->rawValue}] selected[{/if}]>
                                [{$label}]
                            </option>
                        [{/foreach}]
                    </select>
                </td>
            </tr>
            [{if $oView->usesInternetmarke()}]
                <tr>
                    <td class="edittext" width="140">
                        [{oxmultilang ident="MO_DHL__INTERNETMARKE_PRODUCT_NUMBER"}]
                    </td>
                    <td class="edittext" width="250">
                        <input name="editval[oxdeliveryset__mo_dhl_participation]" maxlength="5"
                               value="[{$edit->oxdeliveryset__mo_dhl_participation->rawValue}]"
                               [{$readonly}]
                        />
                        [{oxinputhelp ident="HELP_MO_DHL__INTERNETMARKE_PRODUCT_NUMBER"}]
                    </td>
                </tr>
            [{else}]
                <tr>
                    <td class="edittext" width="140">
                        [{oxmultilang ident="MO_DHL__PARTICIPATION_NUMBER"}]
                    </td>
                    <td class="edittext" width="250">
                        <input name="editval[oxdeliveryset__mo_dhl_participation]" maxlength="5"
                               value="[{$edit->oxdeliveryset__mo_dhl_participation->rawValue}]"
                               [{$readonly}]
                        />
                        [{oxinputhelp ident="HELP_MO_DHL__PARTICIPATION_NUMBER"}]
                    </td>
                </tr>
                <tr>
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
                <tr>
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
                <tr>
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
                <tr>
                    <td class="edittext">
                        [{oxmultilang ident="MO_DHL__PREMIUM"}]
                    </td>
                    <td class="edittext">
                        <input type="hidden" name="editval[oxdeliveryset__mo_dhl_premium]" value="0">
                        <input class="edittext" type="checkbox" name="editval[oxdeliveryset__mo_dhl_premium]"
                               value='1'
                               [{if $edit->oxdeliveryset__mo_dhl_premium->value == 1}]checked[{/if}] [{$readonly}]>
                        [{oxinputhelp ident="HELP_MO_DHL__PREMIUM"}]
                    </td>
                </tr>
            [{/if}]
            <tr class="warenpost">
                <td class="edittext" width="140">
                    [{oxmultilang ident="MO_DHL__WARENPOST_PRODUCT_REGION"}]
                </td>
                <td class="edittext" width="250">
                    <select id="warenpostRegion" name="editval[oxdeliveryset__mo_dhl_warenpost_product_region]">
                        [{if !isset($warenpostRegionValue) }]
                            <option value="">-</option>
                        [{/if}]
                        [{foreach from=$warenpostRegions item='region'}]
                            <option value="[{$region}]" [{if $region === $edit->oxdeliveryset__mo_dhl_warenpost_product_region->rawValue}] selected[{/if}]>
                                [{$region}]
                            </option>
                        [{/foreach}]
                    </select>
                </td>
            </tr>
            <tr class="warenpost">
                <td class="edittext" width="140">
                    [{oxmultilang ident="MO_DHL__WARENPOST_PRODUCT_TRACKING_TYPE"}]
                </td>
                <td class="edittext" width="250">
                    <select id="warenpostTrackingType" name="editval[oxdeliveryset__mo_dhl_warenpost_product_tracking_type]">
                        [{if !isset($warenpostTrackingTypeValue) }]
                            <option value="">-</option>
                        [{/if}]
                        [{foreach from=$warenpostTrackingTypes item='trackingType'}]
                            <option value="[{$trackingType}]" [{if $trackingType === $edit->oxdeliveryset__mo_dhl_warenpost_product_tracking_type->rawValue}] selected[{/if}]>
                                [{$trackingType}]
                            </option>
                        [{/foreach}]
                    </select>
                </td>
            </tr>
            <tr class="warenpost">
                <td class="edittext" width="140">
                    [{oxmultilang ident="MO_DHL__WARENPOST_PRODUCT_PACKAGE_TYPE"}]
                </td>
                <td class="edittext" width="250">
                    <select id="warenpostPackageType" name="editval[oxdeliveryset__mo_dhl_warenpost_product_package_type]">
                        [{if !isset($warenpostPackageTypeValue) }]
                            <option value="">-</option>
                        [{/if}]
                        [{foreach from=$warenpostPackageTypes item='packageType'}]
                            <option value="[{$packageType}]" [{if $packageType === $edit->oxdeliveryset__mo_dhl_warenpost_product_package_type->rawValue}] selected[{/if}]>
                                [{$packageType}]
                            </option>
                        [{/foreach}]
                    </select>
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
