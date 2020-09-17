[{capture append="oxidBlock_content"}]
    [{assign var="template_title" value="ORDER_HISTORY"|oxmultilangassign}]
    <h1 class="page-header">Guest order</h1>

    [{block name="account_order_history"}]
    [{if $order && !empty($order)}]
    <ol class="list-unstyled">
        <li>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <strong>[{oxmultilang ident="DD_ORDER_ORDERDATE"}]</strong>
                            <span id="accOrderDate_[{$order->oxorder__oxordernr->value}]">[{$order->oxorder__oxorderdate->value|date_format:"%d.%m.%Y"}]</span>
                            <span>[{$order->oxorder__oxorderdate->value|date_format:"%H:%M:%S"}]</span>
                        </div>
                        <div class="col-xs-3">
                            <strong>[{oxmultilang ident="STATUS"}]</strong>
                            <span id="accOrderStatus_[{$order->oxorder__oxordernr->value}]">
                                            [{if $order->oxorder__oxstorno->value}]
                                                <span class="note">[{oxmultilang ident="ORDER_IS_CANCELED"}]</span>
                                            [{elseif $order->oxorder__oxsenddate->value !="-"}]
                                                <span>[{oxmultilang ident="SHIPPED"}]</span>
                                            [{else}]
                                                <span class="note">[{oxmultilang ident="NOT_SHIPPED_YET"}]</span>
                                            [{/if}]
                                        </span>
                        </div>
                        <div class="col-xs-3">
                            <strong>[{oxmultilang ident="ORDER_NUMBER"}]</strong>
                            <span id="accOrderNo_[{$order->oxorder__oxordernr->value}]">[{$order->oxorder__oxordernr->value}]</span>
                        </div>
                        <div class="col-xs-3">
                            <strong>[{oxmultilang ident="SHIPMENT_TO"}]</strong>
                            <span id="accOrderName_[{$order->oxorder__oxordernr->value}]">
                                            [{if $order->oxorder__oxdellname->value}]
                                                [{$order->oxorder__oxdelfname->value}]
                                                [{$order->oxorder__oxdellname->value}]
                                            [{else}]
                                                [{$order->oxorder__oxbillfname->value}]
                                                [{$order->oxorder__oxbilllname->value}]
                                            [{/if}]
                                        </span>
                            [{if $order->getShipmentTrackingUrl()}]
                            &nbsp;|&nbsp;<strong>[{oxmultilang ident="TRACKING_ID"}]</strong>
                            <span id="accOrderTrack_[{$order->oxorder__oxordernr->value}]">
                                                <a href="[{$order->getShipmentTrackingUrl()}]">[{oxmultilang ident="TRACK_SHIPMENT"}]</a>
                                            </span>
                            [{/if}]
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <strong>[{oxmultilang ident="CART"}]</strong>
                    [{block name="account_order_history_cart_items"}]
                    <ol class="list-unstyled">
                        [{foreach from=$order->getOrderArticles(true) item=orderitem name=testOrderItem}]
                        [{assign var=sArticleId value=$orderitem->oxorderarticles__oxartid->value}]
                        <li id="accOrderAmount_[{$order->oxorder__oxordernr->value}]_[{$smarty.foreach.testOrderItem.iteration}]">
                            [{$orderitem->oxorderarticles__oxamount->value}] [{oxmultilang ident="QNT"}]
                            [{$orderitem->oxorderarticles__oxtitle->value}] [{$orderitem->oxorderarticles__oxselvariant->value}] <span class="amount"></span>
                            [{foreach key=sVar from=$orderitem->getPersParams() item=aParam}]
                            [{if $aParam}]
                        <br />[{oxmultilang ident="DETAILS"}]: [{$aParam}]
                            [{/if}]
                            [{/foreach}]
                        </li>
                        [{/foreach}]
                    </ol>
                    [{/block}]
                </div>
            </div>
        </li>
    </ol>
    [{include file="widget/locator/listlocator.tpl" locator=$oView->getPageNavigation() place="bottom"}]
    [{else}]
    [{oxmultilang ident="ORDER_EMPTY_HISTORY"}]
    [{/if}]
    [{/block}]
    [{insert name="oxid_tracker" title=$template_title}]
    [{/capture}]
[{capture append="oxidBlock_sidebar"}]
    [{include file="page/account/inc/account_menu.tpl" active_link="orderhistory"}]
    [{/capture}]

[{include file="layout/page.tpl"}]