[{include file="headitem.tpl" title="MO_EMPFAENGERSERVICES__EXPORT_TITLE"|oxmultilangassign box=" "}]

<h1>[{oxmultilang ident="MO_EMPFAENGERSERVICES__EXPORT_TITLE"}]</h1>

<form name="exportForm" id="exportForm" action="[{$oViewConf->getSelfLink()}]" method="post" onsubmit="handleSubmit()">
    <input type="hidden" name="cl" value="[{$oViewConf->getActiveClassName()}]">
    <input type="hidden" name="fnc" value="export">
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

            <tr>
                <td class="listheader first" height="15">&nbsp;</td>
                <td class="listheader" height="15">[{oxmultilang ident="ORDER_LIST_ORDERTIME"}]</td>
                <td class="listheader" height="15">[{oxmultilang ident="ORDER_LIST_PAID" }]</td>
                <td class="listheader" height="15">[{oxmultilang ident="GENERAL_ORDERNUM" }]</td>
                <td class="listheader" height="15">[{oxmultilang ident="ORDER_LIST_CUSTOMERFNAME"}]</td>
                <td class="listheader" height="15" colspan="2">[{oxmultilang ident="ORDER_LIST_CUSTOMERLNAME"}]</td>
            </tr>

            [{assign var="orderInformation" value=$oView->loadOrders()}]
            [{foreach from=$orderInformation.orders item=listitem}]
            <tr>
                <td class="listitem">
                    <input type="checkbox" name="order[]" value="[{$listitem->oxorder__oxid}]"/>
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
            </tr>
            [{/foreach}]

            [{assign var="page" value=$orderInformation.page}]
            [{assign var="pages" value=$orderInformation.pages}]
            <tr>
                <td class="pagination" colspan="6">
                    <div class="r1">
                        <div class="b1">

                            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td id="nav.site" class="pagenavigation" align="left" width="33%">
                                        [{oxmultilang ident="NAVIGATION_PAGE"}] [{$page}] / [{$pages}]
                                    </td>
                                    <td class="pagenavigation" height="22" align="center" width="33%">
                                        [{math assign="start" equation="max(1, $page-3)"}]
                                        [{math assign="end" equation="min($page+3, $pages)"}]
                                        [{foreach from=$start|range:$end item="i"}]
                                        <a id="nav.page.[{$i}]" class="pagenavigation[{if $i == $page}] pagenavigationactive[{/if}]" href="[{$oViewConf->getSelfLink()}]&cl=[{$oViewConf->getActiveClassName()}]&amp;page=[{$i}]">[{$i}]</a>
                                        [{/foreach}]
                                    </td>
                                    <td class="pagenavigation" align="right" width="33%">
                                        <a id="nav.first" class="pagenavigation" href="[{$oViewConf->getSelfLink()}]&cl=[{$oViewConf->getActiveClassName()}]&amp;page=1">[{oxmultilang ident="GENERAL_LIST_FIRST"}]</a>
                                        <a id="nav.prev" class="pagenavigation" href="[{$oViewConf->getSelfLink()}]&cl=[{$oViewConf->getActiveClassName()}]&amp;page=[{math equation="max(1, $page-1)"}]">[{oxmultilang ident="GENERAL_LIST_PREV"}]</a>
                                        <a id="nav.next" class="pagenavigation" href="[{$oViewConf->getSelfLink()}]&cl=[{$oViewConf->getActiveClassName()}]&amp;page=[{math equation="min($page + 1, $pages)"}]">[{oxmultilang ident="GENERAL_LIST_NEXT"}]</a>
                                        <a id="nav.last" class="pagenavigation" href="[{$oViewConf->getSelfLink()}]&cl=[{$oViewConf->getActiveClassName()}]&amp;page=[{$pages}]">[{oxmultilang ident="GENERAL_LIST_LAST"}]</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <input type="submit" class="edittext" id="submitButton" name="submitButton" value="[{oxmultilang ident="MO_EMPFAENGERSERVICES__EXPORT"}]"/>
</form>

[{include file="bottomnaviitem.tpl"}]
[{include file="bottomitem.tpl"}]