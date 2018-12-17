define([
    'underscore',
    'Magento_Ui/js/grid/columns/select'
], function (_, Select) {
    'use strict';

    return Select.extend({
        defaults: {
            additionalCustomClass: '',
            customClasses: {
                pending: 'blue',
                running: 'yellow',
                success: 'green',
                missed: 'grey',
                error: 'red'
            },
            bodyTmpl: 'Stanislavz_RepeatLecture/grid/cells/text'
        },

        /**
         *
         * @param {obj} row
         * @returns {str}
         */
        getCustomClass: function (row) {
            var customClass = this.customClasses[row.status] || '';

            return customClass + ' ' + this.additionalCustomClass;
        },

        getMessageClass: function (row) {
            var status = row.status;
            console.log(status);
        }
    });
});
