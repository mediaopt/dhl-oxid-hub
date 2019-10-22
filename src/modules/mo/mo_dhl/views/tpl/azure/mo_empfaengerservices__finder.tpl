<div style="display: none;">

    <span class="js-oxError_postnummer">[{oxmultilang ident="MO_EMPFAENGERSERVICES__INVALID_POSTNUMBER"}]</span>

    <p>
        <button id="moEmpfaengerservicesButton" type="button" class="submitButton">
            [{if $oViewConf->moCanPackstationBeSelected()}]
                [{if $oViewConf->moCanFilialeBeSelected()}]
                    [{oxmultilang ident="MO_EMPFAENGERSERVICES__OPEN_MODAL_SERVICE_PROVIDER"}]
                [{else}]
                    [{oxmultilang ident="MO_EMPFAENGERSERVICES__OPEN_MODAL_PACKSTATION"}]
                [{/if}]
            [{else}]
                [{oxmultilang ident="MO_EMPFAENGERSERVICES__OPEN_MODAL_FILIALE"}]
            [{/if}]
        </button>
    </p>

    <img id="thumbnail-packstation"
         src="[{$oViewConf->getModuleUrl("mo_empfaengerservices", "out/src/img/icon-packstation.png")}]"/>
    <img id="thumbnail-postfiliale"
         src="[{$oViewConf->getModuleUrl("mo_empfaengerservices", "out/src/img/icon-postfiliale.png")}]"/>
    <img id="thumbnail-paketshop"
         src="[{$oViewConf->getModuleUrl("mo_empfaengerservices", "out/src/img/icon-paketshop.png")}]"/>

    <span id="packstation-number-label">Packstationsnr.:</span>
    <span id="postfiliale-number-label">Filialnr.:</span>
    <span id="paketshop-number-label">Filialnr.:</span>

    <a id="moEmpfaengerservicesFind"
       href="[{$oViewConf->getSslSelfLink()}]cl=MoEmpfaengerservicesFinder"></a>

    <div id="moEmpfaengerservicesWindow">
        <h4></h4>
        <address></address>

        <div class="icons">
            <img class="icon packstation"
                 src="[{$oViewConf->getModuleUrl("mo_empfaengerservices", "out/src/img/icon-packstation-red.png")}]"/>
            <img class="icon filiale"
                 src="[{$oViewConf->getModuleUrl("mo_empfaengerservices", "out/src/img/icon-postfiliale-red.png")}]"/>
            <img class="icon paketshop"
                 src="[{$oViewConf->getModuleUrl("mo_empfaengerservices", "out/src/img/icon-paketshop-red.png")}]"/>
            <img class="icon wheelchair"
                 src="[{$oViewConf->getModuleUrl("mo_empfaengerservices", "out/src/img/icon-wheelchair.png")}]"/>
            <img class="icon parking"
                 src="[{$oViewConf->getModuleUrl("mo_empfaengerservices", "out/src/img/icon-parking.png")}]"/>
        </div>

        <h5 class="moEmpfaengerservicesOpeningHours"
            style="display: none;">[{oxmultilang ident="MO_EMPFAENGERSERVICES__OPENING_HOURS"}]</h5>
        <ul class="moEmpfaengerservicesOpeningHours" style="display: none;">
            <li>[{oxmultilang ident="MO_EMPFAENGERSERVICES__OPENING_HOURS_1"}]: <span
                        class="opening-hours-day-1">[{oxmultilang ident="MO_EMPFAENGERSERVICES__OPENING_HOURS_CLOSED"}]</span>
            </li>
            <li>[{oxmultilang ident="MO_EMPFAENGERSERVICES__OPENING_HOURS_2"}]: <span
                        class="opening-hours-day-2">[{oxmultilang ident="MO_EMPFAENGERSERVICES__OPENING_HOURS_CLOSED"}]</span>
            </li>
            <li>[{oxmultilang ident="MO_EMPFAENGERSERVICES__OPENING_HOURS_3"}]: <span
                        class="opening-hours-day-3">[{oxmultilang ident="MO_EMPFAENGERSERVICES__OPENING_HOURS_CLOSED"}]</span>
            </li>
            <li>[{oxmultilang ident="MO_EMPFAENGERSERVICES__OPENING_HOURS_4"}]: <span
                        class="opening-hours-day-4">[{oxmultilang ident="MO_EMPFAENGERSERVICES__OPENING_HOURS_CLOSED"}]</span>
            </li>
            <li>[{oxmultilang ident="MO_EMPFAENGERSERVICES__OPENING_HOURS_5"}]: <span
                        class="opening-hours-day-5">[{oxmultilang ident="MO_EMPFAENGERSERVICES__OPENING_HOURS_CLOSED"}]</span>
            </li>
            <li>[{oxmultilang ident="MO_EMPFAENGERSERVICES__OPENING_HOURS_6"}]: <span
                        class="opening-hours-day-6">[{oxmultilang ident="MO_EMPFAENGERSERVICES__OPENING_HOURS_CLOSED"}]</span>
            </li>
            <li>[{oxmultilang ident="MO_EMPFAENGERSERVICES__OPENING_HOURS_7"}]: <span
                        class="opening-hours-day-7">[{oxmultilang ident="MO_EMPFAENGERSERVICES__OPENING_HOURS_CLOSED"}]</span>
            </li>
        </ul>

        <button class="submitButton"
                id="provider_' + provider.id + '">[{oxmultilang ident="MO_EMPFAENGERSERVICES__SELECT"}]</button>

    </div>

    <p id="moEmpfaengerservicesUnknownError">[{oxmultilang ident="MO_EMPFAENGERSERVICES__ERROR_FINDER_UNKNOWN"}]</p>
</div>

<div id="moEmpfaengerservicesFinder" class="popupBox corners FXgradGreyLight glowShadow">
    <img src="[{$oViewConf->getImageUrl('x.png')}]" alt="" class="closePop">
    <form id="moEmpfaengerservicesFinderForm">
        <div id="moEmpfaengerservicesAddressInputs">
            <input type="text" placeholder="[{oxmultilang ident="MO_EMPFAENGERSERVICES__STREET"}]"
                   id="moEmpfaengerservicesStreet" class="is--azure" name="street"/>
            <input type="text" placeholder="[{oxmultilang ident="MO_EMPFAENGERSERVICES__POSTCODE"}] &amp; [{oxmultilang ident="MO_EMPFAENGERSERVICES__CITY"}]"
                   id="moEmpfaengerservicesLocality" class="is--azure" name="locality"/>
        </div>
        <div id="moEmpfaengerservicesProviders" class="is--azure">
        [{if $oViewConf->moCanPackstationBeSelected()}]
            [{if $oViewConf->moCanFilialeBeSelected()}]
                <input type="checkbox" id="moEmpfaengerservicesPackstation" name="packstation" checked="checked"/>
                <label for="moEmpfaengerservicesPackstation">Packstation
                    <img class="icon packstation valign--middle"
                         src="[{$oViewConf->getModuleUrl("mo_empfaengerservices", "out/src/img/icon-packstation.png")}]"/>
                </label>
            [{else}]
                <input type="hidden" id="moEmpfaengerservicesPackstation" name="packstation" value="1"/>
            [{/if}]
        [{/if}]
        [{if $oViewConf->moCanFilialeBeSelected()}]
            [{if $oViewConf->moCanPackstationBeSelected()}]
                <input type="checkbox" id="moEmpfaengerservicesFiliale" name="filiale" checked="checked"/>
                <label for="moEmpfaengerservicesFiliale">Filiale
                    <img class="icon packstation postfiliale valign--middle"
                         src="[{$oViewConf->getModuleUrl("mo_empfaengerservices", "out/src/img/icon-postfiliale.png")}]"/>
                    <img class="icon packstation paketshop valign--middle"
                         src="[{$oViewConf->getModuleUrl("mo_empfaengerservices", "out/src/img/icon-paketshop.png")}]"/>
                </label>
            [{else}]
                <input type="hidden" id="moEmpfaengerservicesFiliale" name="filiale" value="1"/>
            [{/if}]
        [{/if}]
        <button class="submitButton">[{oxmultilang ident="MO_EMPFAENGERSERVICES__SEARCH"}]</button>
        </div>
    </form>
    <div id="moEmpfaengerservicesErrors" class="status error corners" style="display:none;"></div>
    <div id="moEmpfaengerservicesMap">
    </div>
</div>

<div id="moEmpfaengerservicesInfo" class="popupBox corners FXgradGreyLight glowShadow">
    <img src="[{$oViewConf->getImageUrl('x.png')}]" alt="" class="closePop">
    <h4>[{oxmultilang ident="MO_EMPFAENGERSERVICES__POSTNUMMER_INFO_TITLE"}]</h4>
    <div>
        <img class="info--figure"
             src="[{$oViewConf->getModuleUrl('mo_empfaengerservices', 'out/src/img/dhl-postnumber-info.jpg')}]">
        <p>
            [{oxmultilang ident="MO_EMPFAENGERSERVICES__POSTNUMMER_INFO_TEXT"}]
        </p>
    </div>
</div>