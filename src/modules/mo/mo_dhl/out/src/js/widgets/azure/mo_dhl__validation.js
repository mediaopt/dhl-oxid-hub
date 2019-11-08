(function ($) {
//noinspection JSUnusedGlobalSymbols
    $.widget("ui.oxInputValidator", $.ui.oxInputValidator, {
        inputValidation: function (oInput, blCanSetDefaultState) {
            if ($(oInput).hasClass('js-oxValidate_postnummer') && !mo_dhl.validatePostnummer()) {
                return "js-oxError_postnummer";
            }
            if ($(oInput).hasClass('js-oxValidate_preferredWunschort') && !mo_dhl.validatePreferredWunschort(true)) {
                return "js-oxError_preferredWunschort";
            }
            if ($(oInput).hasClass('js-oxValidate_preferredNeighboursAddress') && !mo_dhl.validatePreferredNeighboursAddress(true)) {
                return "js-oxError_preferredNeighboursAddress";
            }
            if ($(oInput).hasClass('js-oxValidate_preferredNeighboursName') && !mo_dhl.validatePreferredNeighboursName(true)) {
                return "js-oxError_preferredNeighboursName";
            }
            return this._super(oInput, blCanSetDefaultState);
        },
        submitValidation: function (oForm) {
            var $wunschpaket = $('#moDHLWunschpaket');
            var $wunschort = $wunschpaket.find('.js-oxValidate_preferredWunschort');
            var $wunschnachbarAddress = $wunschpaket.find('.js-oxValidate_preferredNeighboursAddress');
            var $wunschnachbarName = $wunschpaket.find('.js-oxValidate_preferredNeighboursName');
            if ($wunschpaket.length === 0) {
                return this._super(oForm);
            }
            if ($wunschort.length !== 0) {
                if (!mo_dhl.validatePreferredWunschort(true)) {
                    $wunschort.parent().addClass('oxInValid');
                    return false;
                }
            }
            if ($wunschnachbarAddress.length !== 0) {
                if (!mo_dhl.validatePreferredNeighboursAddress(true)) {
                    $wunschnachbarAddress.parent().addClass('oxInValid');
                    return false;
                }
            }
            if ($wunschnachbarName.length !== 0) {
                if (!mo_dhl.validatePreferredNeighboursName(true)) {
                    $wunschnachbarName.parent().addClass('oxInValid');
                    return false;
                }
            }
            return this._super(oForm);
        }
    });
})(jQuery);
