var config = {
    'config': {
        'mixins': {
            'mage/validation': {
                'Stanislavz_AskQuestion/js/phone-ukr-mixin': true
            },
            'Magento_Ui/js/lib/validation/rules': {
                'Stanislavz_AskQuestion/js/rule-mobile-ukrainian-ui-mixin': true
            }
        }
    },
    map: {
        '*': {
            askquestion: 'Stanislavz_AskQuestion/js/askquestion'
        }
    }
};
