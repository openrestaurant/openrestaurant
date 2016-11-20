<?php

namespace Drupal\openrestaurant_maps\Plugin\views\style;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\style\StylePluginBase;

/**
 * Style plugin to render a Snazzy Map.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "snazzymap",
 *   title = @Translation("Snazzy Map"),
 *   help = @Translation("Render a Snazzy Map."),
 *   theme = "views_view_snazzymap",
 *   display_types = { "normal" }
 * )
 *
 */
class SnazzyMap extends StylePluginBase {

  /**
   * Does the style plugin allows to use style plugins.
   *
   * @var bool
   */
  protected $usesRowPlugin = TRUE;

  /**
   * @inheritDoc
   */
  protected function defineOptions() {
    $options = parent::defineOptions();

    // Default options.
    $options['geographic_data_field'] = array('default' => '');
    $options['popup_field'] = array('default' => '');
    $options['height'] = array('default' => '400');
    $options['marker_icon_path'] = array('default' => '');
    $options['marker_icon_size_x'] = array('default' => '30');
    $options['marker_icon_size_y'] = array('default' => '40');

    return $options;
  }


  /**
   * @inheritDoc
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $fields = $this->displayHandler->getOption('fields');
    $field_options = array();
    foreach ($fields as $field => $info) {
      $field_options[$field] = $field;
    }

    // The field that holds the geographic data.
    $form['geographic_data_field'] = array(
      '#title' => $this->t('Geographic data field'),
      '#description' => $this->t('Select the field that has the geographic data.'),
      '#type' => 'select',
      '#options' => $field_options,
      '#default_value' => $this->options['geographic_data_field'],
    );

    // The field that will be used to create the marker popup.
    $form['popup_field'] = array(
      '#title' => $this->t('Popup field'),
      '#description' => $this->t('Select the field to use in the marker popup.'),
      '#type' => 'select',
      '#options' => $field_options,
      '#default_value' => $this->options['popup_field'],
    );

    // The minimum height for the map.
    $form['height'] = array(
      '#title' => $this->t('Height'),
      '#type' => 'number',
      '#field_suffix' => 'px',
      '#description' => $this->t('The minimum height of the map on large devices.'),
      '#default_value' => $this->options['height'],
    );

    // The path to the marker icon image.
    $form['marker_icon_path'] = array(
      '#title' => $this->t('Marker icon path'),
      '#type' => 'textfield',
      '#placeholder' => '/themes/',
      '#description' => $this->t('The path for the marker icon.'),
      '#default_value' => $this->options['marker_icon_path'],
    );

    // The width of the marker icon image.
    $form['marker_icon_size_x'] = array(
      '#title' => $this->t('Width'),
      '#type' => 'number',
      '#size' => 3,
      '#field_suffix' => 'px',
      '#description' => $this->t('The width of the marker icon image.'),
      '#default_value' => $this->options['marker_icon_size_x'],
    );

    // The height of the marker icon image.
    $form['marker_icon_size_y'] = array(
      '#title' => $this->t('Height'),
      '#type' => 'number',
      '#size' => 3,
      '#field_suffix' => 'px',
      '#description' => $this->t('The height of the marker icon image.'),
      '#default_value' => $this->options['marker_icon_size_y'],
    );
  }
}
