<?php

namespace Drupal\openrestaurant_admin\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RoutingSubscriber
 *
 * @package Drupal\openrestaurant_admin
 */
class RouteSubscriber extends RouteSubscriberBase {

  public function alterRoutes(RouteCollection $collection) {
    if ($route = $collection->get('eck.entity_type.list')) {
      $route->setDefault('_title', 'Entity types');
    }
  }
}
