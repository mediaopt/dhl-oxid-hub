EmpfaengerservicesFinder = function ($, tailorer) {
    this.tailorer = tailorer;

    this.addressObject = function (locality, street) {
        this.locality = locality !== undefined ? locality : null;
        this.street = street !== undefined ? street : null;

        this.isEmpty = function () {
            var self = this;
            return (self.locality && self.street) === null
        }
    };

    this.resizeMap = function () {
        var self = this;
        google.maps.event.trigger(self.map, 'resize');
        self.map.setCenter({
            lat: 51.16591, lng: 10.451526
        });
    };

    this.findByLatLng = function () {
        var self = this;
        if (self.tailorer.busyFinder) {
            return
        }
        var geocoder = new google.maps.Geocoder;
        geocoder.geocode({'location': self.map.getCenter()}, function (results, status) {
            if (status !== 'OK') {
                return
            }
            if (results[0]) {
                var addressObject = new self.addressObject();
                var street = '';
                results[0].address_components.forEach(function (element) {
                    element.types.forEach(function (elementType) {
                        if (elementType === 'postal_code') {
                            addressObject.zip = element.long_name;
                        } else if (elementType === 'locality') {
                            addressObject.city = element.long_name;
                        } else if (elementType === 'street_number') {
                            street = street + ' ' + element.long_name;
                        } else if (elementType === 'route') {
                            street = element.long_name + street;
                        }
                    });
                });
                addressObject.street = street;
                self.find(addressObject, false);
            }
        });
    };

    this.initializePopup = function () {
        var self = this;
        var mapDiv = document.getElementById('moEmpfaengerservicesMap');
        var mapZoomThreshold = 14;
        self.map = new google.maps.Map(mapDiv, {
            center: {lat: 51.16591, lng: 10.451526},
            zoom: 6,
            noClear: false
        });
        self.mapcenter = self.map.getCenter();
        self.map.addListener('dragend', function () {
            if (self.map.getZoom() <= mapZoomThreshold) {
                return;
            }
            var bounds = self.map.getBounds();
            var length = google.maps.geometry.spherical.computeDistanceBetween(bounds.getNorthEast(), bounds.getCenter());
            length = length / 2.0;
            if (google.maps.geometry.spherical.computeDistanceBetween(self.mapcenter, self.map.getCenter()) > length) {
                self.mapcenter = self.map.getCenter();
                self.findByLatLng();
            }
        });
    };

    this.preFillInputs = function () {
        var self = this;
        var locality = ($("[name='deladr[oxaddress__oxzip]']").val() + ' ' + $("[name='deladr[oxaddress__oxcity]']").val()).trim();
        var street = ($("[name='deladr[oxaddress__oxstreet]']").val() + " " + $("[name='deladr[oxaddress__oxstreetnr]']").val()).trim();
        if ($("#showShipAddress").is(':checked') || !street && !locality) {
            locality = ($("[name='invadr[oxuser__oxzip]']").val() + ' ' + $("[name='invadr[oxuser__oxcity]']").val()).trim();
            street = ($("[name='invadr[oxuser__oxstreet]']").val() + " " + $("[name='invadr[oxuser__oxstreetnr]']").val()).trim();
        }
        if (street.includes("Postfiliale") || street.includes("Packstation")) {
            street = "";
        }

        $("#moEmpfaengerservicesLocality").val(locality);
        $("#moEmpfaengerservicesStreet").val(street);
        if (street && locality) {
            var address = new self.tailorer.empfaengerservicesfinder.addressObject(locality, street);
            self.tailorer.empfaengerservicesfinder.find(address, true);
        }
    };

    this.clearMarkers = function (markers) {
        markers.forEach(function (marker) {
            marker.setMap(null);
        });
    };
    this.markers = [];
    this.find = function (addressObject, recenterMapParameter) {
        var recenterMap = recenterMapParameter !== undefined ? recenterMapParameter : true;
        var self = this;
        var locality, street;
        if (addressObject.isEmpty()) {
            return;
        }
        locality = addressObject.locality;
        street = addressObject.street;

        var packstationInput = $("#moEmpfaengerservicesPackstation");
        var packstation = packstationInput.length !== 0 && packstationInput.attr('type') === 'hidden'
            || packstationInput.prop('checked');
        var filialeInput = $("#moEmpfaengerservicesFiliale");
        var filiale = filialeInput.length !== 0 && filialeInput.attr('type') === 'hidden'
            || filialeInput.prop('checked');

        if (self.tailorer.busyFinder) {
            return;
        }

        self.tailorer.busyFinder = true;
        $.ajax(self.tailorer.empfaengerservices.findCall(locality, street, packstation, filiale)).done(function (response) {
            if (response.status === 'success') {
                $("#moEmpfaengerservicesErrors").hide();
                self.clearMarkers(self.markers);

                var providers = response.payload;
                var bounds = new google.maps.LatLngBounds();
                self.markers = providers.map(function (provider) {
                    var marker = self.mark(provider);
                    bounds.extend(marker.getPosition());
                    return marker;
                });
                if (recenterMap) {
                    self.map.fitBounds(bounds);
                }
            } else if (response.status === 'error') {
                $("#moEmpfaengerservicesErrors").show().text(response.payload);
            }
            self.tailorer.busyFinder = false;
        }).fail(function () {
            $("#moEmpfaengerservicesErrors").show().text($("#moEmpfaengerservicesUnknownError").text());
            self.tailorer.busyFinder = false;
        });
    };
    this.mark = function (provider) {
        var title = this.tailorer.empfaengerservices.fromProviderTypeToLabel(provider.type) + ' ' + this.tailorer.getProviderId(provider);
        var icon = this.tailorer.empfaengerservices.thumbs.postfiliale;
        if (provider.type === 'Packstation') {
            icon = this.tailorer.empfaengerservices.thumbs.packstation;
        } else if (provider.type === 'Paketshop') {
            icon = this.tailorer.empfaengerservices.thumbs.paketshop;
        }
        var marker = new google.maps.Marker({
            position: {lat: provider.location.latitude, lng: provider.location.longitude},
            map: this.map,
            title: title,
            icon: icon
        });
        mo_empfaengerservices__finder.addInfoBox(provider, marker);
        return marker;
    };
};
