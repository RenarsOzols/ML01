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
use Magebit\Faq\Model\Question;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class InlineEdit
 * @package Magebit\Faq\Controller\Adminhtml\Question
 */
class InlineEdit extends Action
{
    /**
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param QuestionRepositoryInterface $questionRepository
     */
    public function __construct(
        Context                             $context,
        private JsonFactory                 $jsonFactory,
        private QuestionRepositoryInterface $questionRepository,
    )
    {
        parent::__construct($context);
    }

    /**
     * Inline edit action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $questionId) {
                    $question = $this->questionRepository->get((int)$questionId);
                    try {
                        $questionData = $postItems[$questionId]; // data sent in the request
                        $question->setData(array_merge($question->getData(), $questionData));
                        $this->questionRepository->save($question);
                    } catch (\Exception $e) {
                        $messages[] = $this->getErrorWithQuestionId($question, $e->getMessage());
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add question id to error message
     *
     * @param Question $question
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithQuestionId(Question $question, string $errorText): string
    {
        return '[Question ID: ' . $question->getId() . '] ' . $errorText;
    }
}
