define(
    [
        'jquery',
        'uiComponent',
        'ko',
        'Magento_Catalog/js/model/rgb-model'
    ],
    function (
        $,
        Component,
        ko,
        rgbModel
    ) {
        'use strict';

        var self;

        return Component.extend({
            myTimer: ko.observable(0),
            randomColour: ko.computed(function () {
                return 'rgb(' + rgbModel.red() + ', ' + rgbModel.blue() + ', ' + rgbModel.green() + ')';
            }, this),

            /**
             * {inheritdoc}
             */
            initialize: function () {
                self = this;

                this._super();
                this.incrementTime();
                this.subscribeToTime();
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
            },

            /**
             * Subscribe to model update
             */
            subscribeToTime: function () {
                this.myTimer.subscribe(function () {
                    rgbModel.updateColour();
                });
            }
        });
    }
);
