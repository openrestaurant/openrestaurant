<?php
/**
 * @file
 * Theme and preprocess functions for nodes.
 */

/**
 * Implements template_preprocess_node().
 */
function sizzle_preprocess_node(&$variables) {
  $node = $variables['node'];

  // Allow bundle type preprocess callbacks.
  $function = __FUNCTION__ . '__' . $node->bundle();
  if (function_exists($function)) {
    $function($variables);
  }
}

/**
 * Implements template_preprocess_node__TYPE().
 */
function sizzle_preprocess_node__event(&$variables) {
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
