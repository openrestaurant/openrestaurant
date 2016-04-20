<?php
/**
 * @file
 * Theme and preprocess functions for menus and navs.
 */

/**
 * Implements template_preprocess_taxonomy_term_TYPE().
 */
function sizzle_preprocess_taxonomy_term_menu_categories(&$variables) {
  $term = $variables['term'];

  // Create an anchor for the menu category.
  $machine_name = drupal_html_class($term->name);
  $variables['term_machine_name'] = $machine_name;
  $variables['term_url'] = url('menus', array('fragment' => $machine_name));
}

/**
 * Implements template_preprocess_node_TYPE().
 */
function sizzle_preprocess_node_menu(&$variables) {
  $node = $variables['node'];
  $metadata = entity_metadata_wrapper('node', $node);

  // Add the featured ribbon.
  if (!empty($node->field_menu_featured)) {
    if ($metadata->field_menu_featured->value()) {
      $variables['classes_array'][] = 'node--menu--featured';
      $variables['content']['featured'] = array(
        '#markup' => '<span class="ribbon ribbon--primary">' . t('Featured') . '</span>',
      );
    }
  }
}

/**
 * Implements template_preprocess_views_view__content().
 */
function sizzle_preprocess_views_view__content__menus__all_menus(&$variables) {
  $view = $variables['view'];

  // Add custom class to h3.
  $variables['group_attributes']['class'] = 'ribbon ribbon--secondary';

  // Render the Menu category on top of the rows.
  $variables['term'] = '';
  if (count($variables['rows'])) {
    // Get the current view mode.
    $view_mode = isset($view->style_plugin->row_plugin->options['view_mode']) ? $view->style_plugin->row_plugin->options['view_mode'] : 'grid';
    $bundles = entity_view_mode_get_enabled_bundles('taxonomy_term', $view_mode);

    // Get the first result.
    $results = $view->result;
    reset($variables['rows']);
    $first_row = key($variables['rows']);
    $result = $results[$first_row];

    // Determine the col size based on the view mode.
    $rendered_view_mode = $view->field['rendered_entity']->options['view_mode'];
    $variables['col_size'] = ($rendered_view_mode == 'grid') ? 4 : 12;

    // Check if this vocabulary has the required view mode.
    if (!empty($result->taxonomy_term_data_node__taxonomy_vocabulary_machine_name) && !empty($bundles[$result->taxonomy_term_data_node__taxonomy_vocabulary_machine_name])) {
      // Get the menu category for this result.
      $term = taxonomy_term_load($result->taxonomy_term_data_node_tid);

      // Render the category and add it to template.
      $term_view = taxonomy_term_view($term, $view_mode);
      $variables['term'] = drupal_render($term_view);
    }
  }
}
