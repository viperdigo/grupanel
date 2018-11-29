<?php

namespace Grupanel\UserBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Grupanel\CoreBundle\Entity\User;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;


class LoadUser extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function load(ObjectManager $manager)
    {

        $adminType = $this->getReference('administrator');
        $supervisorType = $this->getReference('administrator');
        $operatorType = $this->getReference('administrator');

        // Adiciona Administradores
        $admin = new User();
        $admin->setUsername('rodrigo');
        $admin->setPlainPassword('hseDP09zP');
        $admin->setIsActive(true);
        $admin->setRoles(array('ROLE_ADMIN'));
        $admin->setEmail('viperdigo@gmail.com');
        $admin->setName('Rodrigo Alfieri');
        $admin->setUserType($adminType);
        $manager->persist($admin);

        $admin = new User();
        $admin->setUsername('ifreire');
        $admin->setPlainPassword('ifreire');
        $admin->setIsActive(true);
        $admin->setRoles(array('ROLE_ADMIN'));
        $admin->setEmail('ifreire@sabesp.combr');
        $admin->setName('Ivan Freire');
        $admin->setUserType($adminType);
        $manager->persist($admin);

        $admin = new User();
        $admin->setUsername('lmaranho');
        $admin->setPlainPassword('lmaranho');
        $admin->setIsActive(true);
        $admin->setRoles(array('ROLE_ADMIN'));
        $admin->setEmail('lmaranho@sabesp.combr');
        $admin->setName('Lucas Maranho');
        $admin->setUserType($adminType);
        $manager->persist($admin);

        $manager->flush();
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}