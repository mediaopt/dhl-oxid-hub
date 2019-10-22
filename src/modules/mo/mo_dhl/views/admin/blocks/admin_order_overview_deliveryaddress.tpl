<b>[{oxmultilang ident="GENERAL_DELIVERYADDRESS"}]:</b><br>
<br>
[{if $edit->oxorder__oxdelcompany->value}]Firma [{$edit->oxorder__oxdelcompany->value}]<br>[{/if}]

[{capture assign="salutation"}]
    [{$edit->oxorder__oxdelsal->value|oxmultilangsal}] [{$edit->oxorder__oxdelfname->value}] [{$edit->oxorder__oxdellname->value}]<br>
[{/capture}]
[{capture assign="additionalLine"}]
    [{if $edit->oxorder__oxdeladdinfo->value }][{$edit->oxorder__oxdeladdinfo->value }]<br>[{/if}]
[{/capture}]

[{if $edit->oxorder__oxdeladdinfo->value && $edit->mo_empfaengerservices__isDeliveredToBranch()}]
    [{$salutation}]
    [{$additionalLine}]
[{else}]
    [{$additionalLine}]
    [{$salutation}]
[{/if}]

[{$edit->oxorder__oxdelstreet->value}] [{$edit->oxorder__oxdelstreetnr->value}]<br>
[{$edit->oxorder__oxdelstateid->value}]
[{$edit->oxorder__oxdelzip->value}] [{$edit->oxorder__oxdelcity->value }]<br>
[{$edit->oxorder__oxdelcountry->value}]<br>
<br>