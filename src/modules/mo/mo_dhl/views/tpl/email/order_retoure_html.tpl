[{$smarty.block.parent}]

[{if $RetoureCreateUID}]
<p>[{oxmultilang ident="MO_DHL__CREATE_RETOURE" suffix="COLON"}]
    <a href="[{$oViewConf->getBaseDir()}]index.php?cl=MoDHLGuest&amp;uid=[{$RetoureCreateUID}]"
       target="_blank" title="[{oxmultilang ident="CLICK_HERE"}]">[{oxmultilang ident="CLICK_HERE"}]</a>
</p>
<br/>
[{elseif $RetoureRequestUID}]
<p>[{oxmultilang ident="MO_DHL__RETOURE_REQUEST" suffix="COLON"}]
    <a href="[{$oViewConf->getBaseDir()}]index.php?cl=MoDHLGuest&amp;uid=[{$RetoureRequestUID}]"
       target="_blank" title="[{oxmultilang ident="CLICK_HERE"}]">[{oxmultilang ident="CLICK_HERE"}]</a>
</p>
<br/>
[{elseif $CreationAllowance }]
<p>[{oxmultilang ident="MO_DHL__YOU_CAN_CREATE_RETOURE_LABEL"}]</p>
<br/>
[{/if}]