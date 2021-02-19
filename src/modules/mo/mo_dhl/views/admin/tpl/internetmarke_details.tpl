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
    <input type="hidden" name="editval[mo_dhl_internetmarke_products__oxid]" value="[{$oxid}]">
    <input type="hidden" name="language" value="[{$actlang}]">

    <table cellspacing="0" cellpadding="0" border="0" width="98%">
        <tr>

            <td valign="top" class="edittext">

                <table cellspacing="0" cellpadding="0" border="0">
                    [{if $oxid != "-1"}]
                    <tr>
                        <td class="edittext">
                            [{oxmultilang ident="MO_DHL__PRODWSID"}]
                        </td>
                        <td class="edittext">
                            [{$edit->getId()}]
                        </td>
                    </tr>
                    <tr>
                        <td class="edittext">
                            [{oxmultilang ident="MO_DHL__NAME"}]
                        </td>
                        <td class="edittext">
                            [{$edit->getFieldData('name')}]
                        </td>
                    </tr>
                    <tr>
                        <td class="edittext">
                            [{oxmultilang ident="MO_DHL__WEIGHT"}]
                        </td>
                        <td class="edittext">
                            [{$edit->getFieldData('weight')}]
                        </td>
                    </tr>
                    <tr>
                        <td class="edittext">
                            [{oxmultilang ident="MO_DHL__DIMENSION"}]
                        </td>
                        <td class="edittext">
                            [{$edit->getFieldData('dimension')}]
                        </td>
                    </tr>
                    <tr>
                        <td class="edittext">
                            [{oxmultilang ident="MO_DHL__BASE_SERVICE"}]
                        </td>
                        <td class="edittext">
                            <ul>
                                [{assign var="baseProducts" value=$oView->getBasicProducts()}]
                                [{foreach from=$baseProducts item="product"}]
                                    <li>[{$product->getFieldData('name')}] ([{$product->getFieldData('annotation')}])</li>
                                [{/foreach}]
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td class="edittext">
                            [{oxmultilang ident="MO_DHL__ADDITIONAL_SERVICES"}]
                        </td>
                        <td class="edittext">
                            <ul>
                                [{assign var="baseProducts" value=$oView->getAdditionalProducts()}]
                                [{foreach from=$baseProducts item="product"}]
                                    <li>[{$product->getFieldData('name')}] ([{$product->getFieldData('annotation')}])</li>
                                [{/foreach}]
                                [{/if}]
                            </ul>

                        </td>
                    </tr>

                    <tr>
                        <td class="edittext">
                        </td>
                        <td class="edittext"><br>
                            <input type="submit" class="edittext" name="updateProductList"
                                   value="[{oxmultilang ident="MO_DHL__UPDATE_PRODUCTLIST"}]"
                                   onClick="Javascript:document.myedit.fnc.value='updateProductList'"" [{$readonly}]><br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</form>

[{include file="bottomnaviitem.tpl"}]

[{include file="bottomitem.tpl"}]
