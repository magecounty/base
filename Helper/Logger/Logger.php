<?php
/**
 * Custom payment method in Magento 2
 * @category    Base
 * @package     Apexx_Base
 */
namespace Apexx\Base\Helper\Logger;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Monolog\Logger as MonoLogger;

/**
 * Class Logger
 * @package Apexx\Base\Helper\Logger
 */
class Logger extends MonoLogger
{
    /**
     * @var ScopeConfigInterface
     */
    private $config;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * Logging levels from syslog protocol defined in RFC 5424
     *
     * @var array $levels Logging levels
     */
    protected static $levels = array(
        self::DEBUG     => 'DEBUG',
        self::INFO      => 'INFO',
        self::NOTICE    => 'NOTICE',
        self::WARNING   => 'WARNING',
        self::ERROR     => 'ERROR',
        self::CRITICAL  => 'CRITICAL',
        self::ALERT     => 'ALERT',
        self::EMERGENCY => 'EMERGENCY',
    );

    /**
     * Logger constructor.
     * @param string                             $name
     * @param ScopeConfigInterface $config
     * @param StoreManagerInterface $storeManager
     * @param array $handlers
     * @param array $processors
     */
    public function __construct(
        $name,
        ScopeConfigInterface $config,
        StoreManagerInterface $storeManager,
        array $handlers = [],
        array $processors = []
    ) {
        parent::__construct($name, $handlers, $processors);
        $this->config = $config;
        $this->storeManager = $storeManager;
    }

    public function addRecord($level, $message, array $context = [])
    {
        $store = $this->storeManager->getStore();
        if (!$this->config->isSetFlag(
            'payment/apexx_section/apexxpayment/credentials/debug',
            ScopeInterface::SCOPE_STORE,
            $store
        )
        ) {
            return false;
        }

        return parent::addRecord(self::DEBUG, $message, $context);
    }
}
