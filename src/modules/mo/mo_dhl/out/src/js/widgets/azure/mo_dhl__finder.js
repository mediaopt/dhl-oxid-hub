(function ($) {

    mo_dhl__finder = {
        addFinderButton: function () {
            var self = this;
            var finderButton = $("#moEmpfaengerservicesButton");
            finderButton.parent().show();
            finderButton
                .oxModalPopup({target: '#moEmpfaengerservicesFinder'})
                .click(function () {
                    self.tailorer.empfaengerservicesfinder.initializePopup();
                    self.tailorer.empfaengerservicesfinder.preFillInputs();
                });
            $("#showShipAddress").parent().after(finderButton.parent());
        },

        initialize: function (tailorer) {
            var self = this;
            self.addFinderButton();
            self.tailorer = tailorer;
            busyFinder = false;
            $('#moEmpfaengerservicesFinderForm').submit(function () {
                self.tailorer.empfaengerservicesfinder.find(new self.tailorer.empfaengerservicesfinder.addressObject(
                    $('#moEmpfaengerservicesLocality').val(), $('#moEmpfaengerservicesStreet').val()
                ), true);
                return false;
            });
        },

        openInfoBoxes: [],
        addInfoBox: function (provider, marker) {
            var self = this;
            var providerId = "provider_" + provider.id;
            var headline = this.tailorer.empfaengerservices.fromProviderTypeToLabel(provider.type) + ' ' + mo_dhl.getProviderId(provider);
            var address = (provider.name ? provider.name + "<br/>" : '')
                + provider.address.street + " " + provider.address.streetNo + "<br/>"
                + provider.address.zip + " "
                + provider.address.city + (provider.address.district !== null ? "-" + provider.address.district : '')
                + (provider.remark.length ? "<br/><br/>" + provider.remark : '');
            var providerIcon = 'img.' + provider.type.toLowerCase();
            var informationWindow = $("#moEmpfaengerservicesWindow")
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

                for (var i = 1; i <= 7; i++) {
                    if (provider.timetable[i].length > 0) {
                        informationWindow.find('span.opening-hours-day-' + i).text(provider.timetable[i].join(", "));
                    }
                }
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
                        $("#moEmpfaengerservicesFinder").dialog("close");
                    });
                });
            });
        }
    };
    var busyFinder;
})(jQuery);
