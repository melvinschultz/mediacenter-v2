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
     * @Route("/medias", name="medias")
     * @Route("/movies", name="movies")
     * @Route("/series", name="series")
     */
    public function showAllAction(Request $request)
    {
        $path = $request->getPathInfo();

        $movies = null;
        $series = null;

        if ($path == "/movies") {
            $movies = $this->getMoviesAction();
        }
        elseif ($path == "/series") {
            $series = $this->getSeriesAction();
        }
        else {
            $movies = $this->getMoviesAction();
            $series = $this->getSeriesAction();
        }

        return $this->render('AppBundle:medias:medias.html.twig', array(
            'movies' => $movies,
            'series' => $series
        ));
    }

    public function getMoviesAction()
    {
        $movies = $this->getDoctrine()
            ->getRepository('AppBundle:Medias')
            ->findBy(array('type' => 'film'));

        if (!$movies) {
            throw $this->createNotFoundException(
                'Aucun film trouvé'
            );
        }
        else {
            return $movies;
        }
    }

    public function getSeriesAction()
    {
        $series = $this->getDoctrine()
            ->getRepository('AppBundle:Medias')
            ->findBy(array('type' => 'serie'));

        if (!$series) {
            throw $this->createNotFoundException(
                'Aucune série trouvée'
            );
        }
        else {
            return $series;
        }
    }

    /**
     * @Route("/movies/{id}/delete", name="delete_movie")
     * @Route("/series/{id}/delete", name="delete_serie")
     *
     */
    public function deleteMediaAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $media = $em->getRepository('AppBundle:Medias')->find($id);

        if (!$media) {
            throw $this->createNotFoundException('Aucun film trouvé');
        }

        $em->remove($media);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }

    /*public function getEachTypeMediasTotalAction()
    {
        $films = $this->getDoctrine()
            ->getRepository('AppBundle:Medias')
            ->findBy(array('type' => 'film'));

        $filmsTotal = count($films);
        dump($filmsTotal);

        $series = $this->getDoctrine()
            ->getRepository('AppBundle:Medias')
            ->findBy(array('type' => 'serie'));

        $seriesTotal = count($series);
        dump($seriesTotal);

        return $this->render('AppBundle::nav.html.twig', array(
            'filmsTotal' => $filmsTotal,
            'seriesTotal' => $seriesTotal
        ));
    }*/
}