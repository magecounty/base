<?php
/**
 * Custom payment method in Magento 2
 *
 * @category Base
 * @package  Apexx_Base
 */
namespace Apexx\Base\Setup;

use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Sales\Model\Order\StatusFactory;
use Magento\Sales\Model\ResourceModel\Order\StatusFactory as StatusResourceFactory;
use Magento\Sales\Model\Order;

/**
 * Class InstallData
 * @package Apexx\Base\Setup
 */
class InstallData implements InstallDataInterface
{
    const CUSTOM_FAILED_STATUS_CODE = 'failed';
    const CUSTOM_FAILED_STATUS_LABEL = 'Failed';
    const CUSTOM_DECLINED_STATUS_CODE = 'declined';
    const CUSTOM_DECLINED_STATUS_LABEL = 'Declined';
    const CUSTOM_AUTHORISED_STATUS_CODE = 'authorised';
    const CUSTOM_AUTHORISED_STATUS_LABEL = 'Authorised';

    /**
     * @var StatusFactory
     */
    protected $statusFactory;

    /**
     * @var StatusResourceFactory
     */
    protected $statusResourceFactory;

    /**
     * InstallData constructor.
     * @param StatusFactory $statusFactory
     * @param StatusResourceFactory $statusResourceFactory
     */
    public function __construct(
        StatusFactory $statusFactory,
        StatusResourceFactory $statusResourceFactory
    ) {
        $this->statusFactory = $statusFactory;
        $this->statusResourceFactory = $statusResourceFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->addOrderFailedStatus();
        $this->addOrderDeclinedStatus();
        $this->addOrderAuthorisedStatus();
    }

    protected function addOrderFailedStatus()
    {
        $statusResource = $this->statusResourceFactory->create();
        $status = $this->statusFactory->create();

        $status->setData(
            [
                'status' => self::CUSTOM_FAILED_STATUS_CODE,
                'label' => self::CUSTOM_FAILED_STATUS_LABEL,
            ]);

        try {
            $statusResource->save($status);
        } catch (AlreadyExistsException $exception) {
            return;
        }
        //$status->assignState(self::CUSTOM_STATE_CODE, true, true);
    }

    protected function addOrderDeclinedStatus()
    {
        $statusResource = $this->statusResourceFactory->create();
        $status = $this->statusFactory->create();

        $status->setData(
            [
                'status' => self::CUSTOM_DECLINED_STATUS_CODE,
                'label' => self::CUSTOM_DECLINED_STATUS_LABEL,
            ]);

        try {
            $statusResource->save($status);
        } catch (AlreadyExistsException $exception) {
            return;
        }
        //$status->assignState(self::CUSTOM_STATE_CODE, true, true); 
    }
    protected function addOrderAuthorisedStatus()
    {
        $statusResource = $this->statusResourceFactory->create();
        $status = $this->statusFactory->create();

        $status->setData(
            [
                'status' => self::CUSTOM_AUTHORISED_STATUS_CODE,
                'label' => self::CUSTOM_AUTHORISED_STATUS_LABEL,
            ]);

        try {
            $statusResource->save($status);
        } catch (AlreadyExistsException $exception) {
            return;
        } 
        $status->assignState(Order::STATE_PROCESSING, false, true);

    }
}
