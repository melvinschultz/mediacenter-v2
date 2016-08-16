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

                $imageNom = strtolower(str_replace(' ', '_', $media->getNom())).'_'.substr(md5(uniqid(rand(0,9))), 0,8).'.'.$image->guessExtension();

                $image->move($this->container->getParameter('uploads_directory'), $imageNom);

                $media->setImage($imageNom);

//                dump($media);die;

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
    public function showAllMoviesAction()
    {
        $films = $this->getDoctrine()
            ->getRepository('AppBundle:Medias')
            ->findBy(array('type' => 'film'));

        if (!$films) {
            throw $this->createNotFoundException(
                'Aucun film trouvé'
            );
        }

        // replace this example code with whatever you need
        return $this->render('AppBundle:medias:movies.html.twig', array(
            'films' => $films,
        ));
    }

    /**
     * @Route("/series", name="series")
     */
    public function showAllSeriesAction()
    {
        $series = $this->getDoctrine()
            ->getRepository('AppBundle:Medias')
            ->findBy(array('type' => 'serie'));

        if (!$series) {
            throw $this->createNotFoundException(
                'Aucune série trouvée'
            );
        }

        // replace this example code with whatever you need
        return $this->render('AppBundle:medias:series.html.twig', array(
            'series' => $series,
        ));
    }

    /**
     * @Route("/medias", name="medias")
     */
    public function showAllAction()
    {
        $medias = $this->getDoctrine()
            ->getRepository('AppBundle:Medias')
            ->findAll();

        if (!$medias) {
            throw $this->createNotFoundException(
                'Aucun film ou série trouvé(e)'
            );
        }

        // replace this example code with whatever you need
        return $this->render('AppBundle:medias:medias.html.twig', array(
            'medias' => $medias,
        ));
    }
}