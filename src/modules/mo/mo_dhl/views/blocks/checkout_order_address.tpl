[{$smarty.block.parent}]
[{oxstyle include=$oViewConf->getModuleUrl("mo_empfaengerservices", "out/src/css/widgets/mo_empfaengerservices.css")}]
[{oxscript include=$oViewConf->getModuleUrl("mo_empfaengerservices", "out/src/js/widgets/mo_empfaengerservices__deliveryAddress.js")}]

[{if $oViewConf->moHasAncestorTheme('azure')}]
    [{oxscript add='$(function(){mo_empfaengerservices__deliveryAddress.rearrangeAddress($(".shippingAddress > dd"));});'}]
[{elseif $oViewConf->moHasAncestorTheme('flow')}]
    [{oxscript add='$(function(){$("div#orderAddress").find(".panel-body").html(function () { return mo_empfaengerservices__deliveryAddress.reformatAdressString($(this).html()); });});'}]
[{/if}]

[{assign var="location" value=$oView->mo_empfaengerservices__getLocation()}]
[{if $location[0] || $oView->mo_empfaengerservices__getTime() || $oView->mo_empfaengerservices__getWunschtag()}]
    [{oxscript include=$oViewConf->getModuleUrl("mo_empfaengerservices", "out/src/js/widgets/mo_empfaengerservices__wunschpaket.js") priority=9}]
    [{oxscript add='$(function(){mo_empfaengerservices__wunschpaket.moveWunschpaketBoxes();});'}]
[{/if}]
[{if $oViewConf->moHasAncestorTheme('azure')}]
    [{if $oView->mo_empfaengerservices__isAWunschpaketServiceSelected()}]
        <div class="moEmpfaengerserviceWunschpaketBox has--content is--azure">
            <h3 class="section">
                <strong>[{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHPAKET_CHECKOUT_HEADER"}]</strong>
                <a href="[{oxgetseourl ident=$oViewConf->getOrderLink()}]">
                    <button type="submit" class="submitButton largeButton">[{oxmultilang ident="EDIT"}]</button>
                </a>
            </h3>
            <dl>
                <dd>
                    <div id="moEmpfaengerservicesWunschpaket">
                        <img src="[{$oViewConf->getModuleUrl("mo_empfaengerservices", "out/src/img/DHL_rgb_265px.png")}]"/>

                        <h3>[{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHPAKET_CHECKOUT"}]</h3>

                        [{if $oView->mo_empfaengerservices__getWunschtag()}]
                            [{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHTAG"}]
                            [{$oView->mo_empfaengerservices__getWunschtag()}]
                            <br>
                        [{/if}]
                        [{if $oView->mo_empfaengerservices__getTime()}]
                            [{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHZEIT"}]
                            [{$oView->mo_empfaengerservices__getTime()}]
                            <br>
                        [{/if}]
                        [{if $location[0]}]
                            [{if $location[0] == 'Wunschnachbar'}]
                                [{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHNACHBAR"}]
                                [{assign var="privacyLink" value=$oViewConf->moGetPrivacyLinkForWunschpaket()}]
                                [{if $privacyLink}]
                                    <span class="font-weight--normal">
                                        (<a class="privacy-policy" href="[{$privacyLink}]"
                                            target="_blank">[{oxmultilang ident="MO_EMPFAENGERSERVICES__PRIVACY_LINK_SHORT"}]</a>)
                                    </span>
                                [{/if}]
                                <br/>
                                [{$location[2]}]
                                [{$location[1]}]
                                <br/>

                            [{else}]
                                [{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHORT"}]
                                [{$location[1]}]
                            [{/if}]
                            <br>
                        [{/if}]

                        [{include file="mo_empfaengerservices__surcharge.tpl"}]

                    </div>
                </dd>
            </dl>


        </div>
    [{elseif $oView->mo_empfaengerservices__canAWunschpaketServiceBeSelected()}]
        <div class="moEmpfaengerserviceWunschpaketBox">
            <h3 class="section">
                <strong>[{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHPAKET_CHECKOUT_HEADER"}]</strong>
                <a href="[{oxgetseourl ident=$oViewConf->getOrderLink()}]">
                    <button type="submit" class="submitButton largeButton">[{oxmultilang ident="EDIT"}]</button>
                </a>
            </h3>
            <dl>
                <div id="moEmpfaengerservicesWunschpaket">
                    <img src="[{$oViewConf->getModuleUrl("mo_empfaengerservices", "out/src/img/DHL_rgb_265px.png")}]"/>

                    <h3>[{oxmultilang ident="MO_EMPFAENGERSERVICES__NO_WUNSCHPAKET"}]</h3>
                    <p>
                        [{'MO_EMPFAENGERSERVICES__WUNSCHPAKET_DESCRIPTION_CHANGE'|oxmultilangassign|sprintf:$oViewConf->getOrderLink()}]
                    </p>
                    <p>[{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHPAKET_DESCRIPTION_SHORT"}]</p>
                </div>
            </dl>
        </div>
    [{/if}]
[{elseif $oViewConf->moHasAncestorTheme('flow')}]
    [{if $oView->mo_empfaengerservices__isAWunschpaketServiceSelected()}]
        <div class="col-xs-12 col-md-6 moEmpfaengerserviceWunschpaketBox no--padding-left">
            <div class="panel panel-default" id="moEmpfaengerservicesCheckoutBox">
                <div class="panel-heading">
                    <img class="moEmpfaengerserviceWunschpaketBox--image"
                         src="[{$oViewConf->getModuleUrl("mo_empfaengerservices", "out/src/img/DHL_rgb_265px.png")}]"/>
                    <a href="[{oxgetseourl ident=$oViewConf->getOrderLink()}]">
                        <button type="submit" class="btn btn-xs btn-warning pull-right submitButton largeButton"
                                title="[{oxmultilang ident="EDIT"}]">
                            <i class="fa fa-pencil"></i>
                        </button>
                    </a>
                </div>
                <div class="panel-body">
                    <h3 class="no--margin-top">[{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHPAKET_CHECKOUT"}]</h3>
                    [{if $oView->mo_empfaengerservices__getWunschtag()}]
                        <span class="title">
                            [{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHTAG"}]
                        </span>
                        <span class="desc">
                            [{$oView->mo_empfaengerservices__getWunschtag()}]
                        </span>
                        <br>
                    [{/if}]
                    [{if $oView->mo_empfaengerservices__getTime()}]
                        <span class="title">
                            [{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHZEIT"}]
                        </span>
                        <span class="desc">
                            [{$oView->mo_empfaengerservices__getTime()}]
                        </span>
                        <br>
                    [{/if}]
                    [{if $location[0]}]
                        [{if $location[0] == 'Wunschnachbar'}]
                            <span class="title">
                                [{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHNACHBAR"}]
                                [{assign var="privacyLink" value=$oViewConf->moGetPrivacyLinkForWunschpaket()}]
                                [{if $privacyLink}]
                                    <span class="font-weight--normal">
                                        (<a class="privacy-policy" href="[{$privacyLink}]"
                                            target="_blank">[{oxmultilang ident="MO_EMPFAENGERSERVICES__PRIVACY_LINK_SHORT"}]</a>)
                                    </span>
                                [{/if}]
                            </span>
                            <span class="desc">
                                [{$location[2]}]
                            </span>
                            <span class="desc">
                                [{$location[1]}]
                            </span>
                        [{else}]
                            <span class="title">
                                [{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHORT"}]
                            </span>
                            <span class="desc">
                                [{$location[1]}]
                            </span>
                        [{/if}]
                        <br>
                    [{/if}]

                    [{include file="mo_empfaengerservices__surcharge.tpl"}]

                </div>
            </div>
        </div>
    [{elseif $oView->mo_empfaengerservices__canAWunschpaketServiceBeSelected()}]
        <div class="col-xs-12 col-md-6 moEmpfaengerserviceWunschpaketBox no--padding-left">
            <div class="panel panel-default" id="moEmpfaengerservicesCheckoutBox">
                <div class="panel-heading">
                    <img class="moEmpfaengerserviceWunschpaketBox--image"
                         src="[{$oViewConf->getModuleUrl("mo_empfaengerservices", "out/src/img/DHL_rgb_265px.png")}]"/>
                    <a href="[{oxgetseourl ident=$oViewConf->getOrderLink()}]">
                        <button type="submit" class="btn btn-xs btn-warning pull-right submitButton largeButton"
                                title="[{oxmultilang ident="EDIT"}]">
                            <i class="fa fa-pencil"></i>
                        </button>
                    </a>
                </div>
                <div class="panel-body">
                    <h3 class="no--margin-top">[{oxmultilang ident="MO_EMPFAENGERSERVICES__NO_WUNSCHPAKET"}]</h3>
                    <p>
                        [{'MO_EMPFAENGERSERVICES__WUNSCHPAKET_DESCRIPTION_CHANGE'|oxmultilangassign|sprintf:$oViewConf->getOrderLink()}]
                    </p>
                    <p>[{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHPAKET_DESCRIPTION_SHORT"}]</p>
                </div>
            </div>
        </div>
    [{/if}]
[{elseif $oViewConf->moHasAncestorTheme('wave')}]
    [{if $oView->mo_empfaengerservices__isAWunschpaketServiceSelected()}]
        <div class="row">
            <div class="col-12 col-md-6 moEmpfaengerserviceWunschpaketBox">
                <div>
                    <div class="card" id="moEmpfaengerservicesCheckoutBox">
                        <div class="card-header">
                            <img class="moEmpfaengerserviceWunschpaketBox--image"
                                 src="[{$oViewConf->getModuleUrl("mo_empfaengerservices", "out/src/img/DHL_rgb_265px.png")}]"/>
                            <a href="[{oxgetseourl ident=$oViewConf->getOrderLink()}]">
                                <button type="submit" class="btn btn-sm btn-warning float-right submitButton largeButton edit-button"
                                        title="[{oxmultilang ident="EDIT"}]">
                                    <i class="fa fa-pencil-alt"></i>
                                </button>
                            </a>
                        </div>
                        <div class="card-body">
                            <h3 class="no--margin-top">[{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHPAKET_CHECKOUT"}]</h3>
                            [{if $oView->mo_empfaengerservices__getWunschtag()}]
                                <span class="title">
                                    [{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHTAG"}]
                                </span>
                                <span class="desc">
                                    [{$oView->mo_empfaengerservices__getWunschtag()}]
                                </span>
                                <br>
                            [{/if}]
                            [{if $oView->mo_empfaengerservices__getTime()}]
                                <span class="title">
                                    [{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHZEIT"}]
                                </span>
                                <span class="desc">
                                    [{$oView->mo_empfaengerservices__getTime()}]
                                </span>
                                <br>
                            [{/if}]
                            [{if $location[0]}]
                                [{if $location[0] == 'Wunschnachbar'}]
                                    <span class="title">
                                        [{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHNACHBAR"}]
                                        [{assign var="privacyLink" value=$oViewConf->moGetPrivacyLinkForWunschpaket()}]
                                        [{if $privacyLink}]
                                            <span class="font-weight--normal">
                                                (<a class="privacy-policy" href="[{$privacyLink}]"
                                                    target="_blank">[{oxmultilang ident="MO_EMPFAENGERSERVICES__PRIVACY_LINK_SHORT"}]</a>)
                                            </span>
                                        [{/if}]
                                    </span>
                                    <span class="desc">
                                        [{$location[2]}]
                                    </span>
                                    <span class="desc">
                                        [{$location[1]}]
                                    </span>
                                [{else}]
                                    <span class="title">
                                        [{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHORT"}]
                                    </span>
                                    <span class="desc">
                                        [{$location[1]}]
                                    </span>
                                [{/if}]
                                <br>
                            [{/if}]

                            [{include file="mo_empfaengerservices__surcharge.tpl"}]
                        </div>
                    </div>
                </div>
            </div>
        </div>
    [{elseif $oView->mo_empfaengerservices__canAWunschpaketServiceBeSelected()}]
        <div class="row">
            <div class="col-12 col-md-6 moEmpfaengerserviceWunschpaketBox">
                <div>
                    <div class="card" id="moEmpfaengerservicesCheckoutBox">
                        <div class="card-header">
                            <img class="moEmpfaengerserviceWunschpaketBox--image"
                                 src="[{$oViewConf->getModuleUrl("mo_empfaengerservices", "out/src/img/DHL_rgb_265px.png")}]"/>
                            <a href="[{oxgetseourl ident=$oViewConf->getOrderLink()}]">
                                <button type="submit" class="btn btn-sm btn-warning float-right submitButton largeButton edit-button"
                                        title="[{oxmultilang ident="EDIT"}]">
                                    <i class="fa fa-pencil-alt"></i>
                                </button>
                            </a>
                        </div>
                        <div class="card-body">
                            <h3 class="no--margin-top">[{oxmultilang ident="MO_EMPFAENGERSERVICES__NO_WUNSCHPAKET"}]</h3>
                            <p>
                                [{'MO_EMPFAENGERSERVICES__WUNSCHPAKET_DESCRIPTION_CHANGE'|oxmultilangassign|sprintf:$oViewConf->getOrderLink()}]
                            </p>
                            <p>[{oxmultilang ident="MO_EMPFAENGERSERVICES__WUNSCHPAKET_DESCRIPTION_SHORT"}]</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    [{/if}]
[{/if}]
