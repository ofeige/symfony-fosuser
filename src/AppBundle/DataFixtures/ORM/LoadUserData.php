<?php

namespace AppBundle\DataFixtures\ORM;

//use AppBundle\Entity\Group;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Model\UserManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    protected $container, $userManager;

    public function load(ObjectManager $manager)
    {
        $this->createUser('ofeige', 'oliver@feige.net', 'test');
        $this->createUser('freddy', 'freddy.tinkloh@gmx.de', 'test');

        for ($i =0; $i < 1000; $i++)
        {
            $this->createUser('user'.$i, 'user'.$i.'@example.com', 'test', true, ['ROLE_USER']);
        }
    }

    private function createUser(string $userName, string $email, string $password, bool $enabled = true, array $roles = ['ROLE_ADMIN', 'ROLE_USER'])
    {
        $userManager = $this->getUserManager();

        $user = $userManager->createUser();
        $user->setUserName($userName);
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setEnabled($enabled);
        $user->setRoles($roles);

        $userManager->updateUser($user);

        return $user;
    }

    public function getUserManager(): userManager
    {
        if(isset($this->userManager) === false) {
            $this->userManager = $this->container->get('fos_user.user_manager');
        }

        return $this->userManager;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function createGroup(ObjectManager $manager, string $name, array $users = []) : Group {
        $group = new Group($name);

        if(!empty($users)) {
            foreach ($users as $user) {
                $group->addUser($user);
            }
        }

        $manager->persist($group);
        $manager->flush();

        return $group;
    }
}
