<div style="display: none;">

    <span class="js-oxError_postnummer">[{oxmultilang ident="MO_DHL__INVALID_POSTNUMBER"}]</span>

    <p>
        <button id="moDHLButton" type="button" class="submitButton">
            [{if $oViewConf->moCanPackstationBeSelected()}]
                [{if $oViewConf->moCanFilialeBeSelected()}]
                    [{oxmultilang ident="MO_DHL__OPEN_MODAL_SERVICE_PROVIDER"}]
                [{else}]
                    [{oxmultilang ident="MO_DHL__OPEN_MODAL_PACKSTATION"}]
                [{/if}]
            [{else}]
                [{oxmultilang ident="MO_DHL__OPEN_MODAL_FILIALE"}]
            [{/if}]
        </button>
    </p>

    <img id="thumbnail-packstation"
         src="[{$oViewConf->getModuleUrl("mo_dhl", "out/src/img/icon-packstation.png")}]"/>
    <img id="thumbnail-postfiliale"
         src="[{$oViewConf->getModuleUrl("mo_dhl", "out/src/img/icon-postfiliale.png")}]"/>
    <img id="thumbnail-paketshop"
         src="[{$oViewConf->getModuleUrl("mo_dhl", "out/src/img/icon-paketshop.png")}]"/>

    <span id="packstation-number-label">Packstationsnr.:</span>
    <span id="postfiliale-number-label">Filialnr.:</span>
    <span id="paketshop-number-label">Filialnr.:</span>

    <a id="moDHLFind"
       href="[{$oViewConf->getSslSelfLink()}]cl=MoDHLFinder"></a>

    <div id="moDHLWindow">
        <h4></h4>
        <address></address>

        <div class="icons">
            <img class="icon packstation"
                 src="[{$oViewConf->getModuleUrl("mo_dhl", "out/src/img/icon-packstation-red.png")}]"/>
            <img class="icon filiale"
                 src="[{$oViewConf->getModuleUrl("mo_dhl", "out/src/img/icon-postfiliale-red.png")}]"/>
            <img class="icon paketshop"
                 src="[{$oViewConf->getModuleUrl("mo_dhl", "out/src/img/icon-paketshop-red.png")}]"/>
            <img class="icon wheelchair"
                 src="[{$oViewConf->getModuleUrl("mo_dhl", "out/src/img/icon-wheelchair.png")}]"/>
            <img class="icon parking"
                 src="[{$oViewConf->getModuleUrl("mo_dhl", "out/src/img/icon-parking.png")}]"/>
        </div>

        <h5 class="moDHLOpeningHours"
            style="display: none;">[{oxmultilang ident="MO_DHL__OPENING_HOURS"}]</h5>
        <ul class="moDHLOpeningHours" style="display: none;">
            <li>[{oxmultilang ident="MO_DHL__OPENING_HOURS_1"}]: <span
                        class="opening-hours-day-1">[{oxmultilang ident="MO_DHL__OPENING_HOURS_CLOSED"}]</span>
            </li>
            <li>[{oxmultilang ident="MO_DHL__OPENING_HOURS_2"}]: <span
                        class="opening-hours-day-2">[{oxmultilang ident="MO_DHL__OPENING_HOURS_CLOSED"}]</span>
            </li>
            <li>[{oxmultilang ident="MO_DHL__OPENING_HOURS_3"}]: <span
                        class="opening-hours-day-3">[{oxmultilang ident="MO_DHL__OPENING_HOURS_CLOSED"}]</span>
            </li>
            <li>[{oxmultilang ident="MO_DHL__OPENING_HOURS_4"}]: <span
                        class="opening-hours-day-4">[{oxmultilang ident="MO_DHL__OPENING_HOURS_CLOSED"}]</span>
            </li>
            <li>[{oxmultilang ident="MO_DHL__OPENING_HOURS_5"}]: <span
                        class="opening-hours-day-5">[{oxmultilang ident="MO_DHL__OPENING_HOURS_CLOSED"}]</span>
            </li>
            <li>[{oxmultilang ident="MO_DHL__OPENING_HOURS_6"}]: <span
                        class="opening-hours-day-6">[{oxmultilang ident="MO_DHL__OPENING_HOURS_CLOSED"}]</span>
            </li>
            <li>[{oxmultilang ident="MO_DHL__OPENING_HOURS_7"}]: <span
                        class="opening-hours-day-7">[{oxmultilang ident="MO_DHL__OPENING_HOURS_CLOSED"}]</span>
            </li>
        </ul>

        <button class="submitButton"
                id="provider_' + provider.id + '">[{oxmultilang ident="MO_DHL__SELECT"}]</button>

    </div>

    <p id="moDHLUnknownError">[{oxmultilang ident="MO_DHL__ERROR_FINDER_UNKNOWN"}]</p>
</div>

<div id="moDHLFinder" class="popupBox corners FXgradGreyLight glowShadow">
    <img src="[{$oViewConf->getImageUrl('x.png')}]" alt="" class="closePop">
    <form id="moDHLFinderForm">
        <div id="moDHLAddressInputs">
            <input type="text" placeholder="[{oxmultilang ident="MO_DHL__STREET"}]"
                   id="moDHLStreet" class="is--azure" name="street"/>
            <input type="text" placeholder="[{oxmultilang ident="MO_DHL__POSTCODE"}] &amp; [{oxmultilang ident="MO_DHL__CITY"}]"
                   id="moDHLLocality" class="is--azure" name="locality"/>
        </div>
        <div id="moDHLProviders" class="is--azure">
        [{if $oViewConf->moCanPackstationBeSelected()}]
            [{if $oViewConf->moCanFilialeBeSelected()}]
                <input type="checkbox" id="moDHLPackstation" name="packstation" checked="checked"/>
                <label for="moDHLPackstation">Packstation
                    <img class="icon packstation valign--middle"
                         src="[{$oViewConf->getModuleUrl("mo_dhl", "out/src/img/icon-packstation.png")}]"/>
                </label>
            [{else}]
                <input type="hidden" id="moDHLPackstation" name="packstation" value="1"/>
            [{/if}]
        [{/if}]
        [{if $oViewConf->moCanFilialeBeSelected()}]
            [{if $oViewConf->moCanPackstationBeSelected()}]
                <input type="checkbox" id="moDHLFiliale" name="filiale" checked="checked"/>
                <label for="moDHLFiliale">Filiale
                    <img class="icon packstation postfiliale valign--middle"
                         src="[{$oViewConf->getModuleUrl("mo_dhl", "out/src/img/icon-postfiliale.png")}]"/>
                    <img class="icon packstation paketshop valign--middle"
                         src="[{$oViewConf->getModuleUrl("mo_dhl", "out/src/img/icon-paketshop.png")}]"/>
                </label>
            [{else}]
                <input type="hidden" id="moDHLFiliale" name="filiale" value="1"/>
            [{/if}]
        [{/if}]
        <button class="submitButton">[{oxmultilang ident="MO_DHL__SEARCH"}]</button>
        </div>
    </form>
    <div id="moDHLErrors" class="status error corners" style="display:none;"></div>
    <div id="moDHLMap">
    </div>
</div>

<div id="moDHLInfo" class="popupBox corners FXgradGreyLight glowShadow">
    <img src="[{$oViewConf->getImageUrl('x.png')}]" alt="" class="closePop">
    <h4>[{oxmultilang ident="MO_DHL__POSTNUMMER_INFO_TITLE"}]</h4>
    <div>
        <img class="info--figure"
             src="[{$oViewConf->getModuleUrl('mo_dhl', 'out/src/img/dhl-postnumber-info.jpg')}]">
        <p>
            [{oxmultilang ident="MO_DHL__POSTNUMMER_INFO_TEXT"}]
        </p>
    </div>
</div>
