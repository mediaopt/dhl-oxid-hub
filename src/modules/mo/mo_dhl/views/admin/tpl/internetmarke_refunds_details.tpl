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
    <input type="hidden" name="cl" value="[{$oView->getClassName()}]">
    <input type="hidden" name="language" value="[{$actlang}]">
</form>

<form name="myedit" id="myedit" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="[{$oView->getClassName()}]">
    <input type="hidden" name="fnc" value="">
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="editval[mo_dhl_internetmarke_refunds__oxid]" value="[{$oxid}]">
    <input type="hidden" name="language" value="[{$actlang}]">

    <table cellspacing="0" cellpadding="0" border="0" width="98%">
        <tr>

            <td valign="top" class="edittext">

                <table cellspacing="0" cellpadding="0" border="0">
                    [{if $oxid != "-1"}]
                    <tr>
                        <td class="edittext">
                            [{oxmultilang ident="MO_DHL__RETOURE_TRANSACTION_ID"}]
                        </td>
                        <td class="edittext">
                            [{$edit->getId()}]
                        </td>
                    </tr>
                    <tr>
                        <td class="edittext">
                            [{oxmultilang ident="MO_DHL__RETOURE_STATUS"}]
                        </td>
                        <td class="edittext">
                            [{$edit->getFieldData('status')}]
                        </td>
                    </tr>
                    [{/if}]
                    [{if $refundStatus}]
                    <tr>
                        <td class="edittext">
                            [{oxmultilang ident="MO_DHL__RETOURE_REQUESTED"}]
                        </td>
                        <td class="edittext">
                            [{$refundStatus.created|oxformdate}]
                        </td>
                    </tr>
                    <tr>
                        <td class="edittext">
                            [{oxmultilang ident="MO_DHL__RETOURE_REFUNDED"}]
                        </td>
                        <td class="edittext">
                            [{$refundStatus.refunded}] / [{$refundStatus.total}]
                        </td>
                    </tr>
                    [{/if}]
                    [{if $oxid != "-1"}]
                    <tr>
                        <td class="edittext">
                        </td>
                        <td class="edittext"><br>
                            <input type="submit" class="edittext" name="updateRefundStatus"
                                   value="[{oxmultilang ident="MO_DHL__UPDATE_STATUS"}]"
                                   onClick="Javascript:document.myedit.fnc.value='updateRefundStatus'"" [{$readonly}]><br>
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
