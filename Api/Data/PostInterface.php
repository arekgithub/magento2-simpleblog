<?php declare(strict_types=1);

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Convert\Blog\Api\Data;

/**
 * Convert Blog Post interface
 * @api
 * @since 100.0.2
 */
interface PostInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const POST_ID                  = 'post_id';
    const TITLE                    = 'title';
    const CONTENT                  = 'content';
    const AUTHOR                   = 'author';
    const PUBLISH_DATE             = 'publish_date';
    /**#@-*/

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @return int|null
     */
    public function getPostId();

    /**
     * @return string|null
     */
    public function getTitle();

    /**
     * @return string|null
     */
    public function getContent();

    /**
     * @return string|null
     */
    public function getAuthor();

    /**
     * @return string|null
     */
    public function getPublishDate();

    /**
     * @param int $id
     * @return \Convert\Blog\Api\Data\PostInterface
     */
    public function setId($id);

    /**
     * @param int $value
     * @return void
     */
    public function setPostId(int $value);
    
    /**
     * @param string $title
     * @return \Convert\Blog\Api\Data\PostInterface
     */
    public function setTitle($title);

    /**
     * @param string $author
     * @return \Convert\Blog\Api\Data\PostInterface
     */
    public function setAuthor($author);

    /**
     * @param string $content
     * @return \Convert\Blog\Api\Data\PostInterface
     */
    public function setContent($content);

    /**
     * @param string $publishDate
     * @return \Convert\Blog\Api\Data\PostInterface
     */
    public function setPublishDate($publishDate);
}
