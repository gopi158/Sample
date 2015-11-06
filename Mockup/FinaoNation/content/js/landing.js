(function () {
    if (window.addEventListener) {
        window.addEventListener("load", hide_loading_screen, false);
    }
    else {
        window.attachEvent("onload", hide_loading_screen);
    }
})();

function display_loading_screen() {
    document.getElementById("loading_screen").style.display = 'block';
}

function hide_loading_screen() {
    document.getElementById("loading_screen").style.display = 'none';
}
//loading screen

          