<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NavigationController extends Controller
{
    /**
     *
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $mediasHelper = $this->get('mediacenter.medias_helper');

        $totalMedias = $mediasHelper->getEachTypeMediasTotalAction();

        dump($totalMedias);

        return $this->render('AppBundle::nav.html.twig', array(
            'totalMedias' => $totalMedias
        ));
    }
}
