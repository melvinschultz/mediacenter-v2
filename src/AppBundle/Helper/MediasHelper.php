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
    protected $totalMedias;

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

    public function getEachTypeMediasTotalAction()
    {
        $movies = $this->getMovies();
        $series = $this->getSeries();

        $totalMedias = array();

        if ($movies) {
            $totalMovies = count($movies);
            dump($totalMovies);

            $totalMedias = array_push($totalMovies, $totalMedias);
        }

        if ($series) {
            $totalSeries = count($series);
            dump($totalSeries);

            $totalMedias = array_push($totalSeries, $totalMedias);
        }

        return $this->totalMedias = $totalMedias;
    }
}