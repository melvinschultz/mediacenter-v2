<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MediaController extends Controller
{
    /**
     * @Route("/add", name="add")
     */
    public function addAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@App/medias/add-media.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    /**
     * @Route("/movies", name="movies")
     */
    public function showAllMoviesAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@App/medias/movies.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    /**
     * @Route("/series", name="series")
     */
    public function showAllSeriesAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@App/medias/series.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    /**
     * @Route("/medias", name="medias")
     */
    public function showAllAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@App/medias/medias.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
}