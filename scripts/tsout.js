var validateSearch = function (elementId) {
    var element = document.getElementById(elementId);
    if (validateXSS(element.value)) {
        element.value = validateSQL(element.value);
        return true;
    }
    alert("Possible XSS detected");
    return false;
};
var validateXSS = function (input) {
    return input.match(/(\b)(on\S+)(\s*)=|javascript|(<\s*)(\/*)script/ig).length == 0;
};
var validateSQL = function (input) {
    return input.match(/(^[a-zA-Z0-9])+/g).join();
};
if (!HTMLElement.prototype.find) {
    HTMLElement.prototype.find = function (ref) {
        for (var _i = 0, _a = this.children; _i < _a.length; _i++) {
            var child = _a[_i];
            if (child.getAttribute("ref") == ref) {
                return child;
            }
            else {
                var res = child.find(ref);
                if (res) {
                    return res;
                }
            }
        }
        return undefined;
    };
}
//# sourceMappingURL=tsout.js.map