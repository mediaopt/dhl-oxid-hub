DHLValidator = function () {
    this.blacklist = ["<", ">", "\n", "\r", "\\", "'", '"', '\\"', ";", "+", "Paketbox", "Packstation", "Postfach", "Postfiliale", "Filiale", "Postfiliale Direkt", "Filiale Direkt", "Paketkasten", "DHL", "P-A-C-K-S-T-A-T-I-O-N", "Paketstation", "Pack Station", "P.A.C.K.S.T.A.T.I.O.N.", "Pakcstation", "Paackstation", "Pakstation", "Backstation", "Bakstation", "P A C K S T A T I O N", "Wunschfiliale", "Deutsche Post"];

    this.validateAgainstBlacklist = function (value) {
        var self = this;
        for (var i = 0; i < self.blacklist.length; i++) {
            if (value.toUpperCase().indexOf(self.blacklist[i].toUpperCase()) !== -1) {
                return false;
            }
        }
        return true;
    };
};
