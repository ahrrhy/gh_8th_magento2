define([
    'jquery',
    'uiComponent',
    'ko'
], function (
    $,
    Component,
    ko,
    rgbModel
) {
    'use strict';

    var self;

    return Component.extend({
        myTimer: ko.observable(0),

        /**
         * {inheritdoc}
         */
        initialize: function () {
            self = this;

            this._super();
            this.incrementTime();
        },

        /**
         * Increments timer value
         */
        incrementTime: function () {
            var t = 0;

            setInterval(function () {
                t++;
                self.myTimer(t);
            }, 1000);
        }
    });
});
