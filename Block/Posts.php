<?php

namespace Convert\Blog\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Convert\Blog\Model\ResourceModel\Post\Collection as PostCollection;
use \Convert\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use \Convert\Blog\Model\Post;
use \Convert\Blog\Helper\Data as DataHelper;

class Posts extends Template
{
    /**
     * @var DataHelper
     */
    protected $_dataHelper;

   /**
    * CollectionFactory
    * @var null|CollectionFactory
    */
    protected $_postCollectionFactory = null;

    /**
     * Constructor
     *
     * @param Context $context
     * @param PostCollectionFactory $postCollectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        PostCollectionFactory $postCollectionFactory,
        DataHelper $dataHelper,
        array $data = []
    ) {
        $this->_postCollectionFactory = $postCollectionFactory;
        $this->_dataHelper = $dataHelper;
        parent::__construct($context, $data);
    }

    /**
     * @return Post[]
     */
    public function getPosts()
    {
        /** @var PostCollection $postCollection */
        $postCollection = $this->_postCollectionFactory->create();
        $postCollection->addFieldToSelect('*')->load();
        return $postCollection->getItems();
    }

    /**
     * For a given post, returns its url
     * @param Post $post
     * @return string
     */
    public function getPostUrl(
        Post $post
    ) {
        return '/blog/post/view/id/'.$post->getPostId();
    }

    public function isEnabled()
    {
        return $this->_dataHelper->isModuleEnabled();
    }
}
