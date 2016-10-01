<?php

namespace AppBundle\Helper;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;

/**
 * Created by PhpStorm.
 * User: melvin
 * Date: 01/10/16
 * Time: 11:22
 */
class MediasHelper
{
    protected $em;
    protected $isExist;
    protected $movies;
    protected $series;

    public function __construct(EntityManager $em, Translator $translator)
    {
        $this->em = $em;
        $this->translator = $translator;
    }

    public function testIfMediaAlreadyExist($nomNewMedia)
    {
        $media = $this->em->getRepository('AppBundle:Medias')->findBy(array('nom' => $nomNewMedia));

        if ($media) {
            $isExist = true;
        }
        else {
            $isExist = false;
        }

        return $this->isExist = $isExist;
    }

    public function getMovies()
    {
        $movies = $this->em->getRepository('AppBundle:Medias')->findBy(array('type' => 'film'));

        if (!$movies) {
            $errorMsg = $this->translator->trans('medias.no_movie');
            throw new \Exception($errorMsg);
        }

        return $this->movies = $movies;
    }

    public function getSeries()
    {
        $series = $this->em->getRepository('AppBundle:Medias')->findBy(array('type' => 'serie'));

        if (!$series) {
            $errorMsg = $this->translator->trans('medias.no_tv_show');
            throw new \Exception($errorMsg);
        }

        return $this->series = $series;
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