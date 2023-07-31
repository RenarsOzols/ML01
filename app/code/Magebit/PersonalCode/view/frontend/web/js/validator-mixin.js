define([
    'jquery',
    'jquery/validate'
], function ($) {
    "use strict";

    return function (validator) {
        validator.addRule('validate-custom-logic', function (v, e) {
            // your logic here

            return /^\d{6}-\d{5}$/.test(v);
        }, $.mage.__("Please enter a valid Personal Code in the format XXXXXX-XXXXX."));

        return validator;
    };
});
