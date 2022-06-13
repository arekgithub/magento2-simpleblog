<?php

namespace Convert\Blog\Block;

use \Magento\Framework\Exception\LocalizedException;
use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Framework\Registry;
use \Convert\Blog\Model\Post;
use \Convert\Blog\Model\PostFactory;
use \Convert\Blog\Controller\Post\View as ViewAction;
use \Convert\Blog\Helper\Data as DataHelper;

class PostView extends Template
{
    /**
     * @var DataHelper
     */
    protected $_dataHelper;

    /**
     * Core registry
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * Post
     * @var null|Post
     */
    protected $_post = null;

    /**
     * PostFactory
     * @var null|PostFactory
     */
    protected $_postFactory = null;

    /**
     * Constructor
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PostFactory $postCollectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PostFactory $postFactory,
        DataHelper $dataHelper,
        array $data = []
    ) {
        $this->_postFactory = $postFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->_dataHelper = $dataHelper;
        parent::__construct($context, $data);
    }

    /**
     * Lazy loads the requested post
     * @return Post
     * @throws LocalizedException
     */
    public function getPost()
    {
        if ($this->_post === null) {
            /** @var Post $post */
            $post = $this->_postFactory->create();
            $post->load($this->_getPostId());

            if (!$post->getPostId()) {
                throw new LocalizedException(__('Blog post not found'));
            }

            $this->_post = $post;
        }
        return $this->_post;
    }

    /**
     * Retrieves the post id from the registry
     * @return int
     */
    protected function _getPostId()
    {
        return (int) $this->_coreRegistry->registry(
            ViewAction::REGISTRY_KEY_POST_ID
        );
    }

    public function isEnabled()
    {
        return $this->_dataHelper->isModuleEnabled();
    }
}
