<?php

function template_preprocess_snazzymaps_results(&$variables) {
  count($variables);
}

/**
 * Preprocess hook for snazzymap.
 */
function template_preprocess_views_view_snazzymap(&$variables) {
  $view = $variables['view'];
  $handler = $view->style_plugin;
  $options = $view->style_plugin->options;
  $geographic_field_name = $options['geographic_data_field'];
  $popup_field_name = $options['popup_field'];

  // Set the default height.
  $variables['height'] = $options['height'] . 'px';

  // Prepare rows as markers.
  $markers = array();
  foreach ($variables['rows'] as $id => $row) {
    // Get the geographic data for this row.
    $entity = $row['#row']->_entity;
    $geographic_data = $entity->{$geographic_field_name}->value;

    if ($geographic_data) {
      if ($point = geoPHP::load($geographic_data)) {
        $markers[] = array(
          'lat' => $point->getY(),
          'lon' => $point->getX(),
          'popup' => $handler->getField($id, $popup_field_name),
        );
      }
    }
  }
  $variables['#attached']['drupalSettings']['SnazzyMap']['markers'] = $markers;

  // Add custom icon for marker.
  $variables['#attached']['drupalSettings']['SnazzyMap']['icon'] = array(
    'url' => $options['marker_icon_path'],
    'size' => array(
      'x' => (int) $options['marker_icon_size_x'],
      'y' => (int) $options['marker_icon_size_y'],
    ),
  );
}
