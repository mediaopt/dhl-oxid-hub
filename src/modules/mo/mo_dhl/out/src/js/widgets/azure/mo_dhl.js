(function ($) {

    mo_dhl = {
        dhl: null,
        isWunschpaketAvailable: null,
        addPostnummer: function () {
            var modal = {
                target: '#moDHLInfo',
                width: 293,
                height: 300,
                resizable: false,
                draggable: false
            };
            var postnummerLabel = $('<label></label>')
                .addClass('moDHLLabel tooltip')
                .text('PostNummer:')
                .oxModalPopup(modal);
            $("[name='deladr[oxaddress__oxaddinfo]']")
                .siblings('label')
                .after(postnummerLabel)
                .siblings().last().after($(".js-oxError_notEmpty").parent().first().clone())
                .siblings('p.oxValidateError').append($(".js-oxError_postnummer"));
        },
        showPostnummer: function (empty) {
            var postnummer = $("[name='deladr[oxaddress__oxaddinfo]']");
            postnummer
                .addClass("js-oxValidate js-oxValidate_postnummer")
                .parent()
                .removeClass("oxInValid")
                .children('label').hide()
                .filter('.moDHLLabel').show();
            if (empty) {
                postnummer.val("");
            }
        },
        hidePostnummer: function (empty) {
            var postnummer = $("[name='deladr[oxaddress__oxaddinfo]']");
            postnummer
                .removeClass("js-oxValidate js-oxValidate_notEmpty js-oxValidate_postnummer")
                .parent().removeClass("oxInValid")
                .children('label').show()
                .filter('.moDHLLabel').hide();
            if (empty) {
                postnummer.val("")
            }
        },
        requirePostnummer: function () {
            var postnummer = $("[name='deladr[oxaddress__oxaddinfo]']");
            postnummer
                .addClass("js-oxValidate_notEmpty")
                .siblings('label.moDHLLabel')
                .addClass('req');
        },
        doNotRequirePostnummer: function () {
            var postnummer = $("[name='deladr[oxaddress__oxaddinfo]']");
            postnummer
                .removeClass("js-oxValidate_notEmpty")
                .siblings('label.moDHLLabel')
                .removeClass('req')
        },
        addServiceProviderNumber: function () {
            var street = $("[name='deladr[oxaddress__oxstreet]']");
            var label = $("<label></label>")
                .addClass('req moDHLLabel');
            street
                .siblings("label")
                .after(label);
        },
        showServiceProviderNumber: function (type, label, empty) {
            $("[name='deladr[oxaddress__oxstreet]']")
                .val(type).hide()
                .parent().removeClass('oxInValid')
                .children("label").hide()
                .filter('.moDHLLabel').text(label)
                .show();
            if (empty) {
                $("[name='deladr[oxaddress__oxstreetnr]']").val("");
            }
        },
        hideServiceProviderNumber: function (empty) {
            var street = $("[name='deladr[oxaddress__oxstreet]']");
            if (street.val() === 'Packstation' || street.val() === 'Postfiliale') {
                street.val("");
            }
            street
                .show()
                .parent().children('label').show()
                .filter('.moDHLLabel').hide();
            if (empty) {
                street.val();
                $("[name='deladr[oxaddress__oxstreetnr]']").val("");
            }
        },
        showAdditionalInformation: function () {
            ['oxcompany', 'oxfon', 'oxfax'].map(function (key) {
                var element = $("[name='deladr[oxaddress__" + key + "]']");
                if (element.siblings(".req").length === 0) {
                    element.val("").parent().show();
                }
            });
        },
        hideAdditionalInformation: function () {
            ['oxcompany', 'oxfon', 'oxfax'].map(function (key) {
                var element = $("[name='deladr[oxaddress__" + key + "]']");
                if (element.siblings(".req").length === 0) {
                    element.val("").parent().hide();
                }
            });
        },
        addFixedCountry: function () {
            var germany = $("#germany-oxid").text();
            var label = $('option[value="' + germany + '"]').last().text();
            $("<span>")
                .addClass("moDHLLabel")
                .text(label)
                .insertAfter("[name='deladr[oxaddress__oxcountryid]']");
        },
        fixCountryToGermany: function () {
            var germany = $("#germany-oxid").text();
            var country = $("[name='deladr[oxaddress__oxcountryid]']");
            country
                .val(germany).hide()
                .siblings('.moDHLLabel').show();
            country.parent().removeClass('oxInValid');
        },
        loosenFixedCountry: function () {
            $("[name='deladr[oxaddress__oxcountryid]']").show().nextAll("span").hide();
        },
        /**
         * in azure the element #addressId has a jQuery plugin which would get called
         * if we use #addressId.change() in addShippingAddressListener
         * and results in infinit reloads
         */
        addressIdChangeFunction: function () {
            var self = this;
            var $element = $('#addressId');
            switch ($element.children(":selected").prop("id")) {
                case "selectPackstation":
                    self.dhl.toPackstation();
                    break;
                case "selectFiliale":
                    self.dhl.toPostfiliale();
                    break;
                case "selectPaketshop":
                    self.dhl.toPaketshop();
                    break;
                default:
                    self.dhl.toRegularAddress();
                    break;
            }
            if ($element.val() === '-1') {
                $("#shippingAddressText").hide();
                $("#shippingAddressForm").show();
            }
            if (self.isWunschboxAvailable) {
                mo_dhl__wunschpaket.showOrHideWunschbox();
            }
        },
        addAddressChangeListener: function () {
            var self = this;
            $("#addressId").change(function () {
                self.addressIdChangeFunction();
            });
        },
        addShippingAddressListener: function () {
            var self = this;
            $("#showShipAddress").change(function () {
                if (!$("#showShipAddress").prop("checked")) {
                    $('[name="deladr[oxaddress__oxsal]"]').val($('[name="invadr[oxuser__oxsal]"]').val());
                    $('[name="deladr[oxaddress__oxfname]"]').val($('[name="invadr[oxuser__oxfname]"]').val());
                    $('[name="deladr[oxaddress__oxlname]"]').val($('[name="invadr[oxuser__oxlname]"]').val());
                }
                self.addressIdChangeFunction();
            });
        },
        isShippedToSeparateAddress: function () {
            return $('#showShipAddress').is(':not(:checked)');
        },
        getCountryIdOfBillingAddress: function () {
            return $('#invCountrySelect').find(":selected").val();
        },
        getDestinationCountryId: function () {
            if (this.isShippedToSeparateAddress()) {
                return $("[name='deladr[oxaddress__oxcountryid]']").val();
            } else {
                return this.getCountryIdOfBillingAddress();
            }
        },
        setInitialState: function () {
            var shippingAddressText = $("#shippingAddressText");
            if (!shippingAddressText.is(":visible")) {
                $("#showShipAddress").change();
                return;
            }
            if (shippingAddressText.text().includes("Postfiliale") || shippingAddressText.text().includes("Filiale")) {
                this.dhl.state = "postfiliale";
                this.dhl.toPostfiliale();
                return;
            }
            if (shippingAddressText.text().includes("Paketshop")) {
                this.dhl.state = "paketshop";
                this.dhl.toPaketshop();
                return;
            }
            if (shippingAddressText.text().includes("Packstation")) {
                this.dhl.state = "packstation";
                this.dhl.toPackstation();
                return;
            }

            this.dhl.state = "regular";
            this.dhl.toRegularAddress();
        },
        handleInvoiceAddresses: function() {
            var $fName = $('input[name="invadr[oxuser__oxfname]"]');
            var $lName = $('input[name="invadr[oxuser__oxlname]"]');
            var $street = $('input[name="invadr[oxuser__oxstreet]"]');
            var $city = $('input[name="invadr[oxuser__oxcity]"]');

            var $translationHelper = $('#moDHLWunschpaket');
            var translationError = $translationHelper.data('translatefailedblacklist');

            [$fName, $lName, $street, $city].map(function (value) {
                var $element = $(value);
                $element.addClass('mo_js-oxValidate_checkBlacklist');
                $element.oxInputValidator();

                var $errorMessage = $('<span>', {
                    class: 'mo_js-oxValidate_checkBlacklist',
                    text:translationError
                });
                $element.siblings('.oxValidateError').append($errorMessage);
            });
        },
        initialize: function (isWunschboxAvailable) {
            var self = this;
            self.isWunschboxAvailable = isWunschboxAvailable;
            self.dhl = new Empfaengerservices($, self);
            this.addPostnummer();
            this.addServiceProviderNumber();
            this.addFixedCountry();
            this.addAddressChangeListener();
            this.addShippingAddressListener();
            this.setInitialState();
            this.handleInvoiceAddresses();

            if ($("#addressId").length === 0) {
                self.dhl.toRegularAddress();
                return;
            }

            if (!self.isWunschboxAvailable) {
                return;
            }
            $('#delCountrySelect').on('change', function () {
                mo_dhl__wunschpaket.showOrHideWunschbox();
            });
            $('#invCountrySelect').on('change', function () {
                mo_dhl__wunschpaket.showOrHideWunschbox();
            });

            $('#moDHLWunschort').on('change textInput input', function () {
                self.validatePreferredWunschort(false);
            });
            $('#moDHLWunschnachbarName').on('change textInput input', function () {
                self.validatePreferredNeighboursName(false);
                self.validatePreferredNeighboursAddress(false);
            });
            $('#moDHLWunschnachbarAddress').on('change textInput input', function () {
                self.validatePreferredNeighboursAddress(false);
                self.validatePreferredNeighboursName(false);
            });

            mo_dhl__wunschpaket.showOrHideWunschbox();

        },
        initializeFinder: function () {
            this.dhlfinder = new DHLFinder($, this);
            mo_dhl__finder.initialize(this);
        },
        validatePostnummer: function () {
            var postnummerInput = $("input[name='deladr[oxaddress__oxaddinfo]']");
            if (!this.dhl.validatePostnummer(postnummerInput.val())) {
                return false;
            }
            postnummerInput.closest("li").removeClass("oxInValid");
            return true;
        },
        validatePreferredNeighboursName: function (getReturnValue) {
            var validInput = true;
            var validator = new DHLValidator();
            var input = $("#moDHLWunschnachbarName");
            if ($("#moDHLWunschnachbarAddress").val().length > 0 && input.val().length === 0) {
                validInput = false;
            }
            if (!validator.validateAgainstBlacklist(input.val())) {
                validInput = false;
            }
            if (input.val().length === 0 && $('#moDHLWunschnachbarCheckbox').prop('checked')) {
                validInput = false;
            }
            if (validInput) {
                input.closest("dd").removeClass("oxInValid");
            } else {
                input.closest("dd").addClass("oxInValid");
            }
            if (getReturnValue) {
                return validInput;
            }
        },
        validatePreferredNeighboursAddress: function (getReturnValue) {
            var validInput = true;
            var validator = new DHLValidator();
            var input = $("#moDHLWunschnachbarAddress");
            if ($("#moDHLWunschnachbarName").val().length > 0 && input.val().length === 0) {
                validInput = false;
            }
            if (!validator.validateAgainstBlacklist(input.val())) {
                validInput = false;
            }
            if (input.val().length === 0 && $('#moDHLWunschnachbarCheckbox').prop('checked')) {
                validInput = false;
            }
            if (validInput) {
                input.closest("dd").removeClass("oxInValid");
            } else {
                input.closest("dd").addClass("oxInValid");
            }
            if (getReturnValue) {
                return validInput;
            }
        },
        validatePreferredWunschort: function (getReturnValue) {
            var validInput = true;
            var validator = new DHLValidator();
            var input = $('#moDHLWunschort');
            if (!validator.validateAgainstBlacklist(input.val())) {
                validInput = false;
            }
            if (input.val().length === 0 && $('#moDHLWunschortCheckbox').prop('checked')) {
                validInput = false;
            }
            if (validInput) {
                input.closest("dd").removeClass("oxInValid");
            } else {
                input.closest("dd").addClass("oxInValid");
            }
            if (getReturnValue) {
                return validInput;
            }
        },
        getProviderId: function (provider) {
            return provider.number;
        },
        apply: function (provider) {
            $('#select' + this.dhl.fromProviderTypeToLabel(provider.type)).prop('selected', true);
            $("#showShipAddress").attr('checked', false);
            var providerIdentifier = this.dhl.fromProviderTypeToIdentifier(provider.type);
            $("[name='deladr[oxaddress__oxstreet]']").val(providerIdentifier).parent().removeClass('oxInValid');
            $("[name='deladr[oxaddress__oxstreetnr]']").val(this.getProviderId(provider));
            $("[name='deladr[oxaddress__oxzip]']").val(provider.address.zip).parent().removeClass('oxInValid');
            $("[name='deladr[oxaddress__oxcity]']").val(provider.address.city);
            $("[name='deladr[oxaddress__oxcountryid]']").val($("#germany-oxid").text());
        },
        setDeliveryCountryToBillingCountry: function () {
            $('#delCountrySelect').val($("#invCountrySelect").val());
        }
    };
})(jQuery);
