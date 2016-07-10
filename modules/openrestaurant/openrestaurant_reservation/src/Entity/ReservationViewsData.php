<?php

namespace Drupal\openrestaurant_reservation\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for reservation entities.
 */
class ReservationViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['reservation']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('reservation'),
      'help' => $this->t('The reservation ID.'),
    );

    return $data;
  }

}
