<?php

namespace Drupal\openrestaurant_reservation\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for reservation edit forms.
 *
 * @ingroup openrestaurant_reservation
 */
class ReservationForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\openrestaurant_reservation\Entity\Reservation */
    $form = parent::buildForm($form, $form_state);
    $entity = $this->entity;

    // Change value for submit button.
    $form['actions']['submit']['#value'] = $this->t('Submit reservation');

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label reservation.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label reservation.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.reservation.canonical', ['reservation' => $entity->id()]);
  }

}
