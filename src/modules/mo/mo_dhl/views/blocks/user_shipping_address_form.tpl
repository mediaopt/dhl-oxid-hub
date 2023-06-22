[{if $oViewConf->isDhlFinderAvailable()}]
    [{if $oViewConf->moHasAncestorTheme('flow') || $oViewConf->moHasAncestorTheme('wave')}]
        [{if $oxcmp_user}]
            [{assign var="aUserAddresses" value=$oxcmp_user->getUserAddresses()}]
            [{if $aUserAddresses|@count == 0}]
                [{capture assign="moShowNewAddressButton"}]
                    [{strip}]
                        $('#showShipAddress').on('change', function() {
                            $('.moDhlNoAddressesNewAddresses').toggleClass('show', !this.checked);
                        });
                    [{/strip}]
                [{/capture}]

                [{oxscript add=$moShowNewAddressButton}]
                <div class="moDhlNoAddressesNewAddresses[{if $oView->showShipAddress()}] show[{/if}]">
                    <div>
                        <button class="btn btn-primary moDhlNewAddressButton" type="button" id="moDhlNewAddressButton"
                                data-toggle="modal" data-target="#moDHLFinder">
                            Add new shipping address
                        </button>
                    </div>
                    <div>
                        <div class="moDhlNewAddressCard">
                            <div class="moDhlAddressCard">
                                <div class="moDhlAddressCardAddress">
                                <span class="moDhlAddressSpanFName">
                                    <input type="text" class="js-oxValidate js-oxValidate_notEmpty form-control" maxlength="255" required name="moDhlNewAddressFName" placeholder="Vorname">
                                </span>
                                    <span class="moDhlAddressSpanLName">
                                    <input type="text" class="js-oxValidate js-oxValidate_notEmpty form-control" maxlength="255" required name="moDhlNewAddressLName" placeholder="Nachname">
                                </span>
                                    <span class="moDhlAddressSpanStreetAdditional">
                                    <input type="text" class="js-oxValidate js-oxValidate_notEmpty form-control" maxlength="255" required name="moDhlNewAddressStreetAdditional" placeholder="Adresszusatz">
                                </span>
                                    <span class="moDhlAddressSpanStreet"></span>
                                    <span class="moDhlAddressSpanZipCity"></span>
                                    <span class="moDhlAddressSpanCountry"></span>
                                    <span class="moDhlAddressSpanSave text-right">
                                    <button class="btn btn-primary moDhlNewAddressSaveButton" type="button">Save</button>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            [{/if}]
        [{/if}]
    [{/if}]
[{/if}]
[{$smarty.block.parent}]