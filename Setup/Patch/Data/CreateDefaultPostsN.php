<?php

namespace Convert\Blog\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class CreateDefaultPostsN implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public function apply()
    {
        $this->moduleDataSetup->startSetup();
        $setup = $this->moduleDataSetup;

        $data = [
            [
                'title' => 'Blog post #1',
                'content' => "<p>The 1st blog post content</p>\r\n",
                'author' => "The First Author",
                'publish_date' => '2022-01-01'
            ],
            [
                'title' => 'Blog post #2',
                'content' => "<p>The 2nd blog post content</p>\r\n",
                'author' => "The Second Author",
                'publish_date' => '2022-02-02 12:00:00'
            ],
            [
                'title' => 'Blog post #3',
                'content' => "<p>The 3rd blog post content</p>\r\n",
                'author' => "The Third Author",
                'publish_date' => '2022-03-03'
            ],
            [
                'title' => 'Future post #4',
                'content' => "<p>The one that is not published</p>\r\n",
                'author' => "The Third Author",
                'publish_date' => '2022-12-31'
            ]

        ];

        $this->moduleDataSetup->getConnection()->insertArray(
            $this->moduleDataSetup->getTable('convert_blog_post'),
            ['title', 'content', 'author', 'publish_date'],
            $data
        );

        $this->moduleDataSetup->endSetup();
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
