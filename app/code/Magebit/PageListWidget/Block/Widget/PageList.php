<?php declare(strict_types=1);
/**
 * Copyright © Magebit, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magebit\PageListWidget\Block\Widget;

use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

/**
 * Class PageList
 *
 * @api
 */
class PageList extends Template implements BlockInterface
{
    /**
     * @var string
     */
    protected $_template = 'widget/page-list.phtml';

    /**
     * @var PageRepositoryInterface
     */
    private PageRepositoryInterface $pageRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * PageList constructor.
     *
     * @param Template\Context $context
     * @param PageRepositoryInterface $pageRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        PageRepositoryInterface $pageRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->pageRepository = $pageRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * Get the CMS pages for the widget.
     *
     * @return PageInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getPages(): array
    {
        $displayMode = $this->getData('display_mode');
        $selectedPages = $this->getData('selected_pages');

        if ($displayMode === 'specific' && !empty($selectedPages)) {
            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilter('identifier', $selectedPages, 'in')
                ->create();

            return $this->pageRepository
                ->getList($searchCriteria)
                ->getItems();
        }

        // If display_mode is set to "all" or no pages are selected, show all pages.
        return $this->pageRepository
            ->getList($this->searchCriteriaBuilder->create())
            ->getItems();
    }
}
