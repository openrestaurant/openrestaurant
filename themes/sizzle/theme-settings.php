<?php

/**
 * @file
 * Settings for Sizzle theme.
 */

use Drupal\file\Entity\File;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements hook_form_system_theme_settings_alter().
 */
function sizzle_form_system_theme_settings_alter(&$form, FormStateInterface &$form_state, $form_id = NULL) {
  // Work-around for a core bug affecting admin themes. See issue #943212.
  if (isset($form_id)) {
    return;
  }

  // Hide extra theme settings.
  $form['theme_settings']['#access'] = FALSE;

  // Add layout settings.
  $form['layout_settings'] = [
    '#type' => 'details',
    '#title' => t('Layout settings'),
    '#open' => TRUE,
  ];

  $form['layout_settings']['layout_width'] = [
    '#title' => t('Width'),
    '#type' => 'radios',
    '#options' => [
      'boxed' => t('Boxed'),
      'full' => t('Full width'),
    ],
    '#default_value' => theme_get_setting('layout_width'),
  ];

  // Add footer settings.
  $form['footer_settings'] = [
    '#type' => 'details',
    '#title' => t('Footer settings'),
    '#open' => TRUE,
  ];

  $form['footer_settings']['footer_background_image'] = [
    '#title' => t('Background image'),
    '#type' => 'managed_file',
    '#description' => t('The background image for the footer.'),
    '#upload_location' => 'public://',
    '#default_value' => theme_get_setting('footer_background_image') ?? NULL,
    '#upload_validators' => array(
      'file_validate_extensions' => array('png jpg jpeg'),
    ),
  ];

  $form['#submit'][] = 'sizzle_form_system_theme_settings_submit';
}

/**
 * Submit handler for theme settings form.
 */
function sizzle_form_system_theme_settings_submit(array &$form, FormStateInterface $form_state) {
  // Set file status to permanent.
  $fid = $form_state->getValue('footer_background_image');
  if (count($fid)) {
    $file = File::load($fid[0]);
    $file->status = FILE_STATUS_PERMANENT;
    $file->save();
  }
}
