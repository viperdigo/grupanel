<?php

namespace Grupanel\BackendBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Grupanel\CoreBundle\Entity\Customer;
use Grupanel\CoreBundle\Entity\Order;
use Grupanel\CoreBundle\Entity\Payment;

class BalanceManager
{
    private $em;
    private $container;

    public function __construct(EntityManager $em, ContainerInterface $container = null)
    {
        $this->em = $em;
        $this->container = $container;
    }

    public function creditBalance(Customer $customer, $amount)
    {
        $currentBalance = $customer->getBalance();
        $creditBalance = $currentBalance + $amount;

        $customer->setBalance($creditBalance);

        $this->container->get('session')->getFlashBag()->add(
            'info',
            $this->container->get('translator')->trans('Customer %name% balance updated.', array('%name%' => $customer->getName()))
        );

        return true;
    }

    public function debitBalance(Customer $customer, $amount)
    {
        $currentBalance = $customer->getBalance();
        $creditBalance = $currentBalance - $amount;

        $customer->setBalance($creditBalance);

        $this->container->get('session')->getFlashBag()->add(
            'info',
            $this->container->get('translator')->trans('Customer %name% balance updated.', array('%name%' => $customer->getName()))
        );

        return true;
    }

}
