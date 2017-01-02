<?php

/**
 * @file
 * Theme and preprocess functions for page.
 */

use Drupal\file\Entity\File;

/**
 * Implements template_preprocess_html().
 */
function sizzle_preprocess_html(&$variables) {
  // Add layout_width to template.
  $variables['layout']['width'] = theme_get_setting('layout_width');
}

/**
 * Implements template_preprocess_page().
 */
function sizzle_preprocess_page(&$variables) {
  $theme_path = drupal_get_path('theme', 'sizzle');

  // Default footer background image.
  $footer_bg_image = '/' . $theme_path . '/assets/images/bg/bg-footer-default.jpg';

  // Get footer background image from theme settings.
  $footer_bg_image_fid = theme_get_setting('footer_background_image');
  if (!empty($footer_bg_image_fid)) {
    $file = File::load($footer_bg_image_fid[0]);
    if (!empty($file)) {
      $footer_bg_image = $file->url();
    }
  }

  // Add the css as inline.
  $variables['#attached']['html_head'][] = [[
    '#tag' => 'style',
    '#value' => 'footer { background-image: url(' . $footer_bg_image . '); }',
  ], 'sizzle_css'];
}
