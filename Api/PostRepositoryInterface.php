<?php declare(strict_types=1);

namespace Convert\Blog\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Convert\Blog\Api\Data\PostInterface;
use Convert\Blog\Api\Data\PostSearchResultInterface;

interface PostRepositoryInterface
{
    /**
     * @param int $id
     * @return \Convert\Blog\Api\Data\PostInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id): PostInterface;

    /**
     * @param \Convert\Blog\Api\Data\PostInterface
     * @return void
     */
    public function save(PostInterface $Post): void;
    
    /**
     * @param \Convert\Blog\Api\Data\PostInterface
     * @return void
     */
    public function delete(PostInterface $Post): void;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Convert\Blog\Api\Data\PostSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): PostSearchResultInterface;
}
