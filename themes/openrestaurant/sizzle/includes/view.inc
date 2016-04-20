<?php
/**
 * @file
 * Theme and preprocess functions for views
 */

function sizzle_form_views_exposed_form_alter(&$form, $form_state) {
  foreach ($form['#info'] as $info) {
    $title = $info['label'];
    $name = $info['value'];
    if (isset($form[$name])) {
      $form[$name]['#attributes']['placeholder'] = $title;
    }
  }
}
