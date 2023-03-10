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
use Magebit\Faq\Model\QuestionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

/**
 * Class Save
 * @package Magebit\Faq\Controller\Adminhtml\Question
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * @param Context $context
     * @param QuestionRepositoryInterface $questionRepository
     * @param QuestionFactory $questionFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context                             $context,
        private QuestionRepositoryInterface $questionRepository,
        private QuestionFactory             $questionFactory,
        private LoggerInterface             $logger,
    )
    {
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     * @throws LocalizedException
     */
    public function execute(): ResultInterface
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            if (empty($data['id'])) {
                $data['id'] = null;
                $model = $this->questionFactory->create();
            } else {
                $model = $this->questionRepository->get((int)$data['id']);
            }
            try {
                $model->setData($data);
                $this->questionRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the question.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $exception) {
                $this->logger->critical($exception->getMessage());
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the question.'));
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}
