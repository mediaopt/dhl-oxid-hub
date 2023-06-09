[{* Include files needed for both the finder and Wunschpaktet *}]
[{oxstyle include=$oViewConf->getModuleUrl("mo_dhl", "out/src/css/widgets/mo_dhl.css")}]
[{oxscript include=$oViewConf->getModuleUrl("mo_dhl", "out/src/js/mo_dhl.js") priority=9}]
[{oxscript include=$oViewConf->getModuleUrl("mo_dhl", "out/src/js/widgets/mo_dhl__deliveryAddress.js") priority=9}]
[{if $oViewConf->moHasAncestorTheme('azure')}]
    [{oxscript include="js/widgets/oxmodalpopup.js" priority=8}]
    [{oxscript include=$oViewConf->getModuleUrl("mo_dhl", "out/src/js/widgets/azure/mo_dhl.js") priority=9}]
    [{oxscript include=$oViewConf->getModuleUrl("mo_dhl", "out/src/js/widgets/azure/mo_dhl__validation.js") priority=10}]
[{elseif $oViewConf->moHasAncestorTheme('flow')}]
    [{oxscript include=$oViewConf->getModuleUrl("mo_dhl", "out/src/js/widgets/flow/mo_dhl.js") priority=9}]
[{elseif $oViewConf->moHasAncestorTheme('wave')}]
    [{oxscript include=$oViewConf->getModuleUrl("mo_dhl", "out/src/js/widgets/wave/mo_dhl.js") priority=9}]
[{/if}]
[{if $oView->getClassName() !== 'account_user'}]
    [{oxscript add='$(function() {  mo_dhl.initialize(true); });'}]
[{else}]
    [{oxscript add='$(function() {  mo_dhl.initialize(false); });'}]
[{/if}]
<p id="germany-oxid">[{$oViewConf->getGermanyId()}]</p>

[{* Module specific inclusions *}]
[{if $oViewConf->isDhlFinderAvailable()}]
    [{include file="mo_dhl__finder.tpl"}]
[{/if}]
[{include file="mo_dhl__wunschpaket.tpl"}]
