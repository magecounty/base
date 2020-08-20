<?php
/**
 * Custom payment method in Magento 2
 * @category    Base
 * @package     Apexx_Base
 */
namespace Apexx\Base\Helper\Logger;

use Magento\Framework\Logger\Handler\Base;

/**
 * Class Handler
 * @package Apexx\Base\Helper\Logger
 */
class Handler extends Base
{
    /**
     * @var string
     */
    protected $fileName = '/var/log/apexx_payment.log';

    /**
     * @var int
     */
    protected $loggerType = \Monolog\Logger::DEBUG;
}
