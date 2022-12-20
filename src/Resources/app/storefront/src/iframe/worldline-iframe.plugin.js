import HttpClient from 'src/service/http-client.service';
import Plugin from 'src/plugin-system/plugin.class';

export default class WorldlineIframePlugin extends Plugin {
    init() {
        this._client = new HttpClient();

        this.tokenizationDiv = "div-hosted-tokenization";
        this.salesChannelId = document.getElementById("moptWorldlineSalesChannelId").value;
        this.savePaymentCardCheckbox = document.getElementById("moptWorldlineSavePaymentCard");
        this.confirmForm = document.getElementById("confirmOrderForm");

        this._client.get(
            '/worldline_iframe?salesChannelId='+this.salesChannelId,
             this._setContent.bind(this),
            'application/json',
            true
        );

        document.getElementById("confirmOrderForm").addEventListener("submit", (event)=>{
            event.preventDefault();
            this._fetch();
        });
    }

    _setContent(data) {
        this.tokenizer = new Tokenizer(
            JSON.parse(data).url,
            this.tokenizationDiv,
            {hideCardholderName: false}
        );
        this.tokenizer.initialize();
    }

    _fetch() {
        var storeCard = this.savePaymentCardCheckbox.checked;
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
}
