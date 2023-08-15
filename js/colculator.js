if (window.addEventListener) {
    window.addEventListener("load", function () { calc_basic() }, false)
}
else if (window.attachEvent) {
    window.attachEvent("onload", function () { calc_basic() })
}
else {
    window.onload = function () { calc_basic() }
}

