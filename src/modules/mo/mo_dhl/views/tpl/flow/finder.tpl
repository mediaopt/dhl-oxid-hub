<div style="display: none;">

    <p>
        <button id="moDHLButton" type="button" class="btn btn-info" data-toggle="modal"
                data-target="#moDHLFinder">
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

    <img class="mo-thumbnail" id="thumbnail-packstation"
         src="[{$oViewConf->getModuleUrl("mo_dhl", "out/src/img/icon-packstation.png")}]"/>
    <img class="mo-thumbnail" id="thumbnail-postfiliale"
         src="[{$oViewConf->getModuleUrl("mo_dhl", "out/src/img/icon-postfiliale.png")}]"/>
    <img class="mo-thumbnail" id="thumbnail-paketshop"
         src="[{$oViewConf->getModuleUrl("mo_dhl", "out/src/img/icon-paketshop.png")}]"/>

    <span id="packstation-number-label">Packstationsnr.:</span>
    <span id="postfiliale-number-label">Filialnr.:</span>
    <span id="paketshop-number-label">Filialnr.:</span>

    <a id="moDHLFind"
       href="[{$oViewConf->getSslSelfLink()}]cl=MoDHLFinder"></a>

    <span id="moPostnummerErrorMessage">[{oxmultilang ident="MO_DHL__ERROR_POSTNUMMER_MALFORMED"}]</span>

    <div id="moDHLWindow">
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
    </div>

    <p id="moDHLUnknownError">[{oxmultilang ident="MO_DHL__ERROR_FINDER_UNKNOWN"}]</p>
</div>

<div id="moDHLFinder" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" id="modalMap" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <form id="moDHLFinderForm">
                    <input type="text" placeholder="[{oxmultilang ident="MO_DHL__STREET"}]"
                           id="moDHLStreet" class="form-control" name="street"/>
                    <input type="text" placeholder="[{oxmultilang ident="MO_DHL__POSTCODE"}]"
                           id="moDHLLocality" class="form-control" name="locality"/>
                    [{assign var="countries_list" value=$oViewConf->moGetDHLCountriesList()}]
                    <select id="moDHLCountry" name="country"
                            [{if count($countries_list) === 1}]style="display: none;"[{/if}]
                    >
                        <option value="">-</option>
                        [{foreach from=$countries_list item=country key=country_id}]
                            <option value="[{$country_id}]" isoalpha2="[{$country.isoalpha2}]">
                                [{$country.title}]
                            </option>
                        [{/foreach}]
                    </select>
                    <button class="btn btn-primary submitButton">[{oxmultilang ident="MO_DHL__SEARCH"}]</button>
                </form>
            </div>

            <div class="modal-body">
                <div id="moDHLErrors" class="status error corners" style="display:none;"></div>
                <div id="moDhlAddressOnMap" class="hidden moDhlMapOverlays">
                    <div class="moDhlAddressText">
                        <span></span>
                        <button type="button" class="moDhlCloseOverlays">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div id="moDhlApplyOnMap" class="hidden moDhlMapOverlays">
                    <button class="btn btn-primary submitButton moDhlMapSelectProvider" data-dismiss="modal">
                        [{oxmultilang ident="MO_DHL__SELECT"}]
                    </button>
                </div>
                <div id="moDHLMap"></div>
            </div>
        </div>
    </div>
</div>

<div id="moDHLInfo" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4>[{oxmultilang ident="MO_DHL__POSTNUMMER_INFO_TITLE"}]</h4>
            </div>

            <div class="modal-body text-center">
                <img class="info--figure"
                     src="[{$oViewConf->getModuleUrl('mo_dhl', 'out/src/img/dhl-postnumber-info.jpg')}]">
            </div>

            <div class="modal-footer">
                <div class="text-center"><p>[{oxmultilang ident="MO_DHL__POSTNUMMER_INFO_TEXT"}]</p>
                </div>
            </div>
        </div>
    </div>
</div>
