[{$smarty.block.parent}]

[{if $RetoureCreateUID}]
[{oxmultilang ident="MO_DHL__CREATE_RETOURE" suffix="COLON"}] [{$oViewConf->getBaseDir()}]index.php?cl=MoDHLGuest&amp;uid=[{$RetoureCreateUID}]
[{elseif $RetoureRequestUID}]
[{oxmultilang ident="MO_DHL__RETOURE_REQUEST" suffix="COLON"}] [{$oViewConf->getBaseDir()}]index.php?cl=MoDHLGuest&amp;uid=[{$RetoureRequestUID}]
[{elseif $CreationAllowance }]
[{oxmultilang ident="MO_DHL__YOU_CAN_CREATE_RETOURE_LABEL"}]
[{/if}]