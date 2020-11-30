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
        <ul class="moDHLOpeningHours" style="display: none;"></ul>
        <div id = "mo_day_translations" style="display: none;"
             data-day1="[{oxmultilang ident="MO_DHL__OPENING_HOURS_1"}]"
             data-day2="[{oxmultilang ident="MO_DHL__OPENING_HOURS_2"}]"
             data-day3="[{oxmultilang ident="MO_DHL__OPENING_HOURS_3"}]"
             data-day4="[{oxmultilang ident="MO_DHL__OPENING_HOURS_4"}]"
             data-day5="[{oxmultilang ident="MO_DHL__OPENING_HOURS_5"}]"
             data-day6="[{oxmultilang ident="MO_DHL__OPENING_HOURS_6"}]"
             data-day7="[{oxmultilang ident="MO_DHL__OPENING_HOURS_7"}]"
        ></div>
        <div id = "mo_grouped_timetable_template" style="display: none;">
            <li>
                <span class="dayname"></span>
                <span class="opening-hours-day-grouped">[{oxmultilang ident="MO_DHL__OPENING_HOURS_CLOSED"}]</span>
            </li>
        </div>

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
            <input type="text" placeholder="[{oxmultilang ident="MO_DHL__POSTCODE"}]"
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
