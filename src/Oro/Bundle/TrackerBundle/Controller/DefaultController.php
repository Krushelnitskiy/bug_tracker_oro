<?php

namespace Oro\Bundle\TrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class DefaultController
 * @package Oro\Bundle\TrackerBundle\Controller
 * @Route("/tracker")
 */
class DefaultController extends Controller
{
    /**
     * @Route(
     *      "/",
     *      name="oro_tracker_index",
     * )
     * @Template
     */
    public function indexAction()
    {
        return $this->render('OroTrackerBundle:Default:index.html.twig', array('name' => 111));
    }
}
