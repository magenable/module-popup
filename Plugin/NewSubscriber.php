<?php

declare(strict_types=1);

namespace Magenable\Popup\Plugin;

use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Element\Message\InterpretationStrategyInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Newsletter\Controller\Subscriber\NewAction;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\Json;

class NewSubscriber
{
    private ManagerInterface $messageManager;
    private InterpretationStrategyInterface $interpretationStrategy;
    private JsonFactory $jsonFactory;

    public function __construct(
        ManagerInterface $messageManager,
        InterpretationStrategyInterface $interpretationStrategy,
        JsonFactory $jsonFactory
    ) {
        $this->messageManager = $messageManager;
        $this->interpretationStrategy = $interpretationStrategy;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @param NewAction $subject
     * @param Redirect $result
     * @return Redirect|Json
     */
    public function afterExecute(
        NewAction $subject,
        $result
    ) {
        if (!$subject->getRequest()->getParam('magenable_popup_newsletter')) {
            return $result;
        }

        $messages = $this->messageManager->getMessages(true);
        $messagesData = [];
        foreach ($messages->getItems() as $message) {
            $messagesData[$message->getType()][] = $this->interpretationStrategy->interpret($message);
        }
        $resultJson = $this->jsonFactory->create();
        $resultJson->setData($messagesData);

        return $resultJson;
    }
}
