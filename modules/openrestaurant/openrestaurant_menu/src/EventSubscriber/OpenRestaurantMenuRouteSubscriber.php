<?php

/**
 * @file
 * Contains \Drupal\openrestaurant_menu\EventSubscriber\OpenRestaurantMenuRouteSubscriber.
 */

namespace Drupal\openrestaurant_menu\EventSubscriber;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * OpenRestaurantMenuRouteSubscriber.
 */
class OpenRestaurantMenuRouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    // Update title for the entity.menu.collection route.
    $route = $collection->get('entity.menu.collection');
    $route->setDefault('_title', 'Navigation');
  }
}