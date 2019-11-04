(function ($) {
    // noinspection JSUnusedGlobalSymbols
    mo_dhl__wunschpaket = {
        initializeWunschpaket: function (selectedTime, selectedDay) {
            mo_dhl__wunschpaket.fillInTimeAndDay();
            var $wunschpaket = $('#moEmpfaengerservicesWunschpaket');
            var $wunschort = $('#moEmpfaengerservicesWunschort');
            var $wunschnachbarName = $('#moEmpfaengerservicesWunschnachbarName');
            var $wunschnachbarAddress = $('#moEmpfaengerservicesWunschnachbarAddress');
            var $wunschortCheckbox = $('#moEmpfaengerservicesWunschortCheckbox');
            var $wunschnachbarCheckbox = $('#moEmpfaengerservicesWunschnachbarCheckbox');
            var $wunschtagCheckbox = $('#moEmpfaengerservicesWunschtagCheckbox');
            var $wunschzeitCheckbox = $('#moEmpfaengerservicesTimeCheckbox');

            /*
             set null objects if elements did not exist
            */
            var $nullObject = $("<div></div>");
            $wunschpaket = $wunschpaket.length ? $wunschpaket : $nullObject;
            $wunschort = $wunschort.length ? $wunschort : $nullObject;
            $wunschnachbarName = $wunschnachbarName.length ? $wunschnachbarName : $nullObject;
            $wunschnachbarAddress = $wunschnachbarAddress.length ? $wunschnachbarAddress : $nullObject;
            $wunschortCheckbox = $wunschortCheckbox.length ? $wunschortCheckbox : $nullObject;
            $wunschtagCheckbox = $wunschtagCheckbox.length ? $wunschtagCheckbox : $nullObject;
            $wunschzeitCheckbox = $wunschzeitCheckbox.length ? $wunschzeitCheckbox : $nullObject;

            var classesToRemove = 'oxInValid has-error custom-error text-warning';

            $wunschpaket.insertAfter($("#shippingAddress"));
            this.preselectWunschzeit(selectedTime);
            this.preselectWunschtag(selectedDay);
            if( $wunschort.val().length > 0 ) {
                $wunschortCheckbox.prop('checked', true);
            }
            if( Math.max($wunschnachbarName.val().length, $wunschnachbarAddress.val().length) > 0 ) {
                $wunschnachbarCheckbox.prop('checked', true);
            }
            $wunschort.change(function () {
                var disabled = $(this).val().length > 0;
                $wunschnachbarName.prop("disabled", disabled);
                $wunschnachbarAddress.prop("disabled", disabled);
                $wunschortCheckbox.prop('checked', disabled);
                if (disabled) {
                    $wunschnachbarName.val("");
                    $wunschnachbarAddress.val("");
                    $wunschnachbarCheckbox.prop('checked', !disabled);
                } else {
                    $wunschort.parent().removeClass(classesToRemove);
                }
            });
            var disableWunschort = function () {
                var disabled = Math.max($wunschnachbarName.val().length, $wunschnachbarAddress.val().length) > 0;
                $wunschort.prop("disabled", disabled);
                $wunschnachbarCheckbox.prop('checked', disabled);
                if (disabled) {
                    $wunschort.val("");
                    $wunschortCheckbox.prop('checked', !disabled);
                } else {
                    $wunschnachbarAddress.parent().removeClass(classesToRemove);
                    $wunschnachbarName.parent().removeClass(classesToRemove);
                }
            };
            $wunschnachbarName.change(disableWunschort);
            $wunschnachbarAddress.change(disableWunschort);
            $("#moEmpfaengerservicesTime").show();
            $wunschpaket.find("input[type='radio']").siblings("label").click(function () {
                if ($(this).siblings('input').is(':disabled')) {
                    return;
                }
                mo_dhl__wunschpaket.toggle($(this).siblings("input"));
            });
            $wunschortCheckbox.change(function () {
                if (!$wunschortCheckbox.prop('checked')) {
                    $wunschort.val('').trigger('change');
                } else {
                    $wunschnachbarAddress.val('');
                    $wunschnachbarName.val('').trigger('change');
                    $wunschnachbarName.parent().removeClass(classesToRemove);
                    $wunschnachbarAddress.parent().removeClass(classesToRemove);
                }
            });
            $wunschnachbarCheckbox.change(function () {
                if (!$wunschnachbarCheckbox.prop('checked')) {
                    $wunschnachbarAddress.val('');
                    $wunschnachbarName.val('').trigger('change');
                } else {
                    $wunschort.val('').trigger('change');
                    $wunschort.parent().removeClass(classesToRemove);
                }
            });
            $wunschtagCheckbox.change(function () {
                if (!$wunschtagCheckbox.prop('checked')) {
                    $('#wunschtag\\:none').prop('checked', true);
                } else {
                    $('#wunschtag\\:none').parent().next().children().eq(0).prop('checked', true);
                    $wunschtagCheckbox.prop('checked', true);
                }
            });
            $wunschzeitCheckbox.change(function () {
                if (!$wunschzeitCheckbox.prop('checked')) {
                    $('#wunschzeit\\:none').prop('checked', true);
                } else {
                    $('#wunschzeit\\:none').parent().next().children().eq(0).prop('checked', true);
                    $wunschzeitCheckbox.prop('checked', true);
                }
            });
            $('#showShipAddress').change(mo_Empfaengerservices__Helper.debounce(mo_dhl__wunschpaket.fillInTimeAndDay, 300));
            $("#addressId").change(mo_Empfaengerservices__Helper.debounce(mo_dhl__wunschpaket.fillInTimeAndDay, 300));
            $("input[name='deladr[oxaddress__oxzip]']").on('input', mo_Empfaengerservices__Helper.debounce(mo_dhl__wunschpaket.fillInTimeAndDay, 300));
            $("input[name='invadr[oxuser__oxzip]']").on('input', mo_Empfaengerservices__Helper.debounce(mo_dhl__wunschpaket.fillInTimeAndDay, 300));


            mo_dhl__wunschpaket.showOrHideWunschbox();
        },
        toggle: function (radioButton) {
            var isChecked = radioButton.is(":checked");
            $("input[name='" + radioButton.prop("name") + "']").prop("checked", false);
            radioButton.prop("checked", !isChecked);
            if (radioButton.attr('id').indexOf('none') === -1) {
                $('#' + radioButton.attr('name') + 'Checkbox').prop('checked', true);
            } else {
                $('#' + radioButton.attr('name') + 'Checkbox').prop('checked', false);
            }
        },
        preselectWunschzeit: function (selectedTime) {
            var $timeInput = $("input[name='moEmpfaengerservicesTime'][value='" + selectedTime + "']");
            if (selectedTime.length > 0 && $timeInput) {
                $timeInput.attr('checked', true);
                $('#moEmpfaengerservicesTimeCheckbox').prop('checked', true);
            } else {
                $('#wunschzeit\\:none').prop('checked', true);
            }
        },
        preselectWunschtag: function (selectedDay) {
            var $dayInput = $("input[name='moEmpfaengerservicesWunschtag'][value='" + selectedDay + "']");
            if (selectedDay.length > 0 && $dayInput) {
                $dayInput.attr('checked', true);
                $('#moEmpfaengerservicesWunschtagCheckbox').prop('checked', true);
            } else {
                $('#wunschtag\\:none').prop('checked', true);
            }
        },
        moveWunschpaketBoxes: function () {
            $(".moEmpfaengerserviceWunschpaketBox").insertAfter($("#orderAddress"));
        },
        showOrHideWunschbox: function () {
            var self = this;
            var isSelectedCountryEligible = $("#germany-oxid").text() === mo_dhl.getDestinationCountryId();
            var isSelectedAddressTypeEligible = mo_dhl.empfaengerservices.getState() === 'regular';
            if (isSelectedCountryEligible && isSelectedAddressTypeEligible) {
                self.showWunschoptions();
            } else {
                self.hideWunschoptions();
            }
        },
        showWunschoptions: function () {
            $('#moEmpfaengerservicesWunschpaket').show();
        },
        hideWunschoptions: function () {
            $('#moEmpfaengerservicesWunschort').val("");
            $('#moEmpfaengerservicesWunschnachbarName').val("");
            $('#moEmpfaengerservicesWunschnachbarAddress').val("");
            $('[name="moEmpfaengerservicesWunschtag"][checked="checked"]').attr('checked', false);
            $('[name="moEmpfaengerservicesTime"][checked="checked"]').attr('checked', false);

            $('#moEmpfaengerservicesWunschnachbarCheckbox').prop('checked', false);
            $('#moEmpfaengerservicesWunschortCheckbox').prop('checked', false);

            $('#wunschzeit\\:none').attr('checked', true).next().click();
            $('#wunschtag\\:none').attr('checked', true).next().click();
            $('#moEmpfaengerservicesWunschpaket').hide();
        },
        getCurrentZip: function () {
            if ($('#showShipAddress').prop("checked")) {
                return $("[name='invadr[oxuser__oxzip]']").val();
            }
            return $("[name='deladr[oxaddress__oxzip]']").val();
        },
        buildTimeElement: function (time, label, isNone, theme) {
            var labelClass = "wunschzeit--label" + (isNone ? " wunschzeit--none" : "") + " wunschpaket--theme-" + theme;
            var inputValue = isNone ? "" : time;
            return "<li>" +
                "<input type='radio' name='moEmpfaengerservicesTime' id='wunschzeit:" + time + "' value='" + inputValue + "' >" +
                "<label class='" + labelClass + "' for='wunschzeit:" + time + "'>" +
                (isNone ? $("#moEmpfaengerservicesWunschpaket").data("translatenowunschzeit") : label) +
                "</label>" +
                "</li>";
        },
        buildTime: function (timeObject) {
            var selectedTime = $("input[name='moEmpfaengerservicesTime']:checked").val();
            var self = this;
            var idBase = "#moEmpfaengerservices--wunschzeit-";
            var $timeList = $("#moEmpfaengerservicesWunschzeit");
            var theme = $("#moEmpfaengerservicesWunschpaket").data("theme");
            $timeList.find("li").remove();
            if (jQuery.isEmptyObject(timeObject)) {
                $(idBase + "info").addClass("moEmpfaengerservices--deactivated");
                $(idBase + "values").addClass("moEmpfaengerservices--deactivated");
                return;
            }
            $(idBase + "info").removeClass("moEmpfaengerservices--deactivated");
            $(idBase + "values").removeClass("moEmpfaengerservices--deactivated");
            $timeList.append(self.buildTimeElement("none", "", true, theme));
            $.each(timeObject, function (key, value) {
                $timeList.append(self.buildTimeElement(key, value, false, theme));
            });
            this.preselectWunschzeit(selectedTime);
        },
        buildDayElement: function (day, label, isNone, theme) {
            var labelClass = "wunschtag--label" + (isNone ? " wunschtag--none" : "") + " wunschpaket--theme-" + theme;
            var inputValue = isNone ? "" : day;
            return "<li>" +
                "<input type='radio' name='moEmpfaengerservicesWunschtag' id='wunschtag:" + day + "' value='" + inputValue + "' >" +
                "<label class='" + labelClass + "' for='wunschtag:" + day + "'>" +
                (isNone ? $("#moEmpfaengerservicesWunschpaket").data("translatenowunschtag") : label) +
                "</label>" +
                "</li>";
        },
        buildDays: function (dayObject) {
            var selectedDay = $("input[name='moEmpfaengerservicesWunschtag']:checked").val();
            var self = this;
            var idBase = "#moEmpfaengerservices--wunschtag-";
            var $dayList = $("#moEmpfaengerservicesWunschtag");
            var theme = $("#moEmpfaengerservicesWunschpaket").data("theme");
            $dayList.find("li").remove();
            if (jQuery.isEmptyObject(dayObject)) {
                $(idBase + "info").addClass("moEmpfaengerservices--deactivated");
                $(idBase + "values").addClass("moEmpfaengerservices--deactivated");
                return;
            }
            $(idBase + "info").removeClass("moEmpfaengerservices--deactivated");
            $(idBase + "values").removeClass("moEmpfaengerservices--deactivated");
            $dayList.append(self.buildDayElement("none", "", true, theme));
            $.each(dayObject, function (key, values) {
                if (values.excluded) {
                    return;
                }
                $dayList.append(self.buildDayElement(key, values.label, false, theme));
            });
            this.preselectWunschtag(selectedDay);
        },
        emptyTimeAndDay: function () {
            mo_dhl__wunschpaket.buildTime({});
            mo_dhl__wunschpaket.buildDays({});
        },
        fillInTimeAndDay: function () {
            var ajaxCall = $('#moEmpfaengerservicesWunschpaket').data('timeanddate') + mo_dhl__wunschpaket.getCurrentZip();
            if (mo_dhl__wunschpaket.getCurrentZip() === '') {
                mo_dhl__wunschpaket.emptyTimeAndDay();
                return;
            }
            $.ajax(ajaxCall).done(function (response) {
                mo_dhl__wunschpaket.buildTime(response.preferredTimes);
                mo_dhl__wunschpaket.buildDays(response.preferredDays);
                $('#moEmpfaengerservicesWunschpaket').find("input[type='radio']").siblings("label").click(function () {
                    if ($(this).siblings('input').is(':disabled')) {
                        return;
                    }
                    mo_dhl__wunschpaket.toggle($(this).siblings("input"));
                });
            }).fail(function () {
                mo_dhl__wunschpaket.emptyTimeAndDay();
            });
        }
    };
})(jQuery);
