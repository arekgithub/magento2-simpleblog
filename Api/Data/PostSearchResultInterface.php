<?php declare(strict_types=1);
 
namespace Convert\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface PostSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Convert\Blog\Api\Data\PostInterface[]
     */
    public function getItems();

    /**
     * @param \Convert\Blog\Api\Data\PostInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
