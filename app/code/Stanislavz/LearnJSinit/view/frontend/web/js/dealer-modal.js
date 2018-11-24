define(
    ['jquery', 'Magento_Ui/js/modal/modal'],
    function ($, modal) {
        'use strict';

        var options = {
            type: 'popup',
            responsive: true,
            innerScroll: true,
            title: '',
            buttons: [{
                text: $.mage.__('Close'),
                class: '',

                /**
                 * Close modal
                 */
                click: function () {
                    this.closeModal();
                }
            }]
        };

        var popup = modal(
            options,
            $('[data-attribute="modal-content"]')
        );
        $('#dealer-registration-button').on('click', function () {
            $('[data-attribute="modal-content"]').modal('openModal').trigger('contentUpdated');
            // $('[data-attribute="modal-content"]').modal('openModal');
        });
    }
);