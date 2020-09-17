[{$smarty.block.parent}]

[{if ($RetoureCreateUID)}][{oxmultilang ident="MO_DHL__CREATE_RETOURE" suffix="COLON"}][{/if}]
[{if ($RetoureRequestUID)}][{oxmultilang ident="MO_DHL__RETOURE_REQUEST" suffix="COLON"}][{/if}]

[{if ($RetoureCreateUID or $RetoureRequestUID) }]
[{$oViewConf->getBaseDir()}]index.php?cl=MoDHLGuest&amp;uid=[{$RetoureCreateUID}]
[{else}]
[{oxmultilang ident="MO_DHL__YOU_CAN_CREATE_RETOURE_LABEL"}]
[{/if}]