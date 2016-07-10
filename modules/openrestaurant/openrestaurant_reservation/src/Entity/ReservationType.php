<?php

namespace Drupal\openrestaurant_reservation\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;
use Drupal\openrestaurant_reservation\ReservationTypeInterface;

/**
 * Defines the reservation type entity.
 *
 * @ConfigEntityType(
 *   id = "reservation_type",
 *   label = @Translation("reservation type"),
 *   handlers = {
 *     "list_builder" = "Drupal\openrestaurant_reservation\ReservationTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\openrestaurant_reservation\Form\ReservationTypeForm",
 *       "edit" = "Drupal\openrestaurant_reservation\Form\ReservationTypeForm",
 *       "delete" = "Drupal\openrestaurant_reservation\Form\ReservationTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\openrestaurant_reservation\ReservationTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "reservation_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "reservation",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/reservation_type/{reservation_type}",
 *     "add-form" = "/admin/structure/reservation_type/add",
 *     "edit-form" = "/admin/structure/reservation_type/{reservation_type}/edit",
 *     "delete-form" = "/admin/structure/reservation_type/{reservation_type}/delete",
 *     "collection" = "/admin/structure/reservation_type"
 *   }
 * )
 */
class ReservationType extends ConfigEntityBundleBase implements ReservationTypeInterface {

  /**
   * The reservation type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The reservation type label.
   *
   * @var string
   */
  protected $label;

}
