/**
 * This file is part of the Magebit theme package.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magebit_AmastyFaq
 * to newer versions in the future.
 *
 * @copyright Copyright (c) 2023 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

'use strict';

define([
    'ko',
    'uiElement'
], function (ko, Element) {
    return Element.extend({
        defaults: {
            template: 'Magento_Catalog/input-counter'
        },

        initObservable: function () {
            this._super()
                .observe('qty');

            return this;
        },

        getDataValidator: function () {
            return JSON.stringify(this.dataValidate);
        },

        decreaseQty: function () {
            var qty;

            if (this.qty() > 1) {
                qty = this.qty() - 1;
            } else {
                qty = 1;
            }

            this.qty(qty);
        },

        increaseQty: function () {
            var qty = this.qty() + 1;

            this.qty(qty);
        }
    });
});
