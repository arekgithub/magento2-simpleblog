<?php declare(strict_types=1);

namespace Convert\Blog\Model;

use Convert\Blog\Api\PostRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Convert\Blog\Api\Data\PostInterface;
use Convert\Blog\Api\Data\PostSearchResultInterface;
use Convert\Blog\Api\Data\PostSearchResultInterfaceFactory;
use Convert\Blog\Model\ResourceModel\Post\Collection as PostCollection;
use Convert\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use Convert\Blog\Helper\Data as DataHelper;

class PostRepository implements PostRepositoryInterface
{
    private PostFactory $postFactory;
    private PostCollectionFactory $postCollectionFactory;
    private PostSearchResultInterfaceFactory $searchResultFactory;
    private CollectionProcessorInterface $collectionProcessor;
    private SearchCriteriaInterface $searchCriteriaInterface;
    private DataHelper $dataHelper;

    public function __construct(
        PostFactory $postFactory,
        PostCollectionFactory $postCollectionFactory,
        PostSearchResultInterfaceFactory $postSearchResultInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor,
        SearchCriteriaInterface $searchCriteriaInterface,
        DataHelper $dataHelper
    ) {
        $this->postFactory = $postFactory;
        $this->postCollectionFactory = $postCollectionFactory;
        $this->searchResultFactory = $postSearchResultInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchCriteriaInterface = $searchCriteriaInterface;
        $this->dataHelper = $dataHelper;
    }

    protected function verifyIfModuleIsEnabled(): void
    {
        if (!$this->dataHelper->isModuleEnabled()) {
            throw new NoSuchEntityException(__('Content is not available'));
        }
    }

    public function getById(int $id): PostInterface
    {
        $this->verifyIfModuleIsEnabled();

        $post = $this->postFactory->create();
        $post->getResource()->load($post, $id);
        if (!$post->getPostId()) {
            throw new NoSuchEntityException(__('Unable to find Post with ID "%1"', $id));
        }
        return $post;
    }

    public function save(PostInterface $post): void
    {
        $this->verifyIfModuleIsEnabled();

        /** @var $post Post **/
        $post->getResource()->save($post);
    }

    public function delete(PostInterface $post): void
    {
        $this->verifyIfModuleIsEnabled();

        /** @var $post Post **/
        $post->getResource()->delete($post);
    }

    public function getPosts()
    {
        $this->verifyIfModuleIsEnabled();

        /** @var PostCollection $postCollection */
        $postCollection = $this->postCollectionFactory->create();
        $postCollection->addFieldToSelect('*')->load();
        return $postCollection->getItems();
    }

    public function getList(SearchCriteriaInterface $searchCriteria = null): PostSearchResultInterface
    {
        $this->verifyIfModuleIsEnabled();

        if (!$searchCriteria) {
            $searchCriteria = $this->searchCriteriaInterface;
        }
        $collection = $this->postCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResult = $this->searchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        return $searchResult;
    }
}
