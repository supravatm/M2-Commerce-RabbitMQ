<?php
namespace Stackexchange\RabbitMQ\Observer;

class RabbitOrder implements \Magento\Framework\Event\ObserverInterface
{
    protected $logger;
    protected $publisherInterface;
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\MessageQueue\PublisherInterface $publisherInterface
    )
    {
        $this->logger = $logger;
        $this->publisherInterface = $publisherInterface;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $this->logger->debug(print_r($order->toJson(),true));
        $this->publisherInterface->publish('connector.ordersync.topic', $order->toJson());
    }
}
