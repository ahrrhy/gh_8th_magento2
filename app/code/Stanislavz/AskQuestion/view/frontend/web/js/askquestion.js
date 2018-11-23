define([
    'jquery',
    'Magento_Ui/js/modal/alert',
    'mage/cookies',
    'mage/translate',
    'jquery/ui'
], function ($, alert) {
    'use strict';

    $.widget('stanislavz.askQuestion', {
        options: {
            cookieName: 'ask_question_stop_flooding'
        },

        /** @inheritdoc */
        _create: function () {
            $(this.element).submit(this.submitForm.bind(this));
        },

        /**
         * return void;
         */
        submitForm: function () {
            if (!this.validateForm()) {
                return;
            }

            this.ajaxSubmit();
        },

        /**
         * return bool;
         */
        validateForm: function () {
            return $(this.element).validation().valid();
        },

        /**
         * Submit request via AJAX. Add form key to the post data.
         */
        ajaxSubmit: function () {
            var formData = new FormData($(this.element).get(0));

            formData.append('form_key', $.mage.cookies.get('form_key'));
            formData.append('isAjax', 1);

            $.ajax({
                url: $(this.element).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                type: 'post',
                dataType: 'json',
                context: this,

                /** @inheritdoc */
                beforeSend: function () {
                    $('body').trigger('processStart');
                },

                /** @inheritdoc */
                success: function (response) {
                    var alertContent = response.message.name +
                        '! We got Your question and we will send answer to your e-mail: ' +
                        response.message.email;

                    $('body').trigger('processStop');

                    alert({
                        title: $.mage.__(response.status),
                        content: alertContent
                    });

                    if (response.status === 'Success') {
                        // Prevent from sending requests too often
                        $.mage.cookies.set(this.options.cookieName, true);
                    }
                },

                /** @inheritdoc */
                error: function () {
                    $('body').trigger('processStop');
                    console.log('err');
                    alert({
                        title: $.mage.__('Error'),
                        /*eslint max-len: ["error", { "ignoreStrings": true }]*/
                        content: $.mage.__('Your request can not be submitted right now. Please, contact us directly via email or phone to get your Sample.')
                    });
                }
            });
        }
    });

    return $.stanislavz.askQuestion;
});
