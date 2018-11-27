define(
    [
        'jquery',
        'uiComponent',
        'ko'
    ],
    function ($, Component, ko) {
        'use strict';

        return Component.extend({

            /**
             * {inheritdoc}
             */
            initialize: function () {
                this._super();
            }
        });
    }
);