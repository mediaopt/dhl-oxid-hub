(function ($) {

    mo_empfaengerservices = {
        empfaengerservices: null,
        isWunschpaketAvailable: null,
        addPostnummer: function () {
            var modal = {
                target: '#moEmpfaengerservicesInfo',
                width: 293,
                height: 300,
                resizable: false,
                draggable: false
            };
            var postnummerLabel = $('<label></label>')
                .addClass('moEmpfaengerservicesLabel tooltip')
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
                .filter('.moEmpfaengerservicesLabel').show();
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
                .filter('.moEmpfaengerservicesLabel').hide();
            if (empty) {
                postnummer.val("")
            }
        },
        requirePostnummer: function () {
            var postnummer = $("[name='deladr[oxaddress__oxaddinfo]']");
            postnummer
                .addClass("js-oxValidate_notEmpty")
                .siblings('label.moEmpfaengerservicesLabel')
                .addClass('req');
        },
        doNotRequirePostnummer: function () {
            var postnummer = $("[name='deladr[oxaddress__oxaddinfo]']");
            postnummer
                .removeClass("js-oxValidate_notEmpty")
                .siblings('label.moEmpfaengerservicesLabel')
                .removeClass('req')
        },
        addServiceProviderNumber: function () {
            var street = $("[name='deladr[oxaddress__oxstreet]']");
            var label = $("<label></label>")
                .addClass('req moEmpfaengerservicesLabel');
            street
                .siblings("label")
                .after(label);
        },
        showServiceProviderNumber: function (type, label, empty) {
            $("[name='deladr[oxaddress__oxstreet]']")
                .val(type).hide()
                .parent().removeClass('oxInValid')
                .children("label").hide()
                .filter('.moEmpfaengerservicesLabel').text(label)
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
                .filter('.moEmpfaengerservicesLabel').hide();
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
                .addClass("moEmpfaengerservicesLabel")
                .text(label)
                .insertAfter("[name='deladr[oxaddress__oxcountryid]']");
        },
        fixCountryToGermany: function () {
            var germany = $("#germany-oxid").text();
            var country = $("[name='deladr[oxaddress__oxcountryid]']");
            country
                .val(germany).hide()
                .siblings('.moEmpfaengerservicesLabel').show();
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
                    self.empfaengerservices.toPackstation();
                    break;
                case "selectFiliale":
                    self.empfaengerservices.toPostfiliale();
                    break;
                case "selectPaketshop":
                    self.empfaengerservices.toPaketshop();
                    break;
                default:
                    self.empfaengerservices.toRegularAddress();
                    break;
            }
            if ($element.val() === '-1') {
                $("#shippingAddressText").hide();
                $("#shippingAddressForm").show();
            }
            if (self.isWunschboxAvailable) {
                mo_empfaengerservices__wunschpaket.showOrHideWunschbox();
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
                this.empfaengerservices.state = "postfiliale";
                this.empfaengerservices.toPostfiliale();
                return;
            }
            if (shippingAddressText.text().includes("Paketshop")) {
                this.empfaengerservices.state = "paketshop";
                this.empfaengerservices.toPaketshop();
                return;
            }
            if (shippingAddressText.text().includes("Packstation")) {
                this.empfaengerservices.state = "packstation";
                this.empfaengerservices.toPackstation();
                return;
            }

            this.empfaengerservices.state = "regular";
            this.empfaengerservices.toRegularAddress();
        },
        initialize: function (isWunschboxAvailable) {
            var self = this;
            self.isWunschboxAvailable = isWunschboxAvailable;
            self.empfaengerservices = new Empfaengerservices($, self);
            this.addPostnummer();
            this.addServiceProviderNumber();
            this.addFixedCountry();
            this.addAddressChangeListener();
            this.addShippingAddressListener();
            this.setInitialState();

            if ($("#addressId").length === 0) {
                self.empfaengerservices.toRegularAddress();
                return;
            }

            if (!self.isWunschboxAvailable) {
                return;
            }
            $('#delCountrySelect').on('change', function () {
                mo_empfaengerservices__wunschpaket.showOrHideWunschbox();
            });
            $('#invCountrySelect').on('change', function () {
                mo_empfaengerservices__wunschpaket.showOrHideWunschbox();
            });

            $('#moEmpfaengerservicesWunschort').on('change textInput input', function () {
                self.validatePreferredWunschort(false);
            });
            $('#moEmpfaengerservicesWunschnachbarName').on('change textInput input', function () {
                self.validatePreferredNeighboursName(false);
                self.validatePreferredNeighboursAddress(false);
            });
            $('#moEmpfaengerservicesWunschnachbarAddress').on('change textInput input', function () {
                self.validatePreferredNeighboursAddress(false);
                self.validatePreferredNeighboursName(false);
            });

            mo_empfaengerservices__wunschpaket.showOrHideWunschbox();

        },
        initializeFinder: function () {
            this.empfaengerservicesfinder = new EmpfaengerservicesFinder($, this);
            mo_empfaengerservices__finder.initialize(this);
        },
        validatePostnummer: function () {
            var postnummerInput = $("input[name='deladr[oxaddress__oxaddinfo]']");
            if (!this.empfaengerservices.validatePostnummer(postnummerInput.val())) {
                return false;
            }
            postnummerInput.closest("li").removeClass("oxInValid");
            return true;
        },
        validatePreferredNeighboursName: function (getReturnValue) {
            var validInput = true;
            var validator = new Empfaengerservices__Validator();
            var input = $("#moEmpfaengerservicesWunschnachbarName");
            if ($("#moEmpfaengerservicesWunschnachbarAddress").val().length > 0 && input.val().length === 0) {
                validInput = false;
            }
            if (!validator.validateAgainstBlacklist(input.val())) {
                validInput = false;
            }
            if (input.val().length === 0 && $('#moEmpfaengerservicesWunschnachbarCheckbox').prop('checked')) {
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
            var validator = new Empfaengerservices__Validator();
            var input = $("#moEmpfaengerservicesWunschnachbarAddress");
            if ($("#moEmpfaengerservicesWunschnachbarName").val().length > 0 && input.val().length === 0) {
                validInput = false;
            }
            if (!validator.validateAgainstBlacklist(input.val())) {
                validInput = false;
            }
            if (input.val().length === 0 && $('#moEmpfaengerservicesWunschnachbarCheckbox').prop('checked')) {
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
            var validator = new Empfaengerservices__Validator();
            var input = $('#moEmpfaengerservicesWunschort');
            if (!validator.validateAgainstBlacklist(input.val())) {
                validInput = false;
            }
            if (input.val().length === 0 && $('#moEmpfaengerservicesWunschortCheckbox').prop('checked')) {
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
            $('#select' + this.empfaengerservices.fromProviderTypeToLabel(provider.type)).prop('selected', true);
            $("#showShipAddress").attr('checked', false);
            var providerIdentifier = this.empfaengerservices.fromProviderTypeToIdentifier(provider.type);
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
