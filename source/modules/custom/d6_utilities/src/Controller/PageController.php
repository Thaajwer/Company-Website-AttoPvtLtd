<?php
/**
 * @file
 * Contains \Drupal\momentum_utils\Controller\SessionsPagesController.
 */

namespace Drupal\d6_utilities\Controller;

use Drupal\Core\Controller\ControllerBase;
Use Drupal\Core\Datetime;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Drupal\taxonomy\Entity\Term;

/**
 * Class SessionsPagesController
 * @package Drupal\momentum_utils\Controller
 */
class PageController extends ControllerBase {

   public function __construct(){}

    /**
     * {@inheritdoc}
     */
    public function default_contents() {
               $build = [];
        return $build;
    }
}
?>


