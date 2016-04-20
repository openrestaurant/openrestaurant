<?php
/**
 * @file
 * Theme and preprocess functions for fields.
 */

/**
 * Implements template_preprocess_field_NAME().
 */
function sizzle_preprocess_field_commerce_price(&$variables) {
  // Render the decimal part of price as superscript.
  foreach ($variables['items'] as $key => $item) {
    $price = $item['#markup'];
    $price_components = explode('.', $price);
    $decimal = array_pop($price_components);
    $variables['items'][$key]['#markup'] = implode('', $price_components) . '<sup>.' . $decimal . '</sup>';
  }
}
