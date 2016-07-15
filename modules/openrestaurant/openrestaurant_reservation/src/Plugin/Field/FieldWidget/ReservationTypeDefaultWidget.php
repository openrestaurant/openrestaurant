<?php

namespace Drupal\openrestaurant_reservation\Plugin\Field\FieldWidget;

use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'reservation type' widget.
 *
 * @FieldWidget(
 *   id = "reservation_type_default",
 *   label = @Translation("Reservation type"),
 *   field_types = {
 *     "reservation_type_field"
 *   }
 * )
 */
class ReservationTypeDefaultWidget extends WidgetBase implements ContainerFactoryPluginInterface  {

  /**
   * The entity type bundle info.
   *
   * @var \Drupal\Core\Entity\EntityTypeBundleInfoInterface
   */
  protected $entityTypeBundleInfo;

  /**
   * Constructs a ReservationTypeDefaultWidget object.
   *
   * @param array $plugin_id
   *   The plugin_id for the widget.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The definition of the field to which the widget is associated.
   * @param array $settings
   *   The widget settings.
   * @param array $third_party_settings
   *   Any third party settings.
   * @param \Drupal\Core\Entity\EntityTypeBundleInfoInterface $entity_type_bundle_info
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, array $third_party_settings, EntityTypeBundleInfoInterface $entity_type_bundle_info) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $third_party_settings);

    $this->entityTypeBundleInfo = $entity_type_bundle_info;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['third_party_settings'],
      $container->get('entity_type.bundle.info')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['value'] = $element + array(
      '#type' => 'select',
      '#options' => $this->getReservationTypesOptions(),
      '#default_value' => isset($items[$delta]->value) ? $items[$delta]->value : NULL,
    );

    return $element;
  }

  /**
   * Returns an array of reservation bundle options.
   *
   * @return array
   */
  public function getReservationTypesOptions() {
    $options = array();

    $bundles = $this->entityTypeBundleInfo->getBundleInfo('reservation');
    foreach ($bundles as $name => $bundle) {
      $options[$name] = $bundle['label'];
    }

    return $options;
  }
}
