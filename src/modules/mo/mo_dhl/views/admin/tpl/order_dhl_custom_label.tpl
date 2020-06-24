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
                                        <b>[{oxmultilang ident='MO_DHL__CUSTOM_LABEL_GENERAL'}]</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_WEIGHT'}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[general][weight]"
                                               value="[{$shipmentOrder.general.weight}]">
                                    </td>
                                </tr>
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
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_NAME'}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[receiver][name]"
                                               value="[{$shipmentOrder.receiver.name}]">
                                    </td>
                                </tr>
                                [{assign var="address" value=$shipmentOrder.receiver.address}]
                                [{if $shipmentOrder.receiver.type == 'address'}]
                                    <tr>
                                        <td>
                                            [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_STREETNAME'}]
                                        </td>
                                        <td>
                                            <input type="text" name="data[receiver][streetName]"
                                                   value="[{$address->getStreetName()}]">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_STREETNUMBER'}]
                                        </td>
                                        <td>
                                            <input type="text" name="data[receiver][streetNumber]"
                                                   value="[{$address->getStreetNumber()}]">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_ADRESS_ADDITION'}]
                                        </td>
                                        <td>
                                            <input type="text" name="data[receiver][name3]"
                                                   value="[{$address->getName3()}]">
                                        </td>
                                    </tr>
                                [{elseif $shipmentOrder.receiver.type == 'packstation'}]
                                    <tr>
                                        <td>
                                            [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_PACKSTATION_NUMBER'}]
                                        </td>
                                        <td>
                                            <input type="text" name="data[receiver][packstationNumber]"
                                                   value="[{$address->getPackstationNumber()}]">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_POST_NUMBER'}]
                                        </td>
                                        <td>
                                            <input type="text" name="data[receiver][postNumber]"
                                                   value="[{$address->getPostNumber()}]">
                                        </td>
                                    </tr>
                                [{else}]
                                    <tr>
                                        <td>
                                            [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_POSTFILIAL_NUMBER'}]
                                        </td>
                                        <td>
                                            <input type="text" name="data[receiver][postfilialNumber]"
                                                   value="[{$address->getPostfilialNumber()}]">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_POST_NUMBER'}]
                                        </td>
                                        <td>
                                            <input type="text" name="data[receiver][postNumber]"
                                                   value="[{$address->getPostNumber()}]">
                                        </td>
                                    </tr>
                                [{/if}]
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_ZIP'}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[receiver][zip]" value="[{$address->getZip()}]">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_CITY'}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[receiver][city]" value="[{$address->getCity()}]">
                                    </td>
                                </tr>
                                [{if $shipmentOrder.receiver.type == 'address'}]
                                    [{assign var="origin" value=$address->getOrigin()}]
                                    <tr>
                                        <td>
                                            [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_COUNTRY'}]
                                        </td>
                                        <td>
                                            <input type="text" name="data[receiver][country]"
                                                   value="[{$origin->getCountryIsoCode()}]">
                                        </td>
                                    </tr>
                                [{/if}]
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
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_NAME'}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[shipper][name]"
                                               value="[{$shipmentOrder.shipper.name}]">
                                    </td>
                                </tr>
                                [{assign var="address" value=$shipmentOrder.shipper.address}]
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_STREETNAME'}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[shipper][streetName]"
                                               value="[{$address->getStreetName()}]">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_STREETNUMBER'}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[shipper][streetNumber]"
                                               value="[{$address->getStreetNumber()}]">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_ZIP'}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[shipper][zip]" value="[{$address->getZip()}]">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_CITY'}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[shipper][city]" value="[{$address->getCity()}]">
                                    </td>
                                </tr>
                                [{assign var="origin" value=$address->getOrigin()}]
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_COUNTRY'}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[shipper][country]"
                                               value="[{$origin->getCountryIsoCode()}]">
                                    </td>
                                </tr>
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
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_NAME'}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[returnReceiver][name]"
                                               value="[{$shipmentOrder.returnReceiver.name}]">
                                    </td>
                                </tr>
                                [{assign var="address" value=$shipmentOrder.returnReceiver.address}]
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_STREETNAME'}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[returnReceiver][streetName]"
                                               value="[{$address->getStreetName()}]">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_STREETNUMBER'}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[returnReceiver][streetNumber]"
                                               value="[{$address->getStreetNumber()}]">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_ZIP'}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[returnReceiver][zip]"
                                               value="[{$address->getZip()}]">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_CITY'}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[returnReceiver][city]"
                                               value="[{$address->getCity()}]">
                                    </td>
                                </tr>
                                [{assign var="origin" value=$address->getOrigin()}]
                                <tr>
                                    <td>
                                        [{oxmultilang ident='MO_DHL__CUSTOM_LABEL_COUNTRY'}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[returnReceiver][country]"
                                               value="[{$origin->getCountryIsoCode()}]">
                                    </td>
                                </tr>
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
                                [{assign var="service" value=$shipmentOrder.services.parcelOutletRouting}]
                                <tr>
                                    <td>
                                        [{oxmultilang ident='SHOP_MODULE_mo_dhl__filialrouting_active'}]
                                    </td>
                                    <td>
                                        <input type="hidden" name="data[services][parcelOutletRouting]" value="false">
                                        <input type="checkbox" name="data[services][parcelOutletRouting][active]"
                                               value="1" [{if $service->getActive()}]checked[{/if}]>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        [{oxmultilang ident='SHOP_MODULE_mo_dhl__filialrouting_alternative_email'}]
                                    </td>
                                    <td>
                                        <input type="text" name="data[services][parcelOutletRouting][details]"
                                               value="[{$service->getDetails()}]">
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
                                               [{if $service->getActive()}]checked[{/if}]>
                                    </td>
                                </tr>
                                [{if $process->supportsDHLRetoure()}]
                                <tr>
                                    <td>
                                        [{oxmultilang ident='SHOP_MODULE_mo_dhl__beilegerretoure_active'}]
                                    </td>
                                    <td>
                                        <input type="hidden" name="data[services][beilegerretoure][active]"
                                               value="false">
                                        <input type="checkbox" name="data[services][beilegerretoure][active]"
                                               [{if $shipmentOrder.services.beilegerretoure}]checked[{/if}]>
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
[{include file="bottomnaviitem.tpl"}]
[{include file="bottomitem.tpl"}]
