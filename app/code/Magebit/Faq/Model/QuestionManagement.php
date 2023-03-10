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

declare(strict_types=1);

namespace Magebit\Faq\Model;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Api\QuestionManagementInterface;
use Magebit\Faq\Api\QuestionRepositoryInterface;

/**
 * Class QuestionManagement
 *
 * @package Magebit\Faq\Model
 */
class QuestionManagement implements QuestionManagementInterface
{
    /**
     * @param QuestionRepositoryInterface $questionRepository
     */
    public function __construct(
        private QuestionRepositoryInterface $questionRepository,
    )
    {
    }

    /**
     * Enable question
     *
     * @param int $questionId
     * @return bool
     */
    public function enableQuestion(int $questionId): bool
    {
        return $this->changeQuestionStatus($questionId, QuestionInterface::ENABLED);
    }

    /**
     * Disable question
     *
     * @param int $questionId
     * @return bool
     */
    public function disableQuestion(int $questionId): bool
    {
        return $this->changeQuestionStatus($questionId, QuestionInterface::DISABLED);
    }

    /**
     * Change question status
     *
     * @param int $questionId
     * @param int $status
     * @return bool
     */
    protected function changeQuestionStatus(int $questionId, int $status): bool
    {
        try {
            $question = $this->questionRepository->get($questionId);
        } catch (\Exception $e) {
            return false;
        }

        $question->setStatus($status);

        try {
            $this->questionRepository->save($question);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
}
