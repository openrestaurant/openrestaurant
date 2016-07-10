<?php

namespace Drupal\openrestaurant_reservation\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ReservationTypeForm.
 *
 * @package Drupal\openrestaurant_reservation\Form
 */
class ReservationTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $reservation_type = $this->entity;
    $form['label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $reservation_type->label(),
      '#description' => $this->t("Label for the reservation type."),
      '#required' => TRUE,
    );

    $form['id'] = array(
      '#type' => 'machine_name',
      '#default_value' => $reservation_type->id(),
      '#machine_name' => array(
        'exists' => '\Drupal\openrestaurant_reservation\Entity\ReservationType::load',
      ),
      '#disabled' => !$reservation_type->isNew(),
    );

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $reservation_type = $this->entity;
    $status = $reservation_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label reservation type.', [
          '%label' => $reservation_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label reservation type.', [
          '%label' => $reservation_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($reservation_type->urlInfo('collection'));
  }

}
