// Make sure FAB is defined
window.FAB = window.FAB || {};

function runMain(F, W) {
    'use strict';

    if (! W.jQuery ||
        ! F.controller ||
        ! F.model
    ) {
        setTimeout(function() {
            runMain(F, W);
        }, 10);
        return;
    }

    $('.JS-SiteNav').each(function() {
        F.controller.construct('SiteNav', {
            el: this
        });
    });
}

runMain(window.FAB, window);
