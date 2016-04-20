<?php
/**
 * @file
 * Theme and preprocess functions for nodes.
 */

/**
 * Implements template_preprocess_node_blog_post().
 */
function sizzle_preprocess_node_blog_post(&$variables) {
  $node = $variables['node'];

  // Format and add date to template.
  $variables['content']['posted_date'] = array(
    '#markup' => format_date($node->created, 'panopoly_day'),
  );
}

/**
 * Implements template_preprocess_node_event().
 */
function sizzle_preprocess_node_event(&$variables) {
  $node = $variables['node'];

  // Format and add date to template.
  $variables['content']['posted_date'] = array(
    '#markup' => format_date($node->created, 'panopoly_day'),
  );

  switch ($variables['view_mode']) {
    case 'featured':
      // Hide the street block
      if (isset($variables['field_event_location'][0]['street_block']['#access'])) {
        $variables['field_event_location'][0]['street_block']['#access'] = FALSE;
      }

      // Hide the country.
      if (isset($variables['field_event_location'][0]['country']['#access'])) {
        $variables['field_event_location'][0]['country']['#access'] = FALSE;
      }
      break;
  }
}

/**
 * Implements template_preprocess_node_location().
 */
function sizzle_preprocess_node_location(&$variables) {
  $node = $variables['node'];

  // Format and add date to template.
  $variables['content']['more_link'] = array(
    '#theme' => 'link',
    '#text' => t('Read More'),
    '#path' => 'node/' . $node->nid,
    '#options' => array(
      'attributes' => array(
        'class' => array('btn', 'btn--xs'),
      ),
    )
  );

  $variables['content']['menu_link'] = array(
    '#theme' => 'link',
    '#text' => t('See Menu'),
    '#path' => 'menus',
    '#options' => array(
      'query' => array('location[]' => $node->nid),
      'attributes' => array(
        'class' => array('btn', 'btn--secondary', 'btn--xs'),
      ),
    )
  );
}
