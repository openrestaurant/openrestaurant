<?php
/**
 * @file
 * Theme and preprocess functions for entities.
 */

/**
 * Implements template_preprocess_entity().
 */
function sizzle_preprocess_entity(&$variables) {
  // Allow bundle type preprocess callbacks.
  $function = __FUNCTION__ . '_' . $variables['elements']['#bundle'];
  if (function_exists($function)) {
    $function($variables);
  }
}
