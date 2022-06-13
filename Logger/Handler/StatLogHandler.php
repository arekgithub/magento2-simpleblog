<?php

namespace Convert\Blog\Logger\Handler;

use Monolog\Logger;

class StatLogHandler extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * Logging level
     * @var int
     */
    protected $loggerType = Logger::INFO;

    /**
     * File name
     * @var string
     */
    protected $fileName = 'var/log/convert_blog.log';
}
