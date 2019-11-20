(function ($) {
    // noinspection JSUnusedGlobalSymbols
    mo_dhl = {
        dhl: null,
        isWunschboxAvailable: null,
        addPostnummer: function () {
            var $addInfoField = $("[name='deladr[oxaddress__oxaddinfo]']");
            $addInfoField.after($('<div></div>').addClass('help-block'));
            var addressInformation = $addInfoField.closest('div.form-group');
            var defaultLabel = addressInformation
                .find('label').first()
                .attr('id', 'oxaddinfoDefault');
            var postnummerLabel = defaultLabel.clone()
                .attr('id', 'oxaddinfoService')
                .removeClass('col-lg-3')
                .addClass('pull-right moDHLLabel ttip')
                .text('PostNummer: ' + "\u00A0\u00A0\u00A0\u00A0");
            $("<button type='button' data-toggle='modal' data-target='#moDHLInfo'></button>")
                .attr('id', 'oxaddinfoButton')
                .addClass('col-lg-3')
                .append(postnummerLabel)
                .insertAfter(defaultLabel);
        },
        showPostnummer: function (empty) {
            var postnummerInput = $("[name='deladr[oxaddress__oxaddinfo]']");
            postnummerInput
                .attr('pattern', '[0-9][0-9][0-9][0-9][0-9][0-9]+')
                .attr('data-validation-pattern-message', $("span#moPostnummerErrorMessage").text())
                .removeAttr('aria-invalid')
                .parent()
                .siblings("button").show()
                .siblings("label").hide();
            if (empty) {
                postnummerInput.val("");
            }
        },
        hidePostnummer: function (empty) {
            var postnummer = $("[name='deladr[oxaddress__oxaddinfo]']");
            postnummer
                .jqBootstrapValidation("destroy")
                .removeData()
                .removeClass("js-oxValidate js-oxValidate_notEmpty")
                .removeAttr('pattern')
                .removeAttr('data-validation-pattern-message')
                .removeAttr('required')
                .jqBootstrapValidation()
                .parent().removeClass("oxInValid")
                .siblings("button").hide()
                .siblings("label").show();
            if (empty) {
                postnummer.val("")
            }
        },
        requirePostnummer: function () {
            var postnummer = $("[name='deladr[oxaddress__oxaddinfo]']");
            postnummer
                .jqBootstrapValidation("destroy")
                .removeData()
                .addClass("js-oxValidate js-oxValidate_notEmpty")
                .attr('required', 'required')
                .jqBootstrapValidation()
                .parent().siblings("button").find("label").addClass("req");
        },
        doNotRequirePostnummer: function () {
            var postnummer = $("[name='deladr[oxaddress__oxaddinfo]']");
            postnummer
                .jqBootstrapValidation("destroy")
                .removeData()
                .removeClass('js-oxValidate js-oxValidate_notEmpty')
                .removeAttr('required')
                .jqBootstrapValidation()
                .parent().siblings("button").find("label").removeClass("req");
        },
        addServiceProviderNumber: function () {
            $("[name='deladr[oxaddress__oxstreet]']")
                .parent()
                .before($("<label class='control-label col-xs-12 col-lg-3 moDHLLabel req'></label>"));
        },
        showServiceProviderNumber: function (type, label, empty) {
            $("[name='deladr[oxaddress__oxstreet]']")
                .val(type)
                .parent().hide()
                .siblings("label:not(.moDHLLabel)").hide()
                .siblings("label.moDHLLabel").text(label).show();
            if (empty) {
                $("[name='deladr[oxaddress__oxstreetnr]']").val("");
            }
        },
        hideServiceProviderNumber: function (empty) {
            var street = $("[name='deladr[oxaddress__oxstreet]']");
            street
                .parent().show()
                .siblings("label:not(.moDHLLabel)").show()
                .siblings("label.moDHLLabel").text("").hide();
            if (empty) {
                street.val("");
                $("[name='deladr[oxaddress__oxstreetnr]']").val("");
            }
        },
        showAdditionalInformation: function () {
            ['oxcompany', 'oxfon', 'oxfax'].map(function (key) {
                var element = $("[name='deladr[oxaddress__" + key + "]']");
                element.parents('.form-group').show();
            });
        },
        hideAdditionalInformation: function () {
            ['oxcompany', 'oxfon', 'oxfax'].map(function (key) {
                var element = $("[name='deladr[oxaddress__" + key + "]']");
                if (!element.hasClass("js-oxValidate")) {
                    element.val("").parents(".form-group").hide();
                }
            });
        },
        addFixedCountry: function () {
            // Nothing to do.
        },
        fixCountryToGermany: function () {
            var germany = $("#germany-oxid").text();
            var label = $('#delCountrySelect').children('[value="' + germany + '"]').text();
            $('#dropdownCountry')
                .css("display", "none")
                .find("span.filter-option").text(label).end()
                .find("div.dropdown-menu")
                .find("span:contains('" + label + "')")
                .parents('li')
                .addClass('selected');
            $('#staticCountry').css("display", "");
            document.getElementById(germany).value = label;
            $("[name='deladr[oxaddress__oxcountryid]']").val(germany);
        },
        loosenFixedCountry: function () {
            $('#dropdownCountry').css("display", "");
            $('#staticCountry').css("display", "none");
            $("[name='deladr[oxaddress__oxcountryid]']").show().nextAll("span").hide();
        },
        addAddressChangeListener: function () {
            var self = this;
            $("#addressId").change(function () {
                switch ($(this).children(":selected").prop("id")) {
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
                if (self.isWunschboxAvailable) {
                    mo_dhl__wunschpaket.showOrHideWunschbox();
                }
            });
        },
        addNewAddressTypeSelectionListener: function () {
            $('#addressTypeSelectToMove').find('[name=oxaddressid]').parent().click(function () {
                window.setTimeout(function (timeOutId) {
                    $("#addressId").change();
                    window.clearTimeout(timeOutId);
                }, 500);
            });
        },
        addShippingAddressListener: function () {
            var self = this;
            $("#showShipAddress").change(function () {
                if ($("#showShipAddress").is(':checked')) {
                    mo_dhl.dhl.state = "regular";
                    mo_dhl.dhl.toRegularAddress();
                    if (self.isWunschboxAvailable) {
                        mo_dhl__wunschpaket.showOrHideWunschbox();
                    }
                } else {
                    $(".dd-add-delivery-address").find('label.btn').click();
                    $('[name="deladr[oxaddress__oxsal]"]').val($('[name="invadr[oxuser__oxsal]"]').val());
                    $('[name="deladr[oxaddress__oxfname]"]').val($('[name="invadr[oxuser__oxfname]"]').val());
                    $('[name="deladr[oxaddress__oxlname]"]').val($('[name="invadr[oxuser__oxlname]"]').val());
                    $("#addressId").change();
                }
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
            var availableAddresses = $(".dd-available-addresses");
            if (!availableAddresses.is(":visible")) {
                $("#showShipAddress").change();
                return;
            }

            var shippingAddressText = availableAddresses
                .find("input:checked").first()
                .parents(".panel-footer")
                .siblings()
                .text();

            if (shippingAddressText.includes("Postfiliale") || shippingAddressText.includes("Filiale")) {
                this.dhl.state = "postfiliale";
                this.dhl.toPostfiliale();
                $("select#addressId").find("option#selectFiliale").attr("selected", true);
                return;
            }
            if (shippingAddressText.includes("Paketshop")) {
                this.dhl.state = "paketshop";
                this.dhl.toPaketshop();
                $("select#addressId").find("option#selectFiliale").attr("selected", true);
                return;
            }
            if (shippingAddressText.includes("Packstation")) {
                this.dhl.state = "packstation";
                this.dhl.toPackstation();
                $("select#addressId").find("option#selectPackstation").attr("selected", true);
                return;
            }

            this.dhl.state = "regular";
            this.dhl.toRegularAddress();
        },
        rearrangeAddresses: function () {
            $("div.dd-available-addresses")
                .find("div.panel-body")
                .html(function () {
                    var buttons = $(this).find("button");
                    var prefix = buttons.length > 0 ? buttons[0].outerHTML : '';
                    buttons.remove();
                    return prefix + mo_dhl__deliveryAddress.reformatAdressString($(this).html());
                });
            $('.dd-edit-shipping-address').click(function() {
                $('#shippingAddressForm').show();
                $('html, body').animate( {
                    scrollTop: $( '#shippingAddressForm' ).offset().top - 80
                }, 600 );
            });
        },
        handleInvoiceAddresses: function() {
            var $fName = $('input[name="invadr[oxuser__oxfname]"]');
            var $lName = $('input[name="invadr[oxuser__oxlname]"]');
            var $street = $('input[name="invadr[oxuser__oxstreet]"]');
            var $city = $('input[name="invadr[oxuser__oxcity]"]');
            var $translationHelper = $('#moDHLWunschpaket');
            var translationError = $translationHelper.data('translatefailedblacklist');

            [$fName, $lName, $street, $city].map(function (value) {
                value.data('validation-callback-callback', 'mo_dhl.validatePreferredAddress');
                value.data('validation-callback-message', translationError);
                value.jqBootstrapValidation();
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
            this.addNewAddressTypeSelectionListener();
            this.addShippingAddressListener();
            this.setInitialState();
            this.handleInvoiceAddresses();

            this.rearrangeAddresses();
            this.integrateAddressDropdown();
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
            mo_dhl__wunschpaket.showOrHideWunschbox();


            $("#moDHLWunschnachbarName").focus(function () {
                $(this).parent().removeClass('has-error custom-error');
            });

            $("#moDHLWunschnachbarAddress").focus(function () {
                $(this).parent().removeClass('has-error custom-error');
            });

            $("form").submit(function (event) {
                var wunschName = $("#moDHLWunschnachbarName");
                var wunschAddress = $("#moDHLWunschnachbarAddress");
                var wunschortCheckbox = $('#moDHLWunschortCheckbox');
                var wunschnachbarCheckbox = $('#moDHLWunschnachbarCheckbox');
                var wunschort = $('#moDHLWunschort');

                /*
                set null objects if elements did not exist
                 */
                var $nullObject = $("<div></div>");
                wunschName = wunschName.length ? wunschName : $nullObject;
                wunschAddress = wunschAddress.length ? wunschAddress : $nullObject;
                wunschortCheckbox = wunschortCheckbox.length ? wunschortCheckbox : $nullObject;
                wunschnachbarCheckbox = wunschnachbarCheckbox.length ? wunschnachbarCheckbox : $nullObject;
                wunschort = wunschort.length ? wunschort : $nullObject;

                wunschAddress.parent().removeClass('has-error custom-error');
                wunschName.parent().removeClass('has-error custom-error');
                if (wunschName.val().length > 0 && wunschAddress.val().length === 0) {
                    event.preventDefault();
                    wunschAddress.parent().addClass('has-error custom-error');
                }

                if (wunschAddress.val().length > 0 && wunschName.val().length === 0) {
                    event.preventDefault();
                    wunschName.parent().addClass('has-error custom-error');
                }

                if (wunschortCheckbox.prop('checked') && wunschort.val().length === 0) {
                    event.preventDefault();
                    wunschort.parent().addClass('has-error custom-error');
                }

                if (wunschnachbarCheckbox.prop('checked')) {
                    if (wunschName.val().length === 0) {
                        event.preventDefault();
                        wunschName.parent().addClass('has-error custom-error');
                    }
                    if (wunschAddress.val().length === 0) {
                        event.preventDefault();
                        wunschAddress.parent().addClass('has-error custom-error');
                    }
                }
            });

        },
        initializeFinder: function () {
            this.dhlfinder = new DHLFinder($, this);
            mo_dhl__finder.initialize(this);
        },
        validatePreferredAddress: function ($input, value, callback) {
            var validator = new DHLValidator();
            callback({
                value: value,
                valid: validator.validateAgainstBlacklist(value),
                message: $input.next().text()
            });
        },
        integrateAddressDropdown: function () {
            var availableAddresses = $('.dd-available-addresses');
            if (!availableAddresses.length) {
                // noinspection JSCheckFunctionSignatures
                $('#addressTypeSelectToMove')
                    .insertBefore($('#shippingAddressForm'))
                    .removeClass('col-md-4')
                    .addClass('col-md-3 col-lg-offset-3')
                    .after($("<div class='clearfix'></div>"));
            } else {
                $('#addressTypeSelectToMove').insertAfter(availableAddresses.find('.col-xs-12').last());
            }
        },
        getProviderId: function (provider) {
            return provider.number;
        },
        apply: function (provider) {
            $('#select' + this.dhl.fromProviderTypeToLabel(provider.type)).prop('selected', true);
            $("#showShipAddress").prop('checked', false).change();
            $(".dd-add-delivery-address").find('label.btn').click();
            var providerIdentifier = this.dhl.fromProviderTypeToIdentifier(provider.type);
            $("[name='deladr[oxaddress__oxstreet]']").val(providerIdentifier).parent().removeClass('oxInValid');
            $("[name='deladr[oxaddress__oxstreetnr]']").val(this.getProviderId(provider));
            $("[name='deladr[oxaddress__oxzip]']").val(provider.address.zip).parent().removeClass('oxInValid');
            $("[name='deladr[oxaddress__oxcity]']").val(provider.address.city);
            $("[name='deladr[oxaddress__oxcountryid]']").val($("#germany-oxid").text());
        },
        setDeliveryCountryToBillingCountry: function () {
            var invCountry = $("#invCountrySelect").val();

            var label = $('#invCountrySelect').children('[value="' + invCountry + '"]').text();

            $('#delCountrySelect').val(invCountry);
            $('#dropdownCountry')
                .find("button.dropdown-toggle").attr("title", label).end()
                .find("li.selected").removeClass("selected").end()
                .find("span.filter-option").text(label).end()
                .find("div.dropdown-menu")
                .find("span:contains('" + label + "')")
                .parents('li')
                .addClass('selected');
        }
    };
})(jQuery);
