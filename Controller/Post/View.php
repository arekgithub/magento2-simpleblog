<?php

namespace Convert\Blog\Controller\Post;

use \Magento\Framework\App\Action\Action;
use \Magento\Framework\View\Result\PageFactory;
use \Magento\Framework\View\Result\Page;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\Exception\LocalizedException;
use \Magento\Framework\Registry;
use \Magento\Framework\Event\ManagerInterface as EventManager;

class View extends Action
{
    const REGISTRY_KEY_POST_ID = 'convert_blog_post_id';

    /**
     * Core registry
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var EventManager
     */
    protected $eventManager;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param EventManager $eventManager
     *
     * @codeCoverageIgnore
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        EventManager $eventManager
    ) {
        parent::__construct(
            $context
        );
        $this->_coreRegistry = $coreRegistry;
        $this->_resultPageFactory = $resultPageFactory;
        $this->eventManager = $eventManager;
    }

    /**
     * Saves the blog id to the register and renders the page
     * @return Page
     * @throws LocalizedException
     */
    public function execute()
    {
        $this->_coreRegistry->register(self::REGISTRY_KEY_POST_ID, (int) $this->_request->getParam('id'));
        $resultPage = $this->_resultPageFactory->create();
        $this->eventManager->dispatch(
            'convert_blog_post_view_event_after',
            ['post_id' => (int) $this->_request->getParam('id')]
        );
        return $resultPage;
    }
}
