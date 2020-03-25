window.scroll(function() {
    if (window.scrollTop() > 10) {
        document.getElementById('navBar').addClass('floatingNav');
    } else {
        document.getElementById('navBar').removeClass('floatingNav');
    }
});
