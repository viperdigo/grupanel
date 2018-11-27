<?php

namespace Grupanel\BackendBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Grupanel\CoreBundle\Entity\Customer;
use Grupanel\CoreBundle\Entity\Order;
use Grupanel\CoreBundle\Entity\Payment;
use Grupanel\CoreBundle\Entity\Product;

class StorageManager
{
    private $em;
    private $container;

    public function __construct(EntityManager $em, ContainerInterface $container = null)
    {
        $this->em = $em;
        $this->container = $container;
    }

    public function takeStock(Product $product)
    {
        return true;
    }

    public function restocking(Product $product)
    {
        return true;
    }
}
