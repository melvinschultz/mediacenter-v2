<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Medias;
use AppBundle\Form\MediasType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MediaController extends Controller
{
    protected $isExist;

    /**
     * @Route("/add", name="add")
     *
     * @param Request $request
     * @return Response
     * @throws \Exception
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
                $mediasHelper = $this->container->get('mediacenter.medias_helper');

                $nomNewMedia = $form->get('nom')->getNormData();

                $isExist = $mediasHelper->testIfMediaAlreadyExist($nomNewMedia);

                if ($isExist) {
                    $errorMsg = $this->get('translator')->trans('medias.form.is_exist');
                    throw new \Exception($errorMsg);
                }
                else {
                    $image = $media->getImage();

                    $imageNom = strtolower(str_replace(' ', '_', $media->getNom())).'_'.substr(md5(uniqid(rand(0,9))), 0,8).'.'.$image->guessExtension();
                    $image->move($this->container->getParameter('uploads_directory'), $imageNom);

                    $media->setImage($imageNom);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($media);
                    $em->flush();
                }
            }
        }

        // On passe la méthode createView() du formulaire à la vue
        // afin qu'elle puisse afficher le formulaire toute seule
        return $this->render('AppBundle:medias:add-media.html.twig', array('form' => $form->createView(),));
    }

    /**
     * @Route("/movie/{id}/update", name="update_movie")
     * @Route("/serie/{id}/update", name="update_serie")
     *
     * @param $request
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $media = $em->getRepository('AppBundle:Medias')->find($id);

        if (!$media) {
            throw $this->createNotFoundException(
                'No media found for id '.$id
            );
        }

        $mediaNom = $media->getNom();

        $form = $this->createForm(new MediasType(), $media);

        dump($form);

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

        return $this->render('AppBundle:medias:update-media.html.twig', array(
            'form' => $form->createView(),
            'nom' => $mediaNom
        ));
    }

    /**
     * @Route("/medias", name="medias")
     * @Route("/movies", name="movies")
     * @Route("/series", name="series")
     *
     * @param Request $request
     *
     * @return Response
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
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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