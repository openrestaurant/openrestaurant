<?php

/**
 * @file
 * Contains reservation.page.inc.
 *
 * Page callback for reservation entities.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Prepares variables for reservation templates.
 *
 * Default template: reservation.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_reservation(array &$variables) {
  // Fetch Reservation Entity Object.
  $reservation = $variables['elements']['#reservation'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}

/**
* Prepares variables for a custom entity type creation list templates.
*
* Default template: reservation-content-add-list.html.twig.
*
* @param array $variables
*   An associative array containing:
*   - content: An array of reservation-types.
*
* @see block_content_add_page()
*/
function template_preprocess_reservation_content_add_list(&$variables) {
  $variables['types'] = array();
  $query = \Drupal::request()->query->all();
  foreach ($variables['content'] as $type) {
    $variables['types'][$type->id()] = array(
      'link' => Link::fromTextAndUrl($type->label(), new Url('entity.reservation.add_form', array(
        'reservation_type' => $type->id()
      ), array('query' => $query))),
      'description' => array(
      '#markup' => $type->label(),
      ),
      'title' => $type->label(),
      'localized_options' => array(
      'query' => $query,
      ),
    );
  }
}
