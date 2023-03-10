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

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magebit\Faq\Model\ResourceModel\Question\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class MassDelete
 * @package Magebit\Faq\Controller\Adminhtml\Question
 */
class MassDelete extends Action
{
    /**
     * @param Context $context
     * @param Filter $filter
     * @param QuestionRepositoryInterface $questionRepository
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context                             $context,
        private Filter                      $filter,
        private QuestionRepositoryInterface $questionRepository,
        private CollectionFactory           $collectionFactory
    )
    {
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute(): ResultInterface
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('An error occurred while deleting the records. Please try again later.'));
            return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/');
        }

        $deleted = 0;
        foreach ($collection->getItems() as $question) {
            try {
                $this->questionRepository->deleteById($question->getId());
                $deleted++;
            } catch (\Exception $exception) {
                $this->messageManager->addErrorMessage(__('An error occurred while deleting record with ID %1. Please try again later.', $question->getId()));
            }
        }

        if ($deleted > 0) {
            $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $deleted));
        }

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/');
    }
}
