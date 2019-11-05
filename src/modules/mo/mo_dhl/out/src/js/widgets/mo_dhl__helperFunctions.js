DHLHelper = function () {

    /**
     * debounce only executes the last call of a function in a given timeframe
     * taken from https://john-dugan.com/javascript-debounce/
     * @param func
     * @param wait
     * @param immediate
     * @return {Function}
     */
    this.debounce = function (func, wait, immediate) {
        var timeout;
        return function() {
            var context = this,
                args = arguments;
            var later = function() {
                timeout = null;
                if ( !immediate ) {
                    func.apply(context, args);
                }
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait || 200);
            if ( callNow ) {
                func.apply(context, args);
            }
        };
    }
};

var mo_DHL__Helper = new DHLHelper();
