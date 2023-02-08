[{if $delivadr}]
    [{if $selected}]
        <div class="moDhlAddressCardChangeName">
            <span class="moDhlAddressSpanFName">
                <input type="text" class="js-oxValidate js-oxValidate_notEmpty form-control" maxlength="255" required name="moDhlAddressChangeFName" placeholder="Vorname">
            </span>
            <span class="moDhlAddressSpanLName">
                <input type="text" class="js-oxValidate js-oxValidate_notEmpty form-control" maxlength="255" required name="moDhlAddressChangeLName" placeholder="Nachname">
            </span>
        </div>
    [{/if}]
    [{if $delivadr->oxaddress__oxcompany->value}] <span class="moDhlAddressSpanCompany"><strong>[{$delivadr->oxaddress__oxcompany->value}]</strong></span>[{/if}]
    [{if $delivadr->oxaddress__oxaddinfo->value}] <span class="moDhlAddressSpanAddInfo">[{$delivadr->oxaddress__oxaddinfo->value}]</span>[{/if}]
    [{if $delivadr->oxaddress__oxfname->value || $delivadr->oxaddress__oxlname->value}]<span class="moDhlAddressSpanName">[{if $delivadr->oxaddress__oxsal->value }][{$delivadr->oxaddress__oxsal->value|oxmultilangsal}]&nbsp;[{/if}][{$delivadr->oxaddress__oxfname->value}]&nbsp;[{$delivadr->oxaddress__oxlname->value}]</span>[{/if}]
    [{if $delivadr->oxaddress__oxstreet->value || $delivadr->oxaddress__oxstreetnr->value}]
        <span data-streetname="[{$delivadr->oxaddress__oxstreet->value}]" data-streetnr="[{$delivadr->oxaddress__oxstreetnr->value}]"
              class="moDhlAddressSpanStreet">
            [{$delivadr->oxaddress__oxstreet->value}]&nbsp;[{$delivadr->oxaddress__oxstreetnr->value}]
        </span>
    [{/if}]
    [{if $delivadr->oxaddress__oxstateid->value}]<span class="moDhlAddressSpanState">[{$delivadr->oxaddress__oxstateid->value}]</span>[{/if}]
    [{if $delivadr->oxaddress__oxzip->value || $delivadr->oxaddress__oxcity->value}]
        <span data-zip="[{$delivadr->oxaddress__oxzip->value}]" data-city="[{$delivadr->oxaddress__oxcity->value}]"
              class="moDhlAddressSpanZipCity">
            [{$delivadr->oxaddress__oxzip->value}]&nbsp;[{$delivadr->oxaddress__oxcity->value}]
        </span>
    [{/if}]
    [{if $delivadr->oxaddress__oxcountry->value}]<span class="moDhlAddressSpanCountry">[{$delivadr->oxaddress__oxcountry->value}]</span>[{/if}]
    [{if $delivadr->oxaddress__oxfon->value}]<span class="moDhlAddressSpanPhone"><strong>[{oxmultilang ident="PHONE"}]</strong> [{$delivadr->oxaddress__oxfon->value}]</span>[{/if}]
    [{if $delivadr->oxaddress__oxfax->value}]<span class="moDhlAddressSpanFax"><strong>[{oxmultilang ident="FAX"}]</strong> [{$delivadr->oxaddress__oxfax->value}]</span>[{/if}]
[{/if}]
