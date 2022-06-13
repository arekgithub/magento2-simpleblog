<?php declare(strict_types=1);

namespace Convert\Blog\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Convert\Blog\Logger\Logger;

class PostViewAfterEventObserver implements ObserverInterface
{
    /**
     * @var \Convert\Blog\Logger\Logger
     */
    protected $logger;
    
    public function __construct(
        Logger $logger
    ) {
        $this->logger = $logger;
    }

    public function execute(Observer $observer): void
    {
        $this->logger->info('[VIEW] post_id: ' . $observer->getData('post_id'));
    }
}
