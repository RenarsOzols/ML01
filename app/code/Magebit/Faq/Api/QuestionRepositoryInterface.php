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

use Magebit\Faq\Api\Data\QuestionInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Faq question repository interface.
 *
 * @api
 */
interface QuestionRepositoryInterface
{
    /**
     * Retrieve Faq.
     *
     * @param int $id
     * @return QuestionInterface
     * @throws LocalizedException
     */
    public function get(int $id): QuestionInterface;

    /**
     * Save Faq.
     *
     * @param QuestionInterface $faq
     * @return QuestionInterface
     * @throws LocalizedException
     */
    public function save(QuestionInterface $faq): QuestionInterface;

    /**
     * Retrieve Faqs matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResults
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResults;

    /**
     * Delete Faq.
     *
     * @param QuestionInterface $faq
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(QuestionInterface $faq): bool;

    /**
     * Delete Faq by ID.
     *
     * @param int $id
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $id): bool;
}

