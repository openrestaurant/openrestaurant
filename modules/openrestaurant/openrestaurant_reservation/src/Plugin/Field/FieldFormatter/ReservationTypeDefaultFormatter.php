<?php

namespace Drupal\openrestaurant_reservation\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'reservation_type_default' formatter.
 *
 * @FieldFormatter(
 *   id = "reservation_type_default",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "reservation_type_field"
 *   }
 * )
 */
class ReservationTypeDefaultFormatter extends FormatterBase implements ContainerFactoryPluginInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The entity form builder.
   *
   * @var \Drupal\Core\Entity\EntityFormBuilderInterface
   */
  protected $entityFormBuilder;


  /**
   * @inheritDoc
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, $entityTypeManager, $entityFormBuilder) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->entityTypeManager = $entityTypeManager;
    $this->entityFormBuilder = $entityFormBuilder;
  }


  /**
   * @inheritDoc
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('entity_type.manager'),
      $container->get('entity.form_builder')
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      // Implement default settings.
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    return array(
      // Implement settings form.
    ) + parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    // Implement settings summary.

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $reservation_type = $this->viewValue($item);

      // Get the entity form for the reservation type.
      $reservation = $this->entityTypeManager->getStorage('reservation')->create(array(
        'type' => $reservation_type,
      ));
      $form = $this->entityFormBuilder->getForm($reservation);

      // Render the form.
      $elements[$delta] = array(
        '#markup' => render($form)
      );
    }

    return $elements;
  }

  /**
   * Generate the output appropriate for one field item.
   *
   * @param \Drupal\Core\Field\FieldItemInterface $item
   *   One field item.
   *
   * @return string
   *   The textual output generated.
   */
  protected function viewValue(FieldItemInterface $item) {
    // The text value has no text format assigned to it, so the user input
    // should equal the output, including newlines.
    return nl2br(Html::escape($item->value));
  }
}
