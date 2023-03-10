<?php
/**
 * This file is part of the Magebit PageListWidget package.
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

declare(strict_types=1);

namespace Magebit\Faq\Model\Question\Source;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Status
 * @package Magebit\Faq\Model\Question\Source
 */
class Status implements OptionSourceInterface
{

    /**
     * @inheritDoc
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => QuestionInterface::DISABLED, 'label' => __(QuestionInterface::DISABLED_LABEL)],
            ['value' => QuestionInterface::ENABLED, 'label' => __(QuestionInterface::ENABLED_LABEL)]
        ];
    }
}
