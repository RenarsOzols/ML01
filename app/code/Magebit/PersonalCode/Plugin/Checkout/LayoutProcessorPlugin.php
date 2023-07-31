<?php
declare(strict_types=1);

namespace Magebit\PersonalCode\Plugin\Checkout;

use Magento\Checkout\Block\Checkout\LayoutProcessor;

class LayoutProcessorPlugin
{
    /**
     * @param LayoutProcessor $subject
     * @param array $result
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        LayoutProcessor $subject,
        array $result
    ): array {
        // extend shipping address form
        $this->extendAddressFields($result['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children']);

        return $result;
    }

    protected function extendAddressFields(array &$jsLayout)
    {
        $jsLayout['personal_code']['validation']['validate-custom-logic'] = true;
    }
}
