<?php
/**
 * @file
 * Enables modules and site configuration for the Open Restaurant profile.
 */

use Drupal\Core\Form\FormStateInterface;

/**
 * Implements hook_form_FORM_ID_alter().
 */
function openrestaurant_form_install_select_language_form_alter(&$form, FormStateInterface $form_state) {
  // Make sure user knows this is the administration language and not the site language.
  $form['langcode']['#description'] = t('Select the language for the site administration.');

  // Add note about adding languages.
  $form['note'] = [
    '#type' => 'html_tag',
    '#tag' => 'small',
    '#value' => t('You can add more languages and translate your site after installation.'),
  ];
}

/**
 * Implements hook_form_FORM_ID_alter().
 */
function openrestaurant_form_install_settings_form_alter(&$form, FormStateInterface $form_state) {
  // Set some defaults for the environment.
  $environment = _openrestaurant_get_environment();
  if (!empty($environment)) {
    if (isset($environment['database'])) {
      $database_driver = $environment['database']['driver'];
      $form['settings'][$database_driver]['database']['#default_value'] = $environment['database']['database'];
      $form['settings'][$database_driver]['username']['#default_value'] = $environment['database']['username'];
      $form['settings'][$database_driver]['password']['#attributes']['value'] = $environment['database']['password'];
      $form['settings'][$database_driver]['advanced_options']['host']['#default_value'] = $environment['database']['host'];
      $form['settings'][$database_driver]['advanced_options']['port']['#default_value'] = $environment['database']['port'];
    }
  }
}

/**
 * Implements hook_form_FORM_ID_alter().
 */
function openrestaurant_form_install_configure_form_alter(&$form, FormStateInterface $form_state) {
  $environment = _openrestaurant_get_environment();

  // Set default values for configuration.
  $form['site_information']['site_name']['#default_value'] = 'Open Restaurant';

  // Set a default email address.
  if (isset($environment['admin'])) {
    $form['site_information']['site_mail']['#default_value'] = $environment['admin']['email'];
    $form['admin_account']['account']['mail']['#default_value'] = $environment['admin']['email'];
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

  // Set some defaults for the environment.
  if (isset($environment['admin'])) {
    $form['admin_account']['account']['name']['#default_value'] = $environment['admin']['username'];
  }
  
  // Set some defaults for the environment.
  if (isset($environment['regional'])) {
    $form['regional_settings']['site_default_country']['#default_value'] = $environment['regional']['country'];
    $form['regional_settings']['date_default_timezone']['#default_value'] = $environment['regional']['timezone'];
  }

  $form['regional_settings']['#access'] = FALSE;

  // Hide Update Notifications.
  $form['update_notifications']['#access'] = FALSE;
}

/**
 * After build callback for install_configure_form.
 */
function openrestaurant_install_configure_form_after_build($form_element, FormStateInterface $form_state) {
  $environment = _openrestaurant_get_environment();

  // Set some defaults for the environment.
  if (isset($environment['admin'])) {
    $form_element['pass1']['#attributes']['value'] = $environment['admin']['password'];
    $form_element['pass2']['#attributes']['value'] = $environment['admin']['password'];
  }

  return $form_element;
}

/**
 * Returns the profile info for Open Restaurant.
 */
function _openrestaurant_get_info($key = '') {
  $info_file = drupal_get_path('profile', 'openrestaurant') . '/openrestaurant.info.yml';
  if (!empty($info_file)) {
    $info = \Drupal::service('info_parser')->parse($info_file);
  }
  return (isset($key) && isset($info[$key])) ? $info[$key] : $info;
}

/**
 * Returns the environment values set in openrestaurant.info.yml.
 */
function _openrestaurant_get_environment() {
  $environment = _openrestaurant_get_info('environment');
  return _openrestaurant_get_info($environment);
}
