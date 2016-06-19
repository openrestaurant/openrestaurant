<?php

/**
 * @file
 * Theme and preprocess functions for view.
 */

use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Implements hook_preprocess_views_view().
 */
function sizzle_preprocess_views_view(&$variables) {
  $view = $variables['view'];

  // Allow preprocess callbacks per view name.
  $function = __FUNCTION__ . '__' . $view->id();
  if (function_exists($function)) {
    $function($variables, $view);
  }
}

/**
 * Implements hook_preprocess_views_view__NAME().
 */
function sizzle_preprocess_views_view__menu_categories(&$variables, $view) {
  // Add an 'All' link to the menu_categories view.
  $first_element = $variables['rows'][0]['#rows'][0];
  if (!$first_element instanceof Link) {
    $url = Url::fromUserInput('/menu');
    $link = Link::fromTextAndUrl(t('All'), $url);
    array_unshift($variables['rows'][0]['#rows'], $link);
  }
}
