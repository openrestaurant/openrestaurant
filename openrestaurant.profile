<?php
/**
 * @file
 * Enables modules and site configuration for the Open Restaurant profile.
 */

use Drupal\Core\Form\FormStateInterface;

function openrestaurant_form_install_settings_form_alter(&$form, FormStateInterface $form_state) {
  // Set some defaults for development.
  // Assume mysql driver for development.
  if (_open_restaurant_get_info('development')) {
    $database_driver = 'mysql';
    $form['settings'][$database_driver]['database']['#default_value'] = 'openrestaurantv2';
    $form['settings'][$database_driver]['username']['#default_value'] = 'root';
    $form['settings'][$database_driver]['password']['#attributes']['value'] = 'root';
  }
}

/**
 * Implements hook_form_FORM_ID_alter().
 */
function openrestaurant_form_install_configure_form_alter(&$form, FormStateInterface $form_state) {
  // Set default values for configuration.
  $form['site_information']['site_name']['#default_value'] = 'Open Restaurant';

  // Set a default email address using the HTTP_HOST.
  $default_admin_email = 'admin@' . $_SERVER['HTTP_HOST'];
  if (\Drupal::service('email.validator')->isValid($default_admin_email)) {
    $form['site_information']['site_mail']['#default_value'] = $default_admin_email;
    $form['admin_account']['account']['mail']['#default_value'] = $default_admin_email;
  }

  // Set the weight for the admin_account mail field.
  $form['admin_account']['account']['mail']['#weight'] = 20;

  // Add a description for the admin_account mail.
  $form['admin_account']['account']['mail']['#description'] = t('The email address for the administration account.');

  // Move password fields after mail.
  $form['admin_account']['account']['pass']['#weight'] = 30;

  // Add an after_build callback.
  $form['admin_account']['account']['pass']['#after_build'][] = 'openrestaurant_install_configure_form_after_build';

  // Set a default username.
  $form['admin_account']['#title'] = t('Administration account');
  $form['admin_account']['account']['name']['#default_value'] = 'admin';

  // Set default country and hide.
  $form['regional_settings']['site_default_country']['#default_value'] = 'US';
  $form['regional_settings']['date_default_timezone']['#default_value'] = 'America/Los_Angeles';
  $form['regional_settings']['#access'] = FALSE;

  // Hide Update Notifications.
  $form['update_notifications']['#access'] = FALSE;
}

/**
 * After build callback for install_configure_form.
 */
function openrestaurant_install_configure_form_after_build($form_element, FormStateInterface $form_state) {
  // Set some defaults for development.
  if (_open_restaurant_get_info('development')) {
    $form_element['pass1']['#attributes']['value'] = 'admin';
    $form_element['pass2']['#attributes']['value'] = 'admin';
  }

  return $form_element;
}

/**
 * Returns the profile info for Open Restaurant.
 */
function _open_restaurant_get_info($key = '') {
  $info_file = drupal_get_path('profile', 'openrestaurant') . '/openrestaurant.info.yml';
  if (!empty($info_file)) {
    $info = \Drupal::service('info_parser')->parse($info_file);
  }
  return (isset($key) && isset($info[$key])) ? $info[$key] : $info;
}
