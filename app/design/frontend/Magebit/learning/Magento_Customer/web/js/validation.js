require([
    'jquery',
    'jquery/ui',
    'jquery/validate',
    'mage/translate'
], function ($) {
    $.validator.addMethod(
        'validate-personal-code',
        function (value, element) {
            // Your custom validation logic
            return this.optional(element) || /^\d{6}-\d{5}$/.test(value);
        },
        $.mage.__('Please enter a valid Personal Code in the format XXXXXX-XXXXX.')
    );

    // Apply the custom validation rule to the personal_code field
    $('#personal_code').addClass('validate-personal-code');
});
