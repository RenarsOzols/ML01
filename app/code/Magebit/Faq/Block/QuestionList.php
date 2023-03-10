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

namespace Magebit\Faq\Block;

use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Phrase;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class QuestionList
 *
 * @api
 */
class QuestionList extends Template
{
    /**
     * QuestionList constructor.
     *
     * @param Context $context
     * @param QuestionRepositoryInterface $repository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param array $data
     */
    public function __construct(
        Context                             $context,
        private QuestionRepositoryInterface $repository,
        private SearchCriteriaBuilder       $searchCriteriaBuilder,
        private SortOrderBuilder            $sortOrderBuilder,
        array                               $data = []
    )
    {
        parent::__construct($context, $data);
    }

    /**
     * @return Phrase
     */
    public function getTitle(): Phrase
    {
        return __('Frequently Asked Questions');
    }

    /**
     * @return array
     */
    public function getQuestions(): array
    {
        try {
            $sortOrder = $this->sortOrderBuilder
                ->setField('position')
                ->setDirection('DESC')
                ->create();

            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilter('status', 1)
                ->addSortOrder($sortOrder)
                ->create();

            return $this->repository->getList($searchCriteria)->getItems();

        } catch (\Exception $e) {
            $this->_logger->error($e->getMessage());
            return [];
        }
    }
}
