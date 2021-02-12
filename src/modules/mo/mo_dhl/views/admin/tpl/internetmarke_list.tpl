[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign box="list"}]
[{assign var="where" value=$oView->getListFilter()}]

[{if $readonly}]
    [{assign var="readonly" value="readonly disabled"}]
    [{else}]
    [{assign var="readonly" value=""}]
    [{/if}]

<script type="text/javascript">
    <!--
    window.onload = function ()
    {
        top.reloadEditFrame();
        [{if $updatelist == 1}]
        top.oxid.admin.updateList('[{$oxid}]');
        [{/if}]
    }
    //-->
</script>

<div id="liste">


    <form name="search" id="search" action="[{$oViewConf->getSelfLink()}]" method="post">
        [{include file="_formparams.tpl" cl="MoDHLInternetmarkeProductsList" lstrt=$lstrt actedit=$actedit oxid=$oxid fnc="" language=$actlang editlanguage=$actlang}]
        <table cellspacing="0" cellpadding="0" border="0" width="100%">
            <colgroup>
            <col width="10%">
            <col width="10%">
            <col width="69%">
            <col width="10%">
            <col width="1%">
            </colgroup>
            <tr class="listitem">
                <td valign="top" class="listfilter first" align="center">
                    <div class="r1"><div class="b1">
                            <input class="listedit" type="text" size="50" maxlength="128" name="where[mo_dhl_internetmarke_products][oxid]" value="[{$where.mo_dhl_internetmarke_products.oxid}]">

                        </div></div>
                </td>
                <td valign="top" class="listfilter">
                    <div class="r1"><div class="b1">
                            <input class="listedit" type="text" size="50" maxlength="128" name="where[mo_dhl_internetmarke_products][name]" value="[{$where.mo_dhl_internetmarke_products.name}]">
                        </div></div>
                </td>

                <td valign="top" class="listfilter" colspan="3">
                    <div class="r1"><div class="b1">

                            <input class="listedit" type="text" size="50" maxlength="128" name="where[mo_dhl_internetmarke_products][annotation]" value="[{$where.mo_dhl_internetmarke_products.annotation}]">
                            <div class="find">
                                <input class="listedit" type="submit" name="submitit" value="[{oxmultilang ident="GENERAL_SEARCH"}]">
                            </div>
                        </div></div>

                </td>
            </tr>

            <tr>
                <td class="listheader first" height="15" align="center"><a href="Javascript:top.oxid.admin.setSorting( document.forms.search, '', 'oxid', 'asc');document.search.submit();" class="listheader">[{oxmultilang ident="MO_DHL__PRODWSID"}]</a></td>
                <td class="listheader" height="15"><a href="Javascript:top.oxid.admin.setSorting( document.forms.search, '', 'name', 'asc');document.search.submit();" class="listheader">[{oxmultilang ident="MO_DHL__NAME"}]</a></td>
                <td class="listheader" height="15"><a href="Javascript:top.oxid.admin.setSorting( document.forms.search, '', 'annotation', 'asc');document.search.submit();" class="listheader">[{oxmultilang ident="MO_DHL__DESCRIPTION"}]</a></td>
                <td class="listheader" height="15" colspan="2"><a href="Javascript:top.oxid.admin.setSorting( document.forms.search, '', 'price', 'asc');document.search.submit();" class="listheader">[{oxmultilang ident="MO_DHL__PRICE"}]</a></td>
            </tr>

            [{assign var="blWhite" value=""}]
            [{assign var="_cnt" value=0}]
            [{foreach from=$mylist item=listitem}]
            [{assign var="_cnt" value=$_cnt+1}]
            <tr id="row.[{$_cnt}]">
                [{block name="admin_language_list_item"}]
                [{if $listitem->blacklist == 1}]
                [{assign var="listclass" value=listitem3}]
                [{else}]
                [{assign var="listclass" value=listitem$blWhite}]
                [{/if}]
                [{if $listitem->getId() == $oxid}]
                [{assign var="listclass" value=listitem4}]
                [{/if}]
                <td valign="top" class="[{$listclass}]" height="15"><div class="listitemfloating">&nbsp;<a href="Javascript:top.oxid.admin.editThis('[{$listitem->getId()}]');" class="[{$listclass}]">[{$listitem->getId()}]</a></div></td>
                <td valign="top" class="[{$listclass}]" height="15"><div class="listitemfloating"><a href="Javascript:top.oxid.admin.editThis('[{$listitem->getId()}]');" class="[{$listclass}]">[{$listitem->getFieldData('name')}]</a></div></td>
                <td valign="top" class="[{$listclass}]" height="15"><div class="listitemfloating"><a href="Javascript:top.oxid.admin.editThis('[{$listitem->getId()}]');" class="[{$listclass}]">[{$listitem->getFieldData('annotation')}]</a></div></td>
                <td valign="top" class="[{$listclass}]" height="15"><div class="listitemfloating"><a href="Javascript:top.oxid.admin.editThis('[{$listitem->getId()}]');" class="[{$listclass}]">[{oxprice price=$listitem->getFieldData('price')}]</a></div></td>
                <td align="right" class="[{$listclass}]">
                    [{if !$readonly && !$listitem->default}]
                    <a href="Javascript:top.oxid.admin.deleteThis('[{$listitem->getId()}]');" class="delete" id="del.[{$_cnt}]" title="" [{include file="help.tpl" helpid=item_delete}]></a>
                    [{/if}]
                </td>
                [{/block}]
            </tr>
            [{if $blWhite == "2"}]
            [{assign var="blWhite" value=""}]
            [{else}]
            [{assign var="blWhite" value="2"}]
            [{/if}]
            [{/foreach}]
            [{include file="pagenavisnippet.tpl" colspan="5"}]
        </table>
    </form>
</div>


[{include file="pagetabsnippet.tpl"}]

<script type="text/javascript">
    if (parent.parent)
    {   parent.parent.sShopTitle   = "[{$actshopobj->oxshops__oxname->getRawValue()|oxaddslashes}]";
        parent.parent.sMenuItem    = "[{oxmultilang ident="LANGUAGE_LIST_MENUITEM"}]";
        parent.parent.sMenuSubItem = "[{oxmultilang ident="LANGUAGE_LIST_MENUSUBITEM"}]";
        parent.parent.sWorkArea    = "[{$_act}]";
        parent.parent.setTitle();
    }
</script>
</body>
</html>
