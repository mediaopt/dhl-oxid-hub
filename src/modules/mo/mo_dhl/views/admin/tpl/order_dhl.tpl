[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]

<form name="transfer" id="transfer" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="cl" value="order_main">
</form>

<form name="myedit" id="myedit" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="MoDHLOrderWunschpaket">
    <input type="hidden" name="fnc" value="save">
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="editval[oxorder__oxid]" value="[{$oxid}]">

    <table cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td valign="top" class="edittext" width="50%">
                <table cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td class="edittext" colspan="2">
                            <br>
                            <table style="border : 1px #A9A9A9; border-style : solid solid solid solid; padding-top: 5px; padding-bottom: 5px; padding-right: 5px; padding-left: 5px; width: 600px;">
                                <tr>
                                    <td class="edittext" colspan="3">
                                        <b>[{oxmultilang ident="MO_DHL__PROCESS_AND_PARTICIPATION"}]</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="ekp">[{oxmultilang ident="MO_DHL__EKP"}]:</label>
                                    </td>
                                    <td>
                                        <input id="ekp" name="ekp" value="[{$ekp}]">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="processIdentifier">[{oxmultilang ident="MO_DHL__PROCESS_IDENTIFIER"}]
                                            :</label>
                                    </td>
                                    <td>
                                        <select id="processIdentifier" name="processIdentifier">
                                            <option value="">-</option>
                                            [{foreach from=$processes key='identifier' item='label'}]
                                                <option value="[{$identifier}]"[{if $identifier === $processIdentifier}] selected[{/if}]>
                                                    [{$label}]
                                                </option>
                                            [{/foreach}]
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="participationNumber">[{oxmultilang ident="MO_DHL__PARTICIPATION_NUMBER"}]
                                            :</label>
                                    </td>
                                    <td>
                                        <input id="participationNumber" name="participationNumber" maxlength="2"
                                               placeholder="[{oxmultilang ident="MO_DHL__PARTICIPATION_NUMBER"}]"
                                               value="[{$participationNumber}]"
                                        />
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    [{if $remarks}]
                        <tr>
                            <td class="edittext" colspan="2">
                                <br>
                                <table style="border : 1px #A9A9A9; border-style : solid solid solid solid; padding-top: 5px; padding-bottom: 5px; padding-right: 5px; padding-left: 5px; width: 600px;">
                                    <tr>
                                        <td class="edittext" colspan="3">
                                            <b>[{oxmultilang ident="MO_DHL__WUNSCHPAKET"}]</b>
                                        </td>
                                    </tr>
                                    [{foreach from=$remarks key='field' item='value'}]
                                        <tr>
                                            <td>
                                                [{$field}]
                                            </td>
                                            <td>
                                                [{$value}]
                                            </td>
                                        </tr>
                                    [{/foreach}]
                                </table>
                            </td>
                        </tr>
                    [{/if}]
                </table>
            </td>
        </tr>
    </table>
    <input type="submit" value="[{oxmultilang ident="GENERAL_SAVE"}]"/>
</form>

[{include file="bottomnaviitem.tpl"}]
[{include file="bottomitem.tpl"}]
