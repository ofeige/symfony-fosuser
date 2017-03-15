<?php

namespace BaseProject\AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminAction()
    {
        $repository = $this->getDoctrine()
                           ->getRepository('AppBundle:User');

        $results = $repository->findAll();

        return $this->render('AppBundle::admin.html.twig', ['headline' => 'User Admin',
                                                            'table'    => $results,
        ]);
    }

    /**
     * @Route("/admin/demote/{id}", name="admin_demote")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET"})
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function demoteAction($id)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user        = $userManager->findUserBy(['id' => $id]);

        $user->removeRole('ROLE_ADMIN');

        $userManager->updateUser($user);

        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/admin/promote/{id}", name="admin_promote")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET"})
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function promoteAction($id)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user        = $userManager->findUserBy(['id' => $id]);

        $user->addRole('ROLE_ADMIN');

        $userManager->updateUser($user);

        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/admin/deactivate/{id}", name="admin_deactivate")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET"})
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deactivateAction($id)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user        = $userManager->findUserBy(['id' => $id]);

        $user->setEnabled(false);

        $userManager->updateUser($user);

        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/admin/activate/{id}", name="admin_activate")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET"})
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function activateAction($id)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user        = $userManager->findUserBy(['id' => $id]);

        $user->setEnabled(true);

        $userManager->updateUser($user);

        return $this->redirectToRoute('admin');
    }
}
