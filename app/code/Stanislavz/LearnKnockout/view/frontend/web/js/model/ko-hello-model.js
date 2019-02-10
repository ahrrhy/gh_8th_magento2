define(
    ['ko'],
    function (ko) {
        'use strict';

        var red = ko.observable(0),
            blue = ko.observable(0),
            green = ko.observable(0);

        /**
         *
         * @returns {int}
         */
        function randomNumber() {
            return Math.floor(Math.random() * 255 + 1);
        }

        /**
         *
         */
        function updateColour() {
            red(randomNumber());
            blue(randomNumber());
            green(randomNumber());
        }

        return {
            randomNumber: randomNumber,
            updateColour: updateColour,
            red: red,
            blue: blue,
            green: green
        };
    }
);
