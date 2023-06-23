[{$smarty.block.parent}]
[{oxstyle include=$oViewConf->getModuleUrl("mo_dhl", "out/src/css/widgets/mo_dhl.css")}]
[{oxscript include=$oViewConf->getModuleUrl("mo_dhl", "out/src/js/widgets/mo_dhl__deliveryAddress.js")}]

[{if $oViewConf->moHasAncestorTheme('azure')}]
    [{oxscript add='$(function(){mo_dhl__deliveryAddress.rearrangeAddress($(".shippingAddress > dd"));});'}]
[{elseif $oViewConf->moHasAncestorTheme('flow')}]
    [{oxscript add='$(function(){$("div#orderAddress").find(".panel-body").html(function () { return mo_dhl__deliveryAddress.reformatAdressString($(this).html()); });});'}]
[{/if}]

[{assign var="location" value=$oView->moDHLGetLocation()}]
[{if $location[0] || $oView->moDHLGetWunschtag()}]
    [{oxscript include=$oViewConf->getModuleUrl("mo_dhl", "out/src/js/widgets/mo_dhl__wunschpaket.js") priority=9}]
    [{oxscript add='$(function(){mo_dhl__wunschpaket.moveWunschpaketBoxes();});'}]
[{/if}]
[{if $oViewConf->moHasAncestorTheme('azure')}]
    [{if $oView->moDHLIsAWunschpaketServiceSelected()}]
        <div class="moEmpfaengerserviceWunschpaketBox has--content is--azure">
            <h3 class="section">
                <strong>[{oxmultilang ident="MO_DHL__WUNSCHPAKET_CHECKOUT_HEADER"}]</strong>
                <a href="[{oxgetseourl ident=$oViewConf->getOrderLink()}]">
                    <button type="submit" class="submitButton largeButton">[{oxmultilang ident="EDIT"}]</button>
                </a>
            </h3>
            <dl>
                <dd>
                    <div id="moDHLWunschpaket">
                        <img src="[{$oViewConf->getModuleUrl("mo_dhl", "out/src/img/DHL_rgb_265px.png")}]"/>

                        <h3>[{oxmultilang ident="MO_DHL__WUNSCHPAKET_CHECKOUT"}]</h3>

                        [{if $oView->moDHLGetWunschtag()}]
                            [{oxmultilang ident="MO_DHL__WUNSCHTAG"}]
                            [{$oView->moDHLGetWunschtag()}]
                            <br>
                        [{/if}]
                        [{if $location[0]}]
                            [{if $location[0] == 'Wunschnachbar'}]
                                [{oxmultilang ident="MO_DHL__WUNSCHNACHBAR"}]
                                [{assign var="privacyLink" value=$oViewConf->moGetPrivacyLinkForWunschpaket()}]
                                [{if $privacyLink}]
                                    <span class="font-weight--normal">
                                        (<a class="privacy-policy" href="[{$privacyLink}]"
                                            target="_blank">[{oxmultilang ident="MO_DHL__PRIVACY_LINK_SHORT"}]</a>)
                                    </span>
                                [{/if}]
                                <br/>
                                [{$location[2]}]
                                [{$location[1]}]
                                <br/>

                            [{else}]
                                [{oxmultilang ident="MO_DHL__WUNSCHORT"}]
                                [{$location[1]}]
                            [{/if}]
                            <br>
                        [{/if}]

                        [{include file="mo_dhl__surcharge.tpl"}]

                    </div>
                </dd>
            </dl>


        </div>
    [{elseif $oView->moDHLCanAWunschpaketServiceBeSelected()}]
        <div class="moEmpfaengerserviceWunschpaketBox">
            <h3 class="section">
                <strong>[{oxmultilang ident="MO_DHL__WUNSCHPAKET_CHECKOUT_HEADER"}]</strong>
                <a href="[{oxgetseourl ident=$oViewConf->getOrderLink()}]">
                    <button type="submit" class="submitButton largeButton">[{oxmultilang ident="EDIT"}]</button>
                </a>
            </h3>
            <dl>
                <div id="moDHLWunschpaket">
                    <img src="[{$oViewConf->getModuleUrl("mo_dhl", "out/src/img/DHL_rgb_265px.png")}]"/>

                    <h3>[{oxmultilang ident="MO_DHL__NO_WUNSCHPAKET"}]</h3>
                    <p>
                        [{'MO_DHL__WUNSCHPAKET_DESCRIPTION_CHANGE'|oxmultilangassign|sprintf:$oViewConf->getOrderLink()}]
                    </p>
                    <p>[{oxmultilang ident="MO_DHL__WUNSCHPAKET_DESCRIPTION_SHORT"}]</p>
                </div>
            </dl>
        </div>
    [{/if}]
[{elseif $oViewConf->moHasAncestorTheme('flow')}]
    [{if $oView->moDHLIsAWunschpaketServiceSelected()}]
        <div class="row moEmpfaengerserviceWunschpaketBox">
            <div class="col-xs-12 col-md-12">
                <div class="panel panel-default" id="moDHLCheckoutBox">
                    <div class="panel-heading">
                        <img class="moEmpfaengerserviceWunschpaketBox--image"
                             src="[{$oViewConf->getModuleUrl("mo_dhl", "out/src/img/DHL_rgb_265px.png")}]"/>
                        <a href="[{oxgetseourl ident=$oViewConf->getOrderLink()}]">
                            <button type="submit" class="btn btn-xs btn-warning pull-right submitButton largeButton"
                                    title="[{oxmultilang ident="EDIT"}]">
                                <i class="fa fa-pencil"></i>
                            </button>
                        </a>
                    </div>
                    <div class="panel-body">
                        <h3 class="no--margin-top">[{oxmultilang ident="MO_DHL__WUNSCHPAKET_CHECKOUT"}]</h3>
                        [{if $oView->moDHLGetWunschtag()}]
                            <span class="title">
                            [{oxmultilang ident="MO_DHL__WUNSCHTAG"}]
                        </span>
                            <span class="desc">
                            [{$oView->moDHLGetWunschtag()}]
                        </span>
                            <br>
                        [{/if}]
                        [{if $location[0]}]
                            [{if $location[0] == 'Wunschnachbar'}]
                                <span class="title">
                                [{oxmultilang ident="MO_DHL__WUNSCHNACHBAR"}]
                                    [{assign var="privacyLink" value=$oViewConf->moGetPrivacyLinkForWunschpaket()}]
                                    [{if $privacyLink}]
                                        <span class="font-weight--normal">
                                        (<a class="privacy-policy" href="[{$privacyLink}]"
                                            target="_blank">[{oxmultilang ident="MO_DHL__PRIVACY_LINK_SHORT"}]</a>)
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
                                [{oxmultilang ident="MO_DHL__WUNSCHORT"}]
                            </span>
                                <span class="desc">
                                [{$location[1]}]
                            </span>
                            [{/if}]
                            <br>
                        [{/if}]

                        [{include file="mo_dhl__surcharge.tpl"}]

                    </div>
                </div>
            </div>
        </div>
    [{elseif $oView->moDHLCanAWunschpaketServiceBeSelected()}]
        <div class="row moEmpfaengerserviceWunschpaketBox">
            <div class="col-xs-12 col-md-12">
                <div class="panel panel-default" id="moDHLCheckoutBox">
                    <div class="panel-heading">
                        <img class="moEmpfaengerserviceWunschpaketBox--image"
                             src="[{$oViewConf->getModuleUrl("mo_dhl", "out/src/img/DHL_rgb_265px.png")}]"/>
                        <a href="[{oxgetseourl ident=$oViewConf->getOrderLink()}]">
                            <button type="submit" class="btn btn-xs btn-warning pull-right submitButton largeButton"
                                    title="[{oxmultilang ident="EDIT"}]">
                                <i class="fa fa-pencil"></i>
                            </button>
                        </a>
                    </div>
                    <div class="panel-body">
                        <h3 class="no--margin-top">[{oxmultilang ident="MO_DHL__NO_WUNSCHPAKET"}]</h3>
                        <p>
                            [{'MO_DHL__WUNSCHPAKET_DESCRIPTION_CHANGE'|oxmultilangassign|sprintf:$oViewConf->getOrderLink()}]
                        </p>
                        <p>[{oxmultilang ident="MO_DHL__WUNSCHPAKET_DESCRIPTION_SHORT"}]</p>
                    </div>
                </div>
            </div>
        </div>
    [{/if}]
[{elseif $oViewConf->moHasAncestorTheme('wave')}]
    [{if $oView->moDHLIsAWunschpaketServiceSelected()}]
        <div class="row moEmpfaengerserviceWunschpaketBox">
            <div class="col-12 col-md-6">
                <div>
                    <div class="card" id="moDHLCheckoutBox">
                        <div class="card-header">
                            <img class="moEmpfaengerserviceWunschpaketBox--image"
                                 src="[{$oViewConf->getModuleUrl("mo_dhl", "out/src/img/DHL_rgb_265px.png")}]"/>
                            <a href="[{oxgetseourl ident=$oViewConf->getOrderLink()}]">
                                <button type="submit" class="btn btn-sm btn-warning float-right submitButton largeButton edit-button"
                                        title="[{oxmultilang ident="EDIT"}]">
                                    <i class="fa fa-pencil-alt"></i>
                                </button>
                            </a>
                        </div>
                        <div class="card-body">
                            <h3 class="no--margin-top">[{oxmultilang ident="MO_DHL__WUNSCHPAKET_CHECKOUT"}]</h3>
                            [{if $oView->moDHLGetWunschtag()}]
                                <span class="title">
                                    [{oxmultilang ident="MO_DHL__WUNSCHTAG"}]
                                </span>
                                <span class="desc">
                                    [{$oView->moDHLGetWunschtag()}]
                                </span>
                                <br>
                            [{/if}]
                            [{if $location[0]}]
                                [{if $location[0] == 'Wunschnachbar'}]
                                    <span class="title">
                                        [{oxmultilang ident="MO_DHL__WUNSCHNACHBAR"}]
                                        [{assign var="privacyLink" value=$oViewConf->moGetPrivacyLinkForWunschpaket()}]
                                        [{if $privacyLink}]
                                            <span class="font-weight--normal">
                                                (<a class="privacy-policy" href="[{$privacyLink}]"
                                                    target="_blank">[{oxmultilang ident="MO_DHL__PRIVACY_LINK_SHORT"}]</a>)
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
                                        [{oxmultilang ident="MO_DHL__WUNSCHORT"}]
                                    </span>
                                    <span class="desc">
                                        [{$location[1]}]
                                    </span>
                                [{/if}]
                                <br>
                            [{/if}]

                            [{include file="mo_dhl__surcharge.tpl"}]
                        </div>
                    </div>
                </div>
            </div>
        </div>
    [{elseif $oView->moDHLCanAWunschpaketServiceBeSelected()}]
        <div class="row moEmpfaengerserviceWunschpaketBox">
            <div class="col-12 col-md-6">
                <div>
                    <div class="card" id="moDHLCheckoutBox">
                        <div class="card-header">
                            <img class="moEmpfaengerserviceWunschpaketBox--image"
                                 src="[{$oViewConf->getModuleUrl("mo_dhl", "out/src/img/DHL_rgb_265px.png")}]"/>
                            <a href="[{oxgetseourl ident=$oViewConf->getOrderLink()}]">
                                <button type="submit" class="btn btn-sm btn-warning float-right submitButton largeButton edit-button"
                                        title="[{oxmultilang ident="EDIT"}]">
                                    <i class="fa fa-pencil-alt"></i>
                                </button>
                            </a>
                        </div>
                        <div class="card-body">
                            <h3 class="no--margin-top">[{oxmultilang ident="MO_DHL__NO_WUNSCHPAKET"}]</h3>
                            <p>
                                [{'MO_DHL__WUNSCHPAKET_DESCRIPTION_CHANGE'|oxmultilangassign|sprintf:$oViewConf->getOrderLink()}]
                            </p>
                            <p>[{oxmultilang ident="MO_DHL__WUNSCHPAKET_DESCRIPTION_SHORT"}]</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    [{/if}]
[{/if}]
