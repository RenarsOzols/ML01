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

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class NewAction
 * @package Magebit\Faq\Controller\Adminhtml\Question
 */
class NewAction extends Action
{
    /**
     * @inheritDoc
     */
    public function execute(): ResultInterface
    {
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('FAQ Question'));
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
