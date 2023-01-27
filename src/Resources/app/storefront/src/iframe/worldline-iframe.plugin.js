import HttpClient from 'src/service/http-client.service';
import Plugin from 'src/plugin-system/plugin.class';

export default class WorldlineIframePlugin extends Plugin {
    init() {
        this._client = new HttpClient();

        this.changePaymentForm = document.getElementById("changePaymentForm");
        this.changePaymentForm.addEventListener("change", (event)=>{
            event.preventDefault();
            this._changePaymentForm();
        });

        this.moptWorldlineSalesChannel = document.getElementById("moptWorldlineSalesChannelId");
        if (this.moptWorldlineSalesChannel !== null && this.moptWorldlineSalesChannel.value !== null) {
            this._initIframe();
        }
    }

    _initIframe() {
        this.tokenizationDiv = "div-hosted-tokenization";
        this.savePaymentCardCheckbox = document.getElementById("moptWorldlineSavePaymentCard");
        this.salesChannelId = this.moptWorldlineSalesChannel.value;
        this.confirmForm = document.getElementById("confirmOrderForm");
        this._client.get(
            '/worldline_iframe?salesChannelId='+this.salesChannelId,
            this._setContent.bind(this),
            'application/json',
            true
        );

        this.confirmForm.addEventListener("submit", (event)=>{
            event.preventDefault();
            this._confirmOrderForm();
        });
    }

    _setContent(data) {
        this.tokenizer = new Tokenizer(
            JSON.parse(data).url,
            this.tokenizationDiv,
            {hideCardholderName: false,
            hideTokenFields: true},
            this._getCurrentToken()
        );
        this.tokenizer.initialize();
    }

    _confirmOrderForm() {
        var storeCard = this.savePaymentCardCheckbox ? this.savePaymentCardCheckbox.checked : false;
        this.tokenizer.submitTokenization({ storePermanently:storeCard }).then((result) => {
            if (result.success) {
                this._createHiddenInput(this.confirmForm, "moptWorldlineHostedTokenizationId",  result.hostedTokenizationId);
                this._createHiddenInput(this.confirmForm, "moptWorldlineBrowserDataColorDepth", screen.colorDepth);
                this._createHiddenInput(this.confirmForm, "moptWorldlineBrowserDataScreenHeight", screen.height);
                this._createHiddenInput(this.confirmForm, "moptWorldlineBrowserDataScreenWidth", screen.width);
                this._createHiddenInput(this.confirmForm, "moptWorldlineBrowserDataJavaEnabled", navigator.javaEnabled());
                this._createHiddenInput(this.confirmForm, "moptWorldlineLocale", navigator.language);
                this._createHiddenInput(this.confirmForm, "moptWorldlineUserAgent", navigator.userAgent);
                this._createHiddenInput(this.confirmForm, "moptWorldlineTimezoneOffsetUtcMinutes", new Date().getTimezoneOffset());
                this.confirmForm.submit();
            } else {
            }
        });
    }

    _createHiddenInput(form, name, value)
     {
         var input = document.createElement("input");
         input.setAttribute("type", "hidden");
         input.setAttribute("name", name);
         input.setAttribute("value", value);
         form.appendChild(input);
     }

    //Send saved card token if exist
    _changePaymentForm() {
        this._client.get(
            '/worldline_cardToken?worldline_cardToken='+this._getCurrentToken()
        );
    }

    _getCurrentToken() {
        var elem = document.querySelector('#changePaymentForm input:checked');
        var rel =  elem ? elem.attributes['rel'] : "";
        return rel ? rel.value : "";
    }

}
