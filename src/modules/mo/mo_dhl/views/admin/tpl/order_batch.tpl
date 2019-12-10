[{include file="headitem.tpl" title="MO_DHL__BATCH_TITLE"|oxmultilangassign box=" "}]
[{assign var="where" value=$oView->getListFilter()}]

<h1>[{oxmultilang ident="MO_DHL__BATCH_TITLE"}]</h1>
<form name="batchForm" id="batchForm" action="[{$oViewConf->getSelfLink()}]" method="post">
    <input type="hidden" name="cl" value="[{$oViewConf->getActiveClassName()}]">
    <input type="hidden" name="fnc" value="">
    [{$oViewConf->getHiddenSid()}]
    <div id="liste">
        <table cellspacing="0" cellpadding="0" border="0" width="100%">
            <colgroup>
                <col width="2%">
                <col width="25%">
                <col width="25%">
                <col width="10%">
                <col width="17%">
                <col width="17%">
            </colgroup>

            <tr class="listitem">
                <td></td>
                <td valign="top" class="listfilter first" height="20">
                    <div class="r1">
                        <div class="b1">
                            <select name="folder" class="folderselect" onChange="document.batchForm.submit();">
                                <option value="-1"
                                        style="color: #000000;">[{oxmultilang ident="ORDER_LIST_FOLDER_ALL"}]</option>
                                [{foreach from=$afolder key=field item=color}]
                                    <option value="[{$field}]" [{if $folder == $field}]SELECTED[{/if}]
                                            style="color: [{$color}];">[{oxmultilang ident=$field noerror=true}]</option>
                                [{/foreach}]
                            </select>
                            <input class="listedit" type="text" size="15" maxlength="128"
                                   name="where[oxorder][oxorderdate]"
                                   value="[{$where.oxorder.oxorderdate|oxformdate}]" [{include file="help.tpl" helpid=order_date}]>
                        </div>
                    </div>
                </td>
                <td valign="top" class="listfilter" height="20">
                    <div class="r1">
                        <div class="b1">
                            <select name="addsearchfld" class="folderselect">
                                <option value="-1"
                                        style="color: #000000;">[{oxmultilang ident="ORDER_LIST_PAID"}]</option>
                                [{foreach from=$asearch key=table item=desc}]
                                    [{assign var="ident" value=ORDER_SEARCH_FIELD_$desc}]
                                    [{assign var="ident" value=$ident|oxupper}]
                                    <option value="[{$table}]"
                                            [{if $addsearchfld == $table}]SELECTED[{/if}]>[{oxmultilang|oxtruncate:20:"..":true ident=$ident}]</option>
                                [{/foreach}]
                            </select>
                            <input class="listedit" type="text" size="15" maxlength="128" name="addsearch"
                                   value="[{$addsearch}]">
                        </div>
                    </div>
                </td>
                <td valign="top" class="listfilter" height="20">
                    <div class="r1">
                        <div class="b1">
                            <input class="listedit" type="text" size="7" maxlength="128"
                                   name="where[oxorder][oxordernr]" value="[{$where.oxorder.oxordernr}]">
                        </div>
                    </div>
                </td>
                <td valign="top" class="listfilter" height="20">
                    <div class="r1">
                        <div class="b1">
                            <input class="listedit" type="text" size="50" maxlength="128"
                                   name="where[oxorder][oxbillfname]" value="[{$where.oxorder.oxbillfname}]">
                        </div>
                    </div>
                </td>
                <td valign="top" class="listfilter" height="20">
                    <div class="r1">
                        <div class="b1">
                            <input class="listedit" type="text" size="50" maxlength="128"
                                   name="where[oxorder][oxbilllname]" value="[{$where.oxorder.oxbilllname}]">
                        </div>
                    </div>
                </td>
                <td valign="top" class="listfilter" height="20" colspan="2" nowrap>
                    <div class="r1">
                        <div class="b1">
                            <div class="find"><input class="listedit" type="submit" name="submitit"
                                                     value="[{oxmultilang ident="GENERAL_SEARCH"}]"></div>
                            <input class="listedit" type="text" size="50" maxlength="128"
                                   name="where[oxorder][mo_dhl_last_label_creation_status]"
                                   value="[{$where.oxorder.mo_dhl_last_label_creation_status}]">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="listheader first" height="15">
                    <input type="checkbox"
                           onclick="self=this;Array.prototype.forEach.call(document.getElementsByClassName('moDHLOrderCheckbox'), function(el) {el.checked = self.checked;});"
                    />
                </td>
                <td class="listheader" height="15">[{oxmultilang ident="ORDER_LIST_ORDERTIME"}]</td>
                <td class="listheader" height="15">[{oxmultilang ident="ORDER_LIST_PAID" }]</td>
                <td class="listheader" height="15">[{oxmultilang ident="GENERAL_ORDERNUM" }]</td>
                <td class="listheader" height="15">[{oxmultilang ident="ORDER_LIST_CUSTOMERFNAME"}]</td>
                <td class="listheader" height="15">[{oxmultilang ident="ORDER_LIST_CUSTOMERLNAME"}]</td>
                <td class="listheader" height="15">[{oxmultilang ident="MO_DHL__LAST_DHL_STATUS"}]</td>
            </tr>
            [{foreach from=$mylist item=listitem}]
            <tr>
                <td class="listitem">
                    <input type="checkbox" class="moDHLOrderCheckbox" name="order[]"
                           value="[{$listitem->oxorder__oxid}]"/>
                </td>
                <td valign="top" class="listitem" height="15">
                    <div class="listitemfloating">[{$listitem->oxorder__oxorderdate|oxformdate:'datetime':true}]</div>
                </td>
                <td valign="top" class="listitem" height="15">
                    <div class="listitemfloating">[{$listitem->oxorder__oxpaid|oxformdate}]</div>
                </td>
                <td valign="top" class="listitem" height="15">
                    <div class="listitemfloating">[{$listitem->oxorder__oxordernr->value}]</div>
                </td>
                <td valign="top" class="listitem" height="15">
                    <div class="listitemfloating">[{$listitem->oxorder__oxbillfname->value}]</div>
                </td>
                <td valign="top" class="listitem" height="15">
                    <div class="listitemfloating">[{$listitem->oxorder__oxbilllname->value}]</div>
                </td>
                <td valign="top" class="listitem" height="15">
                    <div class="listitemfloating">[{$listitem->oxorder__mo_dhl_last_label_creation_status->value}]</div>
                </td>
            </tr>
            [{/foreach}]

            [{assign var="linkSort" value=""}]
            [{foreach from=$oView->getListSorting() item=aField key=sTable}]
                [{foreach from=$aField item=sSorting key=sField}]
                    [{assign var="linkSort" value=$linkSort|cat:"sort["|cat:$sTable|cat:"]["|cat:$sField|cat:"]="|cat:$sSorting|cat:"&amp;"}]
                [{/foreach}]
            [{/foreach}]

            [{assign var="whereparam" value="&amp;"}]
            [{foreach from=$where item=aField key=sTable}]
                [{foreach from=$aField item=sFilter key=sField}]
                    [{assign var="whereparam" value=$whereparam|cat:"where["|cat:$sTable|cat:"]["|cat:$sField|cat:"]="|cat:$sFilter|cat:"&amp;"}]
                [{/foreach}]
            [{/foreach}]
            [{assign var="viewListSize" value=$oView->getViewListSize()}]
            [{assign var="whereparam" value=$whereparam|cat:"viewListSize="|cat:$viewListSize}]

            <tr>
                <td class="pagination" colspan="7">
                    <div class="r1">
                        <div class="b1">
                            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td class="pagenavigation" align="left" width="22%">
                                        [{oxmultilang ident="MO_DHL__ELEMENTS_PER_PAGE"}]
                                        <select name="viewListSize" onChange="document.batchForm.submit();">
                                            [{assign var="sizes" value=$oView->getListSizeOptions()}]
                                            [{foreach from=$sizes item="size"}]
                                                <option value="[{$size}]"
                                                        [{if $size === $viewListSize}]selected[{/if}]>[{$size}]</option>
                                            [{/foreach}]
                                        </select>
                                    </td>
                                    [{if $pagenavi}]
                                        <td id="nav.site" class="pagenavigation" align="left" width="11%">
                                            [{oxmultilang ident="NAVIGATION_PAGE"}] [{$pagenavi->actpage}]
                                            / [{$pagenavi->pages}]
                                        </td>
                                        <td class="pagenavigation" height="22" align="center" width="33%">
                                            [{foreach key=iPage from=$pagenavi->changePage item=page}]
                                                <a id="nav.page.[{$iPage}]"
                                                   class="pagenavigation[{if $iPage == $pagenavi->actpage}] pagenavigationactive[{/if}]"
                                                   href="[{$oViewConf->getSelfLink()}]&cl=[{$oViewConf->getActiveClassName()}]&amp;oxid=[{$oxid}]&amp;jumppage=[{$iPage}]&amp;[{$linkSort}]actedit=[{$actedit}]&amp;language=[{$actlang}]&amp;editlanguage=[{$actlang}][{$whereparam}]&amp;folder=[{$folder}]&amp;pwrsearchfld=[{$pwrsearchfld}]&amp;art_category=[{$art_category}]">[{$iPage}]</a>
                                            [{/foreach}]
                                        </td>
                                        <td class="pagenavigation" align="right" width="33%">
                                            <a id="nav.first" class="pagenavigation"
                                               href="[{$oViewConf->getSelfLink()}]&cl=[{$oViewConf->getActiveClassName()}]&amp;oxid=[{$oxid}]&amp;jumppage=1&amp;[{$linkSort}]&amp;actedit=[{$actedit}]&amp;language=[{$actlang}]&amp;editlanguage=[{$actlang}][{$whereparam}]&amp;folder=[{$folder}]&amp;pwrsearchfld=[{$pwrsearchfld}]&amp;art_category=[{$art_category}]">[{oxmultilang ident="GENERAL_LIST_FIRST"}]</a>
                                            <a id="nav.prev" class="pagenavigation"
                                               href="[{$oViewConf->getSelfLink()}]&cl=[{$oViewConf->getActiveClassName()}]&amp;oxid=[{$oxid}]&amp;jumppage=[{if $pagenavi->actpage-1 > 0}][{$pagenavi->actpage-1 > 0}][{else}]1[{/if}]&amp;[{$linkSort}]&amp;actedit=[{$actedit}]&amp;language=[{$actlang}]&amp;editlanguage=[{$actlang}][{$whereparam}]&amp;folder=[{$folder}]&amp;pwrsearchfld=[{$pwrsearchfld}]&amp;art_category=[{$art_category}]">[{oxmultilang ident="GENERAL_LIST_PREV"}]</a>
                                            <a id="nav.next" class="pagenavigation"
                                               href="[{$oViewConf->getSelfLink()}]&cl=[{$oViewConf->getActiveClassName()}]&amp;oxid=[{$oxid}]&amp;jumppage=[{if $pagenavi->actpage+1 > $pagenavi->pages}][{$pagenavi->actpage}][{else}][{$pagenavi->actpage+1}][{/if}]&amp;[{$linkSort}]&amp;actedit=[{$actedit}]&amp;language=[{$actlang}]&amp;editlanguage=[{$actlang}][{$whereparam}]&amp;folder=[{$folder}]&amp;pwrsearchfld=[{$pwrsearchfld}]&amp;art_category=[{$art_category}]">[{oxmultilang ident="GENERAL_LIST_NEXT"}]</a>
                                            <a id="nav.last" class="pagenavigation"
                                               href="[{$oViewConf->getSelfLink()}]&cl=[{$oViewConf->getActiveClassName()}]&amp;oxid=[{$oxid}]&amp;jumppage=[{$pagenavi->pages}]&amp;[{$linkSort}]&amp;actedit=[{$actedit}]&amp;language=[{$actlang}]&amp;editlanguage=[{$actlang}][{$whereparam}]&amp;folder=[{$folder}]&amp;pwrsearchfld=[{$pwrsearchfld}]&amp;art_category=[{$art_category}]">[{oxmultilang ident="GENERAL_LIST_LAST"}]</a>
                                        </td>
                                    [{/if}]
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <input type="submit" class="edittext" id="submitButton" name="submitButton"
           value="[{oxmultilang ident="MO_DHL__EXPORT"}]"
           onClick="Javascript:document.batchForm.fnc.value='export'"/>
    <input type="submit" class="edittext" id="createLabelsButton" name="createLabelsButton"
           value="[{oxmultilang ident="MO_DHL__CREATE_LABELS"}]"
           onClick="Javascript:document.batchForm.fnc.value='createLabels'"/>
    <br>
    <br>
</form>
