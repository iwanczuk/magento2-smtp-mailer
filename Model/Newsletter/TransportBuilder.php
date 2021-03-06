<?php
/**
 * See LICENSE.txt for license details.
 */

namespace MageWare\SmtpMailer\Model\Newsletter;

class TransportBuilder extends \Magento\Newsletter\Model\Queue\TransportBuilder
{
    /**
     * @var \MageWare\SmtpMailer\Model\Newsletter\Config
     */
    protected $config;

    /**
     * @param \Magento\Framework\Mail\Template\FactoryInterface $templateFactory
     * @param \Magento\Framework\Mail\MessageInterface $message
     * @param \Magento\Framework\Mail\Template\SenderResolverInterface $senderResolver
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \MageWare\SmtpMailer\Model\Newsletter\TransportInterfaceFactory $mailTransportFactory
     * @param \MageWare\SmtpMailer\Model\Newsletter\Config $config
     */
    public function __construct(
        \Magento\Framework\Mail\Template\FactoryInterface $templateFactory,
        \Magento\Framework\Mail\MessageInterface $message,
        \Magento\Framework\Mail\Template\SenderResolverInterface $senderResolver,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \MageWare\SmtpMailer\Model\Newsletter\TransportInterfaceFactory $mailTransportFactory,
        \MageWare\SmtpMailer\Model\Newsletter\Config $config
    ) {
        parent::__construct(
            $templateFactory,
            $message,
            $senderResolver,
            $objectManager,
            $mailTransportFactory
        );

        $this->config = $config;
    }

    /**
     * @inheritdoc
     */
    public function getTransport()
    {
        if (isset($this->templateOptions['store'])) {
            $store = $this->templateOptions['store'];
        } else {
            $store = null;
        }

        if ($store) {
            $this->config->pushStore($store);
        }

        $mailTransport = parent::getTransport();

        if ($store) {
            $this->config->popStore();
        }

        return $mailTransport;
    }
}
