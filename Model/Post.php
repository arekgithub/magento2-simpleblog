<?php declare(strict_types=1);
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Convert\Blog\Model;

// use Convert\Blog\Helper\Post as PostHelper;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Validation\ValidationException;
use Magento\Framework\Validator\HTML\WYSIWYGValidatorInterface;
use Convert\Blog\Api\Data\PostInterface;

/**
 * Convert Blog Post model
 *
 * @api
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @since 100.0.2
 */
class Post extends AbstractModel implements PostInterface, IdentityInterface
{

    /**
     * Convert Blog Post cache tag
     */
    const CACHE_TAG = 'convert_blog_p';

    /**
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'convert_blog_post';

    /**
     * @var WYSIWYGValidatorInterface
     */
    private $wysiwygValidator;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     * @param WYSIWYGValidatorInterface|null $wysiwygValidator
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = [],
        ?WYSIWYGValidatorInterface $wysiwygValidator = null
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->wysiwygValidator = $wysiwygValidator
            ?? ObjectManager::getInstance()->get(WYSIWYGValidatorInterface::class);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Convert\Blog\Model\ResourceModel\Post::class);
    }

    /**
     * Load object data
     *
     * @param int|null $id
     * @param string $field
     * @return $this
     */
    public function load($id, $field = null)
    {
        if ($id === null) {
            return $this->listPosts(); // from noroute
        }
        return parent::load($id, $field);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getPostId()];
    }

    public function getId()
    {
        return $this->_getData('entity_id');
    }

    /**
     * Get ID
     *
     * @return int
     */
    public function getPostId()
    {
        return parent::getData(self::POST_ID);
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->getData(self::AUTHOR);
    }

    /**
     * Get publish date
     *
     * @return string
     */
    public function getPublishDate()
    {
        return $this->getData(self::PUBLISH_DATE);
    }

    public function setId($value)
    {
        $this->setData('entity_id', $value);
        
        return $this;
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return \Convert\Blog\Api\Data\PostInterface
     */
    public function setPostId($id)
    {
        return $this->setData(self::POST_ID, $id);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return \Convert\Blog\Api\Data\PostInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set content
     *
     * @param string $content
     * @return \Convert\Blog\Api\Data\PostInterface
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * Set author
     *
     * @param string $author
     * @return \Convert\Blog\Api\Data\PostInterface
     */
    public function setAuthor($author)
    {
        return $this->setData(self::AUTHOR, $author);
    }

    /**
     * Set publish date
     *
     * @param string $publishDate
     * @return \Convert\Blog\Api\Data\PostInterface
     */
    public function setPublishDate($publishDate)
    {
        return $this->setData(self::PUBLISH_DATE, $publishDate);
    }

    /**
     * @inheritdoc
     * @since 101.0.0
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function beforeSave()
    {

        //Validating Content HTML.
        $oldValue = null;
        if ($this->getPostId()) {
            if ($this->getOrigData()) {
                $oldValue = $this->getOrigData(self::CONTENT);
            } elseif (array_key_exists(self::CONTENT, $this->getStoredData())) {
                $oldValue = $this->getStoredData()[self::CONTENT];
            }
        }
        if ($this->getContent() && $this->getContent() !== $oldValue) {
            try {
                $this->wysiwygValidator->validate($this->getContent());
            } catch (ValidationException $exception) {
                throw new ValidationException(
                    __('Content HTML contains restricted elements. %1', $exception->getMessage()),
                    $exception
                );
            }
        }

        return parent::beforeSave();
    }
}
