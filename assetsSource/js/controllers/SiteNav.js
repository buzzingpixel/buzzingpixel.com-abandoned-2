// Make sure FAB is defined
window.FAB = window.FAB || {};

function runSiteNav(F) {
    'use strict';

    if (! window.jQuery || ! F.controller) {
        setTimeout(function() {
            runSiteNav(F);
        }, 10);
        return;
    }

    F.controller.make('SiteNav', {
        clickEventInProgress: false,

        model: {
            isOpen: 'bool'
        },

        events: {
            'click .JS-SiteNav__Expander': function() {
                var self = this;
                var shouldOpen = ! self.model.get('isOpen');

                self.clickEventInProgress = true;

                self.model.set('isOpen', shouldOpen);

                setTimeout(function() {
                    self.clickEventInProgress = shouldOpen;
                }, 500);
            },
            mouseenter: function() {
                var self = this;
                setTimeout(function() {
                    if (self.clickEventInProgress) {
                        return;
                    }
                    self.model.set('isOpen', true);
                }, 50);
            },
            mouseleave: function() {
                var self = this;
                setTimeout(function() {
                    if (self.clickEventInProgress) {
                        return;
                    }
                    self.model.set('isOpen', false);
                }, 400);
            }
        },

        init: function() {
            var self = this;

            self.model.onChange('isOpen', function(val) {
                if (val) {
                    self.openMenu();
                    return;
                }

                self.closeMenu();
            });
        },

        openMenu: function() {
            var self = this;
            self.$el.addClass(self.$el.data('activeClass'));
        },

        closeMenu: function() {
            var self = this;
            self.$el.removeClass(self.$el.data('activeClass'));
        }
    });
}

runSiteNav(window.FAB);
