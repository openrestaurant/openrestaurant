<?php

/**
 * @file
 * Theme and preprocess functions for page.
 */

use Drupal\file\Entity\File;

/**
 * Implements template_preprocess_page().
 */
function sizzle_preprocess_page(&$variables) {
  $theme_path = drupal_get_path('theme', 'sizzle');

  // Default footer background image.
  $footer_bg_image = '/' . $theme_path . '/assets/images/bg/bg-footer-default.jpg';

  // Get footer background image from theme settings.
  $footer_bg_image_fid = theme_get_setting('features.footer_background_image');
  if (count($footer_bg_image_fid)) {
    $file = File::load($footer_bg_image_fid[0]);
    if (!empty($file)) {
      $footer_bg_image = $file->url();
    }
  }

  // Add the footer background image to template..
  $variables['footer']['background_image'] = $footer_bg_image;
}
