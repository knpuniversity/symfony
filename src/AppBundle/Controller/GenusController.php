<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class GenusController
{
    /**
     * @Route("/genus/{genusName2}")
     */
    public function showAction($genusName)
    {
        return new Response('The genus: '.$genusName);
    }
}
