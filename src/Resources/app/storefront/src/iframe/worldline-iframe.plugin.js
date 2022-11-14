import HttpClient from 'src/service/http-client.service';
import Plugin from 'src/plugin-system/plugin.class';

export default class WorldlineIframePlugin extends Plugin {
    init() {
        // initalize the HttpClient
        this._client = new HttpClient();

        // get refernces to the dom elements
        // this.button = document.getElementById("confirmFormSubmit");
        this.textdiv = document.getElementById("ajax-display");

        // register the events
        this._registerEvents();
        //this._client.get('/worldline_iframe', this._setContent.bind(this), 'application/json', true)

        // this._client.get('/worldline_iframe', this._setContent.bind(this), 'application/json', true)
    }

    _registerEvents() {
        // fetch the timestamp, when the button is clicked
        // this.button.onclick = this._fetch.bind(this);
    }

    _fetch() {
        // make the network request and call the `_setContent` function as a callback
        this._client.get('/worldline_iframe', this._setContent.bind(this), 'application/json', true)
    }

    _setContent(data) {
        //this.textdiv.innerHTML = data;

        // parse the response and set the `textdiv.innerHTML` to the timestamp
        this.textdiv.innerHTML = JSON.parse(data).form
    }
}
