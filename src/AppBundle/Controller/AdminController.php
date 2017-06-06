<?php

namespace BaseProject\AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    /**
     * @Route("/admin/{page}", name="admin", requirements={"page": "\d+"})
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminAction(Request $request, $page = 1): Response
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:User')->createQueryBuilder('u');

        $pagination = $this->get('knp_paginator')->paginate(
            $queryBuilder,
            $page,
            10
        );

        return $this->render('AppBundle:Admin:list.html.twig', [
            'pagination'    => $pagination
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
    public function demoteAction(Request $request, int $id)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user        = $userManager->findUserBy(['id' => $id]);

        $user->removeRole('ROLE_ADMIN');

        $userManager->updateUser($user);

        return $this->redirectToRoute('admin', $request->query->all());
    }

    /**
     * @Route("/admin/promote/{id}", name="admin_promote")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET"})
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function promoteAction(Request $request, $id)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user        = $userManager->findUserBy(['id' => $id]);

        $user->addRole('ROLE_ADMIN');

        $userManager->updateUser($user);

        return $this->redirectToRoute('admin', $request->query->all());
    }

    /**
     * @Route("/admin/deactivate/{id}", name="admin_deactivate")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET"})
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deactivateAction(Request $request, $id)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user        = $userManager->findUserBy(['id' => $id]);

        $user->setEnabled(false);

        $userManager->updateUser($user);

        return $this->redirectToRoute('admin', $request->query->all());
    }

    /**
     * @Route("/admin/activate/{id}", name="admin_activate")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET"})
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function activateAction(Request $request, $id)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user        = $userManager->findUserBy(['id' => $id]);

        $user->setEnabled(true);

        $userManager->updateUser($user);

        return $this->redirectToRoute('admin', $request->query->all());
    }
}
