[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]

<form name="transfer" id="transfer" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="cl" value="order_main">
</form>

<form name="myedit" id="myedit" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="[{$oView->getClassName()}]">
    <input type="hidden" name="fnc" value="save">
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="editval[oxorder__oxid]" value="[{$oxid}]">
    <input type="hidden" name="labelId" value="">

    <table cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td valign="top" class="edittext" width="50%">
                <table cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td class="edittext" colspan="2">
                            <br>
                            <table style="border : 1px solid #A9A9A9; padding: 5px; width: 600px;">
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
                                                <option value="[{$identifier}]"[{if $process AND $identifier === $process->getIdentifier()}] selected[{/if}]>
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
                                <tr>
                                    <td>
                                        <label for="operator">[{oxmultilang ident="MO_DHL__OPERATOR"}]
                                            :</label>
                                    </td>
                                    <td>
                                        <input id="operator" name="operator" maxlength="40"
                                               placeholder="[{oxmultilang ident="MO_DHL__OPERATOR"}]"
                                               value="[{$operator}]"
                                        />
                                    </td>
                                </tr>
                                [{if isset($RetoureRequestStatuses) }]
                                    <tr>
                                        <td>
                                            <label for="retoureRequest">[{oxmultilang ident="MO_DHL__RETOURE_LABEL"}]
                                                :</label>
                                        </td>
                                        <td>[{$status}]
                                            <select id="retoureRequest" name="retoureRequest">
                                                [{if !isset($RetoureRequestStatus) }]
                                                    <option value="">-</option>
                                                [{/if}]
                                                [{foreach from=$RetoureRequestStatuses key='status' item='label'}]
                                                    <option value="[{$status}]"[{if $RetoureRequestStatus === $status}] selected[{/if}]>
                                                        [{oxmultilang ident="$label"}]
                                                    </option>
                                                [{/foreach}]
                                            </select>
                                        </td>
                                    </tr>
                                [{/if}]
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
                    [{if $labels}]
                        <tr>
                            <td class="edittext" colspan="2">
                                <br>
                                <table style="border : 1px solid #A9A9A9; padding: 5px; width: 600px;">
                                    <tr>
                                        <td class="edittext" colspan="3">
                                            <b>[{oxmultilang ident="MO_DHL__LABELS"}]</b>
                                        </td>
                                    </tr>
                                    [{foreach from=$labels  item='label' name='labels'}]
                                        [{if $label->isRetoure()}]
                                            <tr>
                                                <td>[{oxmultilang ident="MO_DHL__RETOURE_LABEL"}]</td>
                                                <td>
                                                    <a target="_blank" rel="noopener noreferrer"
                                                       href="[{$label->getFieldData('labelUrl')}]">[{$label->getFieldData('shipmentNumber')}]</a>
                                                </td>
                                                <td [{if $label->getFieldData('qrLabelUrl')}] rowspan="2" [{/if}]>
                                                    <input type="submit" class="confinput" name="check"
                                                           value="[{oxmultilang ident="MO_DHL__DELETE_SHIPMENT"}]"
                                                           onClick="Javascript:document.myedit.labelId.value='[{$label->getId()}]';document.myedit.fnc.value='deleteShipment'">
                                                </td>
                                            </tr>
                                            [{if $label->getFieldData('qrLabelUrl')}]
                                            <tr>
                                                <td>[{oxmultilang ident="MO_DHL__RETOURE_QR_LABEL"}]</td>
                                                <td>
                                                    <a target="_blank" rel="noopener noreferrer"
                                                       href="[{$label->getFieldData('qrLabelUrl')}]">[{$label->getFieldData('shipmentNumber')}]</a>
                                                </td>
                                            </tr>
                                            [{/if}]
                                        [{else}]
                                            <tr>
                                                <td>[{oxmultilang ident="MO_DHL__LABEL"}]</td>
                                                <td>
                                                    <a target="_blank" rel="noopener noreferrer"
                                                       href="[{$label->getFieldData('labelUrl')}]">[{$label->getFieldData('shipmentNumber')}]</a>
                                                </td>
                                                <td [{if $label->getFieldData('returnLabelUrl')}] rowspan="2" [{/if}]>
                                                    <input type="submit" class="confinput" name="check"
                                                           value="[{oxmultilang ident="MO_DHL__DELETE_SHIPMENT"}]"
                                                           onClick="Javascript:document.myedit.labelId.value='[{$label->getId()}]';document.myedit.fnc.value='deleteShipment'">
                                                </td>
                                            </tr>
                                            [{if $label->getFieldData('returnLabelUrl')}]
                                                <tr>
                                                    <td>[{oxmultilang ident="MO_DHL__RETOURE_LABEL"}]</td>
                                                    <td>
                                                        <a target="_blank" rel="noopener noreferrer"
                                                           href="[{$label->getFieldData('returnLabelUrl')}]">[{$label->getFieldData('returnShipmentNumber')}]</a>
                                                    </td>
                                                </tr>
                                            [{/if}]
                                            [{if $label->getFieldData('exportlabelurl')}]
                                                <tr>
                                                    <td>[{oxmultilang ident="MO_DHL__EXPORT_LABEL"}]</td>
                                                    <td>
                                                        <a target="_blank" rel="noopener noreferrer"
                                                           href="[{$label->getFieldData('exportlabelurl')}]">[{$label->getFieldData('shipmentNumber')}]</a>
                                                    </td>
                                                </tr>
                                            [{/if}]
                                        [{/if}]
                                        [{if not $smarty.foreach.labels.last}]
                                            <tr>
                                                <td style="border-bottom: 1px solid #A9A9A9;" colspan="3"></td>
                                            </tr>
                                        [{/if}]
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
    <input type="submit" class="confinput" name="check" value="[{oxmultilang ident="MO_DHL__CREATE_LABEL"}]"
           onClick="Javascript:document.myedit.fnc.value='createLabel'">
    <input type="submit" class="confinput" name="check" value="[{oxmultilang ident="MO_DHL__CUSTOM_LABEL_CREATE"}]"
           onClick="Javascript:document.myedit.fnc.value='prepareCustomLabel'">
    <input type="submit" class="confinput" name="check" value="[{oxmultilang ident="MO_DHL__CREATE_RETOURE"}]"
           onClick="Javascript:document.myedit.fnc.value='createRetoure'">
</form>
<br>
<br>

[{include file="bottomnaviitem.tpl"}]
[{include file="bottomitem.tpl"}]
