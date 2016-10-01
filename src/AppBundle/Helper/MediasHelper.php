<?php

namespace AppBundle\Helper;
use Doctrine\ORM\EntityManager;

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

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
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
}