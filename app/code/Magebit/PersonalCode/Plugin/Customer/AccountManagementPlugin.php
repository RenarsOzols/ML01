<?php
namespace Magebit\PersonalCode\Plugin\Customer;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Framework\Exception\LocalizedException;

class AccountManagementPlugin
{
    public function beforeCreateAccount(
        AccountManagementInterface $subject,
        $customer,
        $password,
        $redirectUrl = ''
    ): array {
        // Retrieve the custom attributes data
        $personalCode = $customer->getCustomAttribute('personal_code');

        if ($personalCode && $personalCode->getValue() !== null && !preg_match('/^\d{6}-\d{5}$/', $personalCode->getValue())) {
            throw new LocalizedException(
                __('Invalid Personal Code. Please enter a valid Personal Code in the format XXXXXX-XXXXX.')
            );
        }

        return [$customer, $password, $redirectUrl];
    }
}
