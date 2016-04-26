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
  // Add the footer background image as footer style.
  $footer_bg_image_fid = theme_get_setting('features.footer_background_image');
  if (count($footer_bg_image_fid)) {
    $footer_bg_image = (File::load($footer_bg_image_fid[0]))->url();
  }
  else {
    $footer_bg_image = drupal_get_path('theme', 'sizzle') . '/assets/images/bg/bg-footer-default.jpg';
  }
  $variables['footer']['background_image'] = $footer_bg_image;
}
