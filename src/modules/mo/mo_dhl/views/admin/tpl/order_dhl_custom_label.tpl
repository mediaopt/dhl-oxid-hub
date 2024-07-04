[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]

<form name="transfer" id="transfer" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="cl" value="order_main">
</form>

<form name="myedit" id="myedit" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="[{$oView->getClassName()}]">
    <input type="hidden" name="fnc" value="createCustomLabel">
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="editval[oxorder__oxid]" value="[{$oxid}]">
    <input type="hidden" name="labelId" value="">

    <input type="submit" value="[{oxmultilang ident="MO_DHL__CUSTOM_LABEL_BACK"}]"
           onClick="Javascript:document.myedit.fnc.value=''"/>

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
                                        <b>[{oxmultilang ident='MO_DHL__CUSTOM_LABEL_WEIGHT'}]</b>
                                    </td>
                                </tr>
                                [{foreach from=$shipmentOrder.weight key="weightKey" item="weight"}]
                                    <tr>
                                        <td>
                                            [{$weight.title}] [{if $weightKey !== 'total'}]([{oxmultilang ident='MO_DHL__CUSTOM_LABEL_WEIGHT_PER_ARTICLE'}])[{/if}]
                                        </td>
                                        <td>
                                            <input type="text" name="data[weight][[{$weightKey}]]"
                                                   value="[{$weight.weight}]">
                                        </td>
                                    </tr>
                                [{/foreach}]
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="edittext" colspan="2">
                            <br>
                            <table style="border : 1px #A9A9A9; border-style : solid solid solid solid; padding-top: 5px; padding-bottom: 5px; padding-right: 5px; padding-left: 5px; width: 600px;">
                                <tr>
                                    <td class="edittext" colspan="3">
                                        <b>[{oxmultilang ident='MO_DHL__CUSTOM_LABEL_RECEIVER'}]</b>
                                    </td>
                                </tr>
                                [{foreach from=$shipmentOrder.receiver key="key" item="item"}]
                                    <tr>
                                        <td>
                                            [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_'|cat:$key|upper}]
                                        </td>
                                        <td>
                                            <input type="text" name="data[receiver][[{$key}]]"
                                                   value="[{$item}]">
                                        </td>
                                    </tr>
                                [{/foreach}]
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="edittext" colspan="2">
                            <br>
                            <table style="border : 1px #A9A9A9; border-style : solid solid solid solid; padding-top: 5px; padding-bottom: 5px; padding-right: 5px; padding-left: 5px; width: 600px;">
                                <tr>
                                    <td class="edittext" colspan="3">
                                        <b>[{oxmultilang ident='MO_DHL__CUSTOM_LABEL_SHIPPER'}]</b>
                                    </td>
                                </tr>
                                [{foreach from=$shipmentOrder.shipper key="key" item="item"}]
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_'|cat:$key|upper}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[shipper][[{$key}]]"
                                               value="[{$item}]">
                                    </td>
                                </tr>
                                [{/foreach}]
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="edittext" colspan="2">
                            <br>
                            <table style="border : 1px #A9A9A9; border-style : solid solid solid solid; padding-top: 5px; padding-bottom: 5px; padding-right: 5px; padding-left: 5px; width: 600px;">
                                <tr>
                                    <td class="edittext" colspan="3">
                                        <b>[{oxmultilang ident='MO_DHL__CUSTOM_LABEL_RETURN_RECEIVER'}]</b>
                                    </td>
                                </tr>
                                [{foreach from=$shipmentOrder.services.dhlRetoure.address key="key" item="item"}]
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_'|cat:$key|upper}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[services][dhlRetoure][address][[{$key}]]"
                                               value="[{$item}]">
                                    </td>
                                </tr>
                                [{/foreach}]
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="edittext" colspan="2">
                            <br>
                            <table style="border : 1px #A9A9A9; border-style : solid solid solid solid; padding-top: 5px; padding-bottom: 5px; padding-right: 5px; padding-left: 5px; width: 600px;">
                                <tr>
                                    <td class="edittext" colspan="3">
                                        <b>[{oxmultilang ident='MO_DHL__CUSTOM_LABEL_SERVICES'}]</b>
                                    </td>
                                </tr>
                                [{if $process->supportsParcelOutletRouting()}]
                                <tr>
                                    <td>
                                        [{oxmultilang ident='SHOP_MODULE_mo_dhl__filialrouting_active'}]
                                    </td>
                                    <td>
                                        <input type="hidden" name="data[services][parcelOutletRouting][active]" value="false">
                                        <input type="checkbox" name="data[services][parcelOutletRouting][active]"
                                               value="1" [{if $shipmentOrder.services.parcelOutletRouting}]checked[{/if}]>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        [{oxmultilang ident='SHOP_MODULE_mo_dhl__filialrouting_alternative_email'}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[services][parcelOutletRouting][details]"
                                               value="[{$shipmentOrder.services.parcelOutletRouting}]">
                                    </td>
                                </tr>
                                [{/if}]
                                [{if $process->supportsBulkyGood()}]
                                [{assign var="service" value=$shipmentOrder.services.bulkyGoods}]
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__BULKY_GOOD'}]
                                    </td>
                                    <td>
                                        <input type="hidden" name="data[services][bulkyGoods][active]" value="false">
                                        <input type="checkbox" name="data[services][bulkyGoods][active]"
                                               value="1" [{if $service}]checked[{/if}]>
                                    </td>
                                </tr>
                                [{/if}]
                                [{if $process->supportsAdditionalInsurance()}]
                                [{assign var="service" value=$shipmentOrder.services.additionalInsurance}]
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__ADDITIONAL_INSURANCE'}]
                                    </td>
                                    <td>
                                        <input type="hidden" name="data[services][additionalInsurance][active]" value="false">
                                        <input type="checkbox" name="data[services][additionalInsurance][active]"
                                               value="1" [{if $service}]checked[{/if}]>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__ADDITIONAL_INSURANCE'}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[services][additionalInsurance][insuranceAmount]"
                                               value="[{$service}]">
                                    </td>
                                </tr>
                                [{/if}]
                                [{if $process->supportsCashOnDelivery()}]
                                [{assign var="service" value=$shipmentOrder.services.cashOnDelivery}]
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__CASH_ON_DELIVERY'}]
                                    </td>
                                    <td>
                                        <input type="hidden" name="data[services][cashOnDelivery][active]" value="false">
                                        <input type="checkbox" name="data[services][cashOnDelivery][active]"
                                               value="1" [{if $service}]checked[{/if}]>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__CASH_ON_DELIVERY'}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[services][cashOnDelivery][amount]"
                                               value="[{$service}]">
                                    </td>
                                </tr>
                                [{/if}]
                                [{if $process->supportsIdentCheck()}]
                                [{assign var="service" value=$shipmentOrder.services.identCheck}]
                                [{if $service}]
                                    [{assign var="identDetails" value=$service}]
                                [{/if}]
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__IDENT_CHECK'}]
                                    </td>
                                    <td>
                                        <input type="hidden" name="data[services][identCheck][active]" value="false">
                                        <input type="checkbox" name="data[services][identCheck][active]"
                                               value="1" [{if $service}]checked[{/if}]>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        [{oxmultilang ident='LAST_NAME'}] [{oxmultilang ident='MO_DHL__FOR_IDENT_CHECK'}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[services][identCheck][lastName]"
                                               value="[{if $identDetails}][{$identDetails->getLastName()}][{/if}]">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        [{oxmultilang ident='FIRST_NAME'}] [{oxmultilang ident='MO_DHL__FOR_IDENT_CHECK'}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[services][identCheck][firstName]"
                                               value="[{if $identDetails}][{$identDetails->getFirstName()}][{/if}]">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        [{oxmultilang ident='GENERAL_BIRTHDATE'}] [{oxmultilang ident='MO_DHL__FOR_IDENT_CHECK'}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[services][identCheck][dateOfBirth]"
                                               value="[{if $identDetails && $identDetails->isInitialized('dateOfBirth')}][{$identDetails->getDateOfBirth()}][{/if}]">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__VISUAL_AGE_CHECK'}] [{oxmultilang ident='MO_DHL__FOR_IDENT_CHECK'}]
                                    </td>
                                    <td>
                                        <select name="data[services][identCheck][minimumAge]">
                                            <option value="">-</option>
                                            <option value="16" [{if $identDetails && $identDetails->isInitialized('minimumAge') && $identDetails->getMinimumAge() === 'A16'}] selected[{/if}]>16</option>
                                            <option value="18" [{if $identDetails && $identDetails->isInitialized('minimumAge') && $identDetails->getMinimumAge() === 'A18'}] selected[{/if}]>18</option>
                                        </select>
                                    </td>
                                </tr>
                                [{/if}]
                                [{if $process->supportsVisualAgeCheck()}]
                                [{assign var="service" value=$shipmentOrder.services.visualAgeCheck}]
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__VISUAL_AGE_CHECK'}]
                                    </td>
                                    <td>
                                        <select name="data[services][visualAgeCheck]">
                                            <option value="">-</option>
                                            <option value="16" [{if $service === 'A16'}] selected[{/if}]>16</option>
                                            <option value="18" [{if $service === 'A18'}] selected[{/if}]>18</option>
                                        </select>
                                    </td>
                                </tr>
                                [{/if}]
                                [{assign var="service" value=$shipmentOrder.services.printOnlyIfCodeable}]
                                <tr>
                                    <td>
                                        [{oxmultilang ident='SHOP_MODULE_mo_dhl__only_with_leitcode'}]
                                    </td>
                                    <td>
                                        <input type="hidden" name="data[services][printOnlyIfCodeable][active]"
                                               value="false">
                                        <input type="checkbox" name="data[services][printOnlyIfCodeable][active]"
                                               [{if $service}]checked[{/if}]>
                                    </td>
                                </tr>
                                [{if $process->supportsDHLRetoure()}]
                                <tr>
                                    <td>
                                        [{oxmultilang ident='SHOP_MODULE_mo_dhl__beilegerretoure_active'}]
                                    </td>
                                    <td>
                                        <input type="hidden" name="data[services][dhlRetoure][active]"
                                               value="false">
                                        <input type="checkbox" name="data[services][dhlRetoure][active]"
                                               [{if $shipmentOrder.services.dhlRetoure}]checked[{/if}]>
                                    </td>
                                </tr>
                                [{/if}]

                                [{if $process->supportsNoNeighbourDelivery()}]
                                <tr>
                                    <td>
                                        [{oxmultilang ident='SHOP_MODULE_mo_dhl__no_neighbour_delivery_active'}]
                                    </td>
                                    <td>
                                        <input type="hidden" name="data[services][noNeighbourDelivery][active]"
                                               value="false">
                                        <input type="checkbox" name="data[services][noNeighbourDelivery][active]"
                                               [{if $shipmentOrder.services.noNeighbourDelivery}]checked[{/if}]>
                                    </td>
                                </tr>
                                [{/if}]
                                [{if $process->supportsNamedPersonOnly()}]
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__NAMED_PERSON_ONLY'}]
                                    </td>
                                    <td>
                                        <input type="hidden" name="data[services][namedPersonOnly][active]"
                                               value="false">
                                        <input type="checkbox" name="data[services][namedPersonOnly][active]"
                                               [{if $shipmentOrder.services.namedPersonOnly}]checked[{/if}]>
                                    </td>
                                </tr>
                                [{/if}]
                                [{if $process->supportsSignedForByRecipient()}]
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__SIGNED_FOR_BY_RECIPIENT'}]
                                    </td>
                                    <td>
                                        <input type="hidden" name="data[services][signedForByRecipient][active]"
                                               value="false">
                                        <input type="checkbox" name="data[services][signedForByRecipient][active]"
                                               [{if $shipmentOrder.services.signedForByRecipient}]checked[{/if}]>
                                    </td>
                                </tr>
                                [{/if}]
                                [{if $process->supportsPDDP()}]
                                [{assign var="service" value=$shipmentOrder.services.pddp}]
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__PDDP'}]
                                    </td>
                                    <td>
                                        <input type="hidden" name="data[services][pddp][active]" value="false">
                                        <input type="checkbox" name="data[services][pddp][active]"
                                               value="1" [{if $service}]checked[{/if}]>
                                    </td>
                                </tr>
                                [{/if}]
                                [{if $process->supportsCDP()}]
                                [{assign var="service" value=$shipmentOrder.services.cdp}]
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__CDP'}]
                                    </td>
                                    <td>
                                        <input type="hidden" name="data[services][cdp][active]" value="false">
                                        <input class="deliverySettings" type="checkbox" name="data[services][cdp][active]"
                                               value="1" [{if $service}]checked[{/if}]>
                                    </td>
                                </tr>
                                [{/if}]
                                [{if $process->supportsPremium()}]
                                    [{assign var="service" value=$shipmentOrder.services.premium}]
                                    <tr>
                                        <td>
                                            [{oxmultilang ident='MO_DHL__PREMIUM'}]
                                        </td>
                                        <td>
                                            <input type="hidden" name="data[services][premium][active]" value="false">
                                            <input class="deliverySettings" type="checkbox" name="data[services][premium][active]"
                                                   value="1" [{if $service}]checked[{/if}]>
                                        </td>
                                    </tr>
                                [{/if}]
                                [{if $process->supportsEndorsement()}]
                                [{assign var="service" value=$shipmentOrder.services.endorsement}]
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__ENDORSEMENT'}]
                                    </td>
                                    <td>
                                        <select name="data[services][endorsement]">
                                            <option value="RETURN" [{if $service === 'RETURN'}] selected[{/if}]>[{oxmultilang ident='MO_DHL__ENDORSEMENT_RETURN'}]</option>
                                            <option value="ABANDON" [{if $service === 'ABANDON'}] selected[{/if}]>[{oxmultilang ident='MO_DHL__ENDORSEMENT_ABANDONMENT'}]</option>
                                        </select>
                                    </td>
                                </tr>
                                [{/if}]
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <input type="submit" class="confinput" name="check" value="[{oxmultilang ident="MO_DHL__CUSTOM_LABEL_CREATE"}]">
</form>
<br>
<br>
<script type="application/javascript" src="[{$oViewConf->getModuleUrl("mo_dhl", "out/src/js/admin/mo_dhl_process.js")}]"></script>
[{include file="bottomnaviitem.tpl"}]
[{include file="bottomitem.tpl"}]
