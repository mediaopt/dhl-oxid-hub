(function ($) {
    // noinspection JSUnusedGlobalSymbols
    mo_dhl__wunschpaket = {
        initializeWunschpaket: function (selectedTime, selectedDay) {
            mo_dhl__wunschpaket.fillInTimeAndDay();
            var $wunschpaket = $('#moDHLWunschpaket');
            var $wunschort = $('#moDHLWunschort');
            var $wunschnachbarName = $('#moDHLWunschnachbarName');
            var $wunschnachbarAddress = $('#moDHLWunschnachbarAddress');
            var $wunschortCheckbox = $('#moDHLWunschortCheckbox');
            var $wunschnachbarCheckbox = $('#moDHLWunschnachbarCheckbox');
            var $wunschtagCheckbox = $('#moDHLWunschtagCheckbox');
            var $wunschzeitCheckbox = $('#moDHLTimeCheckbox');

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
            $("#moDHLTime").show();
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
            $('#showShipAddress').change(mo_DHL__Helper.debounce(mo_dhl__wunschpaket.fillInTimeAndDay, 300));
            $("#addressId").change(mo_DHL__Helper.debounce(mo_dhl__wunschpaket.fillInTimeAndDay, 300));
            $("input[name='deladr[oxaddress__oxzip]']").on('input', mo_DHL__Helper.debounce(mo_dhl__wunschpaket.fillInTimeAndDay, 300));
            $("input[name='invadr[oxuser__oxzip]']").on('input', mo_DHL__Helper.debounce(mo_dhl__wunschpaket.fillInTimeAndDay, 300));


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
            var $timeInput = $("input[name='moDHLTime'][value='" + selectedTime + "']");
            if (selectedTime && selectedTime.length > 0 && $timeInput) {
                $timeInput.attr('checked', true);
                $('#moDHLTimeCheckbox').prop('checked', true);
            } else {
                $('#wunschzeit\\:none').prop('checked', true);
            }
        },
        preselectWunschtag: function (selectedDay) {
            var $dayInput = $("input[name='moDHLWunschtag'][value='" + selectedDay + "']");
            if (selectedDay && selectedDay.length > 0 && $dayInput) {
                $dayInput.attr('checked', true);
                $('#moDHLWunschtagCheckbox').prop('checked', true);
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
            var isSelectedAddressTypeEligible = mo_dhl.dhl.getState() === 'regular';
            if (isSelectedCountryEligible && isSelectedAddressTypeEligible) {
                self.showWunschoptions();
            } else {
                self.hideWunschoptions();
            }
        },
        showWunschoptions: function () {
            $('#moDHLWunschpaket').show();
        },
        hideWunschoptions: function () {
            $('#moDHLWunschort').val("");
            $('#moDHLWunschnachbarName').val("");
            $('#moDHLWunschnachbarAddress').val("");
            $('[name="moDHLWunschtag"][checked="checked"]').attr('checked', false);
            $('[name="moDHLTime"][checked="checked"]').attr('checked', false);

            $('#moDHLWunschnachbarCheckbox').prop('checked', false);
            $('#moDHLWunschortCheckbox').prop('checked', false);

            $('#wunschzeit\\:none').attr('checked', true).next().click();
            $('#wunschtag\\:none').attr('checked', true).next().click();
            $('#moDHLWunschpaket').hide();
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
                "<input type='radio' name='moDHLTime' id='wunschzeit:" + time + "' value='" + inputValue + "' >" +
                "<label class='" + labelClass + "' for='wunschzeit:" + time + "'>" +
                (isNone ? $("#moDHLWunschpaket").data("translatenowunschzeit") : label) +
                "</label>" +
                "</li>";
        },
        buildTime: function (timeObject) {
            var selectedTime = $("input[name='moDHLTime']:checked").val();
            var self = this;
            var idBase = "#moDHL--wunschzeit-";
            var $timeList = $("#moDHLWunschzeit");
            var theme = $("#moDHLWunschpaket").data("theme");
            $timeList.find("li").remove();
            if (jQuery.isEmptyObject(timeObject)) {
                $(idBase + "info").addClass("moDHL--deactivated");
                $(idBase + "values").addClass("moDHL--deactivated");
                return;
            }
            $(idBase + "info").removeClass("moDHL--deactivated");
            $(idBase + "values").removeClass("moDHL--deactivated");
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
                "<input type='radio' name='moDHLWunschtag' id='wunschtag:" + day + "' value='" + inputValue + "' >" +
                "<label class='" + labelClass + "' for='wunschtag:" + day + "'>" +
                (isNone ? $("#moDHLWunschpaket").data("translatenowunschtag") : label) +
                "</label>" +
                "</li>";
        },
        buildDays: function (dayObject) {
            var selectedDay = $("input[name='moDHLWunschtag']:checked").val();
            var self = this;
            var idBase = "#moDHL--wunschtag-";
            var $dayList = $("#moDHLWunschtag");
            var theme = $("#moDHLWunschpaket").data("theme");
            $dayList.find("li").remove();
            if (jQuery.isEmptyObject(dayObject)) {
                $(idBase + "info").addClass("moDHL--deactivated");
                $(idBase + "values").addClass("moDHL--deactivated");
                return;
            }
            $(idBase + "info").removeClass("moDHL--deactivated");
            $(idBase + "values").removeClass("moDHL--deactivated");
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
            var ajaxCall = $('#moDHLWunschpaket').data('timeanddate') + mo_dhl__wunschpaket.getCurrentZip();
            if (mo_dhl__wunschpaket.getCurrentZip() === '') {
                mo_dhl__wunschpaket.emptyTimeAndDay();
                return;
            }
            $.ajax(ajaxCall).done(function (response) {
                mo_dhl__wunschpaket.buildTime(response.preferredTimes);
                mo_dhl__wunschpaket.buildDays(response.preferredDays);
                $('#moDHLWunschpaket').find("input[type='radio']").siblings("label").click(function () {
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
