[{if $oViewConf->isDhlFinderAvailable()}]
    [{oxscript include=$oViewConf->getModuleUrl("mo_dhl", "out/src/js/widgets/mo_dhl__finder.js") priority=9}]
    [{oxscript include="https://maps.googleapis.com/maps/api/js?libraries=geometry&key="|cat:$oViewConf->getGoogleMapsApiKey() priority=8}]
    [{oxscript add='$(function() { if ($("#shippingAddressText").length) { mo_dhl__deliveryAddress.rearrangeAddress($("#shippingAddressText")); }});'}]
    [{block name="mo_dhl_theme_switch_finder"}]
        [{if $oViewConf->moHasAncestorTheme('azure')}]
            [{oxscript include=$oViewConf->getModuleUrl("mo_dhl", "out/src/js/widgets/azure/mo_dhl__finder.js") priority=9}]
            [{include file="mo_dhl__finder_azure.tpl"}]
        [{elseif $oViewConf->moHasAncestorTheme('flow')}]
            [{oxscript include=$oViewConf->getModuleUrl("mo_dhl", "out/src/js/widgets/flow/mo_dhl__finder.js") priority=9}]
            [{include file="mo_dhl__finder_flow.tpl"}]
        [{elseif $oViewConf->moHasAncestorTheme('wave')}]
            [{oxscript include=$oViewConf->getModuleUrl("mo_dhl", "out/src/js/widgets/flow/mo_dhl__finder.js") priority=9}]
            [{include file="mo_dhl__finder_wave.tpl"}]
        [{/if}]
        [{oxscript add='$(function() {  mo_dhl.initializeFinder(); });'}]
    [{/block}]
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
[{/if}]
