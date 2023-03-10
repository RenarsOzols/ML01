<?php
/**
 * This file is part of the Magebit Faq module package.
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

namespace Magebit\Faq\Api;

/**
 * Faq question management interface.
 *
 * @api
 */
interface QuestionManagementInterface
{
    /**
     * Enable question
     *
     * @param int $questionId
     * @return bool
     */
    public function enableQuestion(int $questionId): bool;

    /**
     * Disable question
     *
     * @param int $questionId
     * @return bool
     */
    public function disableQuestion(int $questionId): bool;
}
