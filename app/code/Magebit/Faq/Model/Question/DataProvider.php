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

namespace Magebit\Faq\Model\Question;

use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magebit\Faq\Model\Question;
use Magebit\Faq\Model\QuestionFactory;
use Magebit\Faq\Model\ResourceModel\Question\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Psr\Log\LoggerInterface;

/**
 * Class DataProvider
 * @package Magebit\Faq\Model\Question
 */
class DataProvider extends ModifierPoolDataProvider
{
    /**
     * @var array
     */
    private array $loadedData;

    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $questionCollectionFactory
     * @param QuestionFactory $questionFactory
     * @param QuestionRepositoryInterface $questionRepository
     * @param RequestInterface $request
     * @param LoggerInterface $logger
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $questionCollectionFactory,
        private QuestionFactory $questionFactory,
        private QuestionRepositoryInterface $questionRepository,
        private RequestInterface $request,
        private LoggerInterface $logger,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
        $this->collection = $questionCollectionFactory->create();
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $question = $this->getCurrentQuestion();
        $this->loadedData[$question->getId()] = $question->getData();
        return $this->loadedData;
    }

    /**
     * @return Question
     */
    private function getCurrentQuestion(): Question
    {
        $questionId = $this->getQuestionId();
        if (!$questionId) {
            return $this->questionFactory->create();
        }

        try {
            return $this->questionRepository->get($questionId);
        } catch (NoSuchEntityException $exception) {
            return $this->questionFactory->create();
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            return $this->questionFactory->create();
        }
    }

    /**
     * @return int|null
     */
    private function getQuestionId(): ?int
    {
        $questionId = $this->request->getParam('question_id');
        if (!$questionId) {
            return null;
        }
        return (int)$questionId;
    }
}
