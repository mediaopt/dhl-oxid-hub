(function ($) {

    mo_dhl__finder = {
        addFinderButton: function () {
            var self = this;
            var finderButton = $("#moDHLButton");
            finderButton.parent().show();
            finderButton
                .oxModalPopup({target: '#moDHLFinder'})
                .click(function () {
                    self.tailorer.dhlfinder.initializePopup();
                });
            $("#showShipAddress").parent().after(finderButton.parent());
        },

        initialize: function (tailorer) {
            var self = this;
            self.addFinderButton();
            self.tailorer = tailorer;
            busyFinder = false;
            $('#moDHLFinderForm').submit(function () {
                self.tailorer.dhlfinder.find(new self.tailorer.dhlfinder.addressObject(
                    $('#moDHLLocality').val(), $('#moDHLStreet').val(), $('#moDHLCountry option:selected').attr('isoalpha2')
                ), true);
                return false;
            });
        },

        openInfoBoxes: [],
        addInfoBox: function (provider, marker) {
            var self = this;
            var providerId = "provider_" + provider.id;
            var headline = provider.type + ' ' + mo_dhl.getProviderId(provider);
            var address = (provider.name ? provider.name + "<br/>" : '')
                + provider.address.street + " " + provider.address.streetNo + "<br/>"
                + provider.address.zip + " "
                + provider.address.city + (provider.address.district !== null ? "-" + provider.address.district : '')
                + (provider.remark.length ? "<br/><br/>" + provider.remark : '');
            var providerIcon = 'img.' + provider.type.toLowerCase();
            var informationWindow = $("#moDHLWindow")
                .clone().removeAttr('id')
                .find('img').hide().end()
                .find(providerIcon).show().end()
                .find('h4').text(headline).end()
                .find('address').html(address).end()
                .find('button').attr('id', providerId).end();
            provider.services.forEach(function (service) {
                if (service === 'PARKING') {
                    informationWindow.find('img.parking').show();
                    return;
                }
                if (service === 'HANDICAPPED_ACCESS') {
                    informationWindow.find('img.wheelchair').show();
                    //noinspection UnnecessaryReturnStatementJS
                    return;
                }
            });

            if (provider.type === 'Filiale' || provider.type === 'Paketshop') {
                informationWindow.find('h5').show().css('margin-bottom', '0px');
                informationWindow.find('ul').show().css('margin-top', '0px');

                informationWindow.find('ul').html('');
                var timetableTemplate = $('#mo_grouped_timetable_template');
                for(var i = 1; i<=Object.keys(provider.groupedTimetable).length; i++) {
                    var dayGroup = provider.groupedTimetable[i].dayGroup;
                    var openPeriods = provider.groupedTimetable[i].openPeriods;

                    for (var j = 1; j <= 7; j++) {
                        dayGroup = dayGroup.replace(j, $('#mo_day_translations').attr('data-day' + j));
                    }
                    var newTemplate = timetableTemplate.clone();
                    newTemplate.find('span.dayname').html(dayGroup + ': ');

                    if (openPeriods.length > 0) {
                        newTemplate.find('span.opening-hours-day-grouped').html(openPeriods);
                    }
                    informationWindow.find('ul').append(newTemplate.html());
                }
            }
            if (!self.tailorer.dhlfinder.usesGoogleMaps) {
                $('#moDHLList').append(informationWindow);
                $('#provider_' + provider.id).click(function () {
                    mo_dhl.apply(provider);
                    $("#moDHLFinder").dialog("close");
                });
                return;
            }

            var info = new google.maps.InfoWindow({
                content: informationWindow.html()
            });
            marker.addListener('click', function () {
                self.openInfoBoxes.forEach(function (box) {
                    box.close();
                });
                info.open(self.map, marker);
                self.openInfoBoxes = [info];
                google.maps.event.addListener(info, 'domready', function() {
                    $('#provider_' + provider.id).click(function () {
                        mo_dhl.apply(provider);
                        self.openInfoBoxes.forEach(function (box) {
                            box.close();
                        });
                        self.openInfoBoxes = [];
                        $("#moDHLFinder").dialog("close");
                    });
                });
            });
        }
    };
    var busyFinder;
})(jQuery);
