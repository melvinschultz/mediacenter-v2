<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Medias;
use AppBundle\Form\MediasType;
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
        $media = new Medias();

        $form = $this->createForm(new MediasType(), $media);

        $form->handleRequest($request);

        if ($request->getMethod() == 'POST')
        {
            if ($form->isSubmitted() && $form->isValid())
            {
                $image = $media->getImage();

                $imageNom = strtolower($media->getNom()).'_'.substr(md5(uniqid(rand(0,9))), 0,8).'.'.$image->guessExtension();

                $image->move($this->container->getParameter('uploads_directory'), $imageNom);

                $media->setImage($imageNom);

                $em = $this->getDoctrine()->getManager();
                $em->persist($media);
                $em->flush();
            }
        }

        // On passe la méthode createView() du formulaire à la vue
        // afin qu'elle puisse afficher le formulaire toute seule
        return $this->render('AppBundle:medias:add-media.html.twig', array('form' => $form->createView(),));
        /*// replace this example code with whatever you need
        return $this->render('@App/medias/add-media.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));*/
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