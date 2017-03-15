<?php

namespace BaseProject\AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method({"GET"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle::index.html.twig');
    }

    /**
     * @Route("/dashboard", name="dashboard")
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardAction()
    {
        return $this->render('AppBundle::dashboard.html.twig');
    }

    /**
     * @Route("/changelog", name="changelog")
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function changelogAction()
    {
        return $this->render('AppBundle::changelog.html.twig');
    }

    /**
     * @Route("/debug", name="debug")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function debugAction(Request $request)
    {
        return $this->render('AppBundle::debug.html.twig', [
            'debugInfo' => [
                'locale' => $request->getLocale(),
                'defaultLocale' => $request->getDefaultLocale(),
            ]
        ]);
    }
}
