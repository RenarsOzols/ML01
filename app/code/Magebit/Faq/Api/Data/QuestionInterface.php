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

namespace Magebit\Faq\Api\Data;

/**
 * Faq question interface.
 *
 * @api
 */
interface QuestionInterface
{
    /**
     * #@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID = 'id';
    const QUESTION = 'question';
    const ANSWER = 'answer';
    const STATUS = 'status';
    const ENABLED = 1;
    const DISABLED = 0;
    const ENABLED_LABEL = 'Enabled';
    const DISABLED_LABEL = 'Disabled';
    const POSITION = 'position';
    const UPDATED_AT = 'updated_at';
    /**
     * #@-
     */

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion(): string;

    /**
     * Get answer
     *
     * @return string
     */
    public function getAnswer(): string;

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus(): int;

    /**
     * Get position
     *
     * @return int
     */
    public function getPosition(): int;

    /**
     * Get update time
     *
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * Set question
     *
     * @param string $text
     * @return QuestionInterface
     */
    public function setQuestion(string $text): QuestionInterface;

    /**
     * Set answer
     *
     * @param string $text
     * @return QuestionInterface
     */
    public function setAnswer(string $text): QuestionInterface;

    /**
     * Set status
     *
     * @param int $status
     * @return QuestionInterface
     */
    public function setStatus(int $status): QuestionInterface;

    /**
     * Set position
     *
     * @param int $position
     * @return QuestionInterface
     */
    public function setPosition(int $position): QuestionInterface;
}
