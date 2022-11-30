import HttpClient from 'src/service/http-client.service';
import Plugin from 'src/plugin-system/plugin.class';

export default class WorldlineIframePlugin extends Plugin {
    init() {
        this._client = new HttpClient();

        this.tokenizationDiv = "div-hosted-tokenization";
        this.salesChannelId = document.getElementById("moptWorldlineSalesChannelId").value;
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
        this.tokenizer.submitTokenization().then((result) => {
            if (result.success) {
                var newElement = '<input type="hidden" name="moptWorldlineHostedTokenizationId" value="' + result.hostedTokenizationId + '">';
                this.confirmForm.innerHTML+= newElement;
                this.confirmForm.submit();
            } else {
            }
        });
    }
}
