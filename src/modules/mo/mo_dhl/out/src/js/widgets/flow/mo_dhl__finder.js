(function ($) {
    // noinspection JSUnusedGlobalSymbols
    mo_dhl__finder = {
        addFinderButton: function () {
            var self = this;
            var finderButton = $('#moDHLButton');
            finderButton.parent().show();
            finderButton
                .parents(':nth-child(4)')
                .css('margin-left', '0')
                .css('margin-right', '0');
            finderButton
                .click(function () {
                    self.tailorer.dhlfinder.initializePopup();
                    self.tailorer.dhlfinder.preFillInputs();
                });
            $("#showShipAddress")
                .parent()
                .after(finderButton.parent());
            $('#moDHLFinder')
                .on('shown.bs.modal', function () {
                    self.tailorer.dhlfinder.resizeMap();
                })
                .on('hidden.bs.modal', function () {
                    self.closeInfoBoxes();
                });
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
            document.querySelector('.moDhlCloseOverlays').addEventListener('click', () => self.closeInfoBoxes());
        },
        openInfoBoxes: [],
        activeMarker: [],
        showAdditionalInformation: function(providerId, address) {
            var self = this;
            document.querySelectorAll('.moDhlMapOverlays').forEach(overlay => {
                overlay.classList.remove('hidden');
            });
            document.querySelector('.moDhlMapSelectProvider').id = providerId;
            document.querySelector('.moDhlAddressText span').innerText = address;
            self.activeMarker.forEach(mark => {
                var icon = mark.getIcon();
                mark.setIcon(icon.replace('icon-', 'marked_icon-'));
            });
        },
        hideAdditionalInformation: function() {
            document.querySelectorAll('.moDhlMapOverlays').forEach(overlay => {
                overlay.classList.add('hidden');
            });
            document.querySelector('.moDhlMapSelectProvider').removeAttribute('id');
        },
        closeInfoBoxes: function () {
            var self = this;
            self.openInfoBoxes.forEach(function (box) {
                box.close();
            });
            self.hideAdditionalInformation();
            self.activeMarker.forEach(mark => {
                var icon = mark.getIcon();
                mark.setIcon(icon.replace('marked_icon-', 'icon-'));
            });
            self.openInfoBoxes = [];
            self.activeMarker = [];
        },
        addInfoBox: function (provider, marker) {
            var self = this;
            var providerId = "provider_" + provider.id;
            var address = marker.title + ", " + provider.address.street + " " + provider.address.streetNo + ", "
                + provider.address.zip + " "
                + provider.address.city + (provider.address.district !== null ? "-" + provider.address.district : '')
                + (provider.remark.length ? "<br/><br/>" + provider.remark : '');
            var dhlWindow = $("#moDHLWindow");
            var window = dhlWindow.clone().removeAttr('id');

            if (provider.type === 'Filiale' || provider.type === 'Paketshop') {
                window.find('h5').show().css('margin-bottom', '0px');
                window.find('ul').show().css('margin-top', '0px');

                window.find('ul').html('');
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
                    window.find('ul').append(newTemplate.html());
                }
            }

            var info = new google.maps.InfoWindow({
                content: window.html()
            });
            marker.addListener('click', function () {
                self.closeInfoBoxes();
                info.open(self.map, marker);
                google.maps.event.addListener(info, 'closeclick', () => {
                    self.closeInfoBoxes();
                });
                self.activeMarker = [marker];
                self.showAdditionalInformation(providerId, address);
                self.openInfoBoxes = [info];
                google.maps.event.addListener(info, 'domready', function() {
                    $('#provider_' + provider.id).click(function () {
                        mo_dhl.apply(provider);
                        self.closeInfoBoxes();
                        $('#moDHLFinder').modal('hide');
                    });
                });
            });
        }
    };
    var busyFinder;
})(jQuery);
