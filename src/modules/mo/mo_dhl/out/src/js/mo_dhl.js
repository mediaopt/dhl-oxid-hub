Empfaengerservices = function ($, tailorer) {
    this.tailorer = tailorer;

    this.thumbs = {
        packstation: $('#thumbnail-packstation').attr('src'),
        postfiliale: $('#thumbnail-postfiliale').attr('src'),
        paketshop: $('#thumbnail-paketshop').attr('src')
    };

    this.serviceProviderNumberLabel = {
        packstation: $('#packstation-number-label').text(),
        postfiliale: $('#postfiliale-number-label').text(),
        paketshop: $('#paketshop-number-label').text()
    };

    this.state = "regular";

    this.openModal = function () {
        $('#moDHLFinder').modal();
        this.tailorer.dhlfinder.initializePopup();
        this.tailorer.dhlfinder.preFillInputs();
    };

    this.toRegularAddress = function () {
        var empty = this.state !== 'regular';
        if (tailorer.isWunschboxAvailable) {
            mo_dhl__wunschpaket.showWunschoptions();
        }
        this.tailorer.showAdditionalInformation();
        this.tailorer.hidePostnummer(empty);
        this.tailorer.hideServiceProviderNumber(empty);
        this.tailorer.loosenFixedCountry();
        this.tailorer.setDeliveryCountryToBillingCountry();
        this.state = "regular";
    };

    this.toPackstation = function () {
        var empty = this.state !== 'packstation';
        if (tailorer.isWunschboxAvailable) {
            mo_dhl__wunschpaket.hideWunschoptions();
        }
        this.tailorer.hideAdditionalInformation();
        this.tailorer.showPostnummer(empty);
        this.tailorer.requirePostnummer();
        this.tailorer.showServiceProviderNumber("Packstation", this.serviceProviderNumberLabel.packstation, empty);
        this.tailorer.fixCountryToGermany();
        this.state = "packstation";
    };

    this.toPostfiliale = function () {
        var empty = this.state !== 'postfiliale';
        if (tailorer.isWunschboxAvailable) {
            mo_dhl__wunschpaket.hideWunschoptions();
        }
        this.tailorer.hideAdditionalInformation();
        this.tailorer.showPostnummer(empty);
        this.tailorer.doNotRequirePostnummer();
        this.tailorer.showServiceProviderNumber("Postfiliale", this.serviceProviderNumberLabel.postfiliale, empty);
        this.tailorer.fixCountryToGermany();
        this.state = "postfiliale";
    };

    this.toPaketshop = function () {
        var empty = this.state !== 'paketshop';
        if (tailorer.isWunschboxAvailable) {
            mo_dhl__wunschpaket.hideWunschoptions();
        }
        this.tailorer.hideAdditionalInformation();
        this.tailorer.showPostnummer(empty);
        this.tailorer.doNotRequirePostnummer();
        this.tailorer.showServiceProviderNumber("Postfiliale", this.serviceProviderNumberLabel.paketshop, empty);
        this.tailorer.fixCountryToGermany();
        this.state = "paketshop";
    };

    this.validatePostnummer = function (postnummer) {
        if (this.state === 'regular') {
            return true;
        }
        if (this.state !== 'packstation' && postnummer.length === 0) {
            return true;
        }
        return postnummer.length >= 6 && postnummer.match(/^\d+$/);
    };

    this.findCall = function (locality, street, packstation, filiale) {
        var url = $('#moDHLFind').attr('href') + "&locality=" + locality + "&street=" + street;
        if (packstation) {
            url += "&packstation=1";
        }
        if (filiale) {
            url += "&filiale=1&paketshop=1";
        }
        return url;
    };

    this.fromProviderTypeToIdentifier = function (type) {
        return type !== 'Packstation' ? 'Postfiliale' : type;
    };

    this.fromProviderTypeToLabel = function (type) {
        return type !== 'Packstation' ? 'Filiale' : type;
    };

    this.getState = function () {
        return this.tailorer.isShippedToSeparateAddress() ? this.state : 'regular';
    };
};
