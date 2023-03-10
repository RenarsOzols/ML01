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
use Magebit\Faq\Api\Data\QuestionSearchResultsInterfaceFactory;
use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magebit\Faq\Model\ResourceModel\Question as FaqResource;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class QuestionRepository
 * @package Magebit\Faq\Model
 */
class QuestionRepository implements QuestionRepositoryInterface
{
    /**
     * @param QuestionFactory $questionFactory
     * @param FaqResource $faqResource
     * @param FaqResource\CollectionFactory $collectionFactory
     * @param QuestionSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        private QuestionFactory                       $questionFactory,
        private FaqResource                           $faqResource,
        private FaqResource\CollectionFactory         $collectionFactory,
        private QuestionSearchResultsInterfaceFactory $searchResultsFactory,
        private CollectionProcessorInterface          $collectionProcessor,
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): QuestionInterface
    {
        $faq = $this->questionFactory->create();
        $this->faqResource->load($faq, $id);
        if (!$faq->getId()) {
            throw new NoSuchEntityException(__('FAQ with ID "%1" does not exist.', $id));
        }
        return $faq;
    }

    /**
     * @inheritDoc
     */
    public function save(QuestionInterface $faq): QuestionInterface
    {
        try {
            $this->faqResource->save($faq);
        } catch (\Exception $exception) {
            throw new LocalizedException(__($exception->getMessage()));
        }
        return $faq;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResults
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(QuestionInterface $faq): bool
    {
        try {
            $this->faqResource->delete($faq);
        } catch (\Exception $exception) {
            throw new LocalizedException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $id): bool
    {
        return $this->delete($this->get($id));
    }
}
