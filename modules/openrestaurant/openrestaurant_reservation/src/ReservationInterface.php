<?php

namespace Drupal\openrestaurant_reservation;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining reservation entities.
 *
 * @ingroup openrestaurant_reservation
 */
interface ReservationInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the reservation type.
   *
   * @return string
   *   The reservation type.
   */
  public function getType();

  /**
   * Gets the reservation name.
   *
   * @return string
   *   Name of the reservation.
   */
  public function getName();

  /**
   * Sets the reservation name.
   *
   * @param string $name
   *   The reservation name.
   *
   * @return \Drupal\openrestaurant_reservation\ReservationInterface
   *   The called reservation entity.
   */
  public function setName($name);

  /**
   * Gets the reservation creation timestamp.
   *
   * @return int
   *   Creation timestamp of the reservation.
   */
  public function getCreatedTime();

  /**
   * Sets the reservation creation timestamp.
   *
   * @param int $timestamp
   *   The reservation creation timestamp.
   *
   * @return \Drupal\openrestaurant_reservation\ReservationInterface
   *   The called reservation entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the reservation published status indicator.
   *
   * Unpublished reservation are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the reservation is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a reservation.
   *
   * @param bool $published
   *   TRUE to set this reservation to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\openrestaurant_reservation\ReservationInterface
   *   The called reservation entity.
   */
  public function setPublished($published);

}
