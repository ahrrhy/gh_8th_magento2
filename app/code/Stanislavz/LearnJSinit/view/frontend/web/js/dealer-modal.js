define(['jquery', 'Magento_Ui/js/modal/modal'], function ($, modal) {
    var options = {
        type: 'popup',
        responsive: true,
        innerScroll: true,
        title: '',
        buttons: [{
            text: $.mage.__('Close'),
            class: '',
            click: function () {
                this.closeModal();
            }
        }]
    };
    var popup = modal(options, $('.dealer-registration-form-box'));
    $(".dealer-registration-button").on('click', function () {
        $(".dealer-registration-form-box").modal("openModal");
    });
});