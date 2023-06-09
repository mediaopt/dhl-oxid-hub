(function () {
    // noinspection JSUnusedGlobalSymbols
    mo_dhl__deliveryAddress = {
        rearrangeAddress: function (addressElement) {
            if (addressElement.length === 0) {
                return;
            }
            addressElement.html(this.reformatAdressString(addressElement.html()));
        },
        reformatAdressString: function (address) {
            var addressElements = address.split("<br>").map(function (str) {
                return str.trim();
            });
            if (addressElements.length < 3 || isNaN(parseFloat(addressElements[0]))) {
                return address;
            }
            var street = addressElements[2].toLowerCase();
            if (street.startsWith("packstation") || street.startsWith("postfiliale") || street.startsWith("paketshop")) {
                var tmp = addressElements[0];
                addressElements[0] = addressElements[1];
                addressElements[1] = tmp;
            }
            return addressElements.join("<br>");
        }
    };
})(jQuery);
