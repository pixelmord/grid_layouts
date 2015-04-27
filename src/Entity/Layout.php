<?php

/**
 * @file
 * Contains Drupal\grid_layouts\Entity\Layout.
 */

namespace Drupal\grid_layouts\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\grid_layouts\LayoutInterface;

/**
 * Defines the Layout entity.
 *
 * @ConfigEntityType(
 *   id = "layout",
 *   label = @Translation("Layout"),
 *   handlers = {
 *     "list_builder" = "Drupal\grid_layouts\Controller\LayoutListBuilder",
 *     "form" = {
 *       "add" = "Drupal\grid_layouts\Form\LayoutForm",
 *       "edit" = "Drupal\grid_layouts\Form\LayoutForm",
 *       "delete" = "Drupal\grid_layouts\Form\LayoutDeleteForm"
 *     }
 *   },
 *   config_prefix = "layout",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "edit-form" = "entity.layout.edit_form",
 *     "delete-form" = "entity.layout.delete_form",
 *     "collection" = "entity.layout.collection"
 *   }
 * )
 */
class Layout extends ConfigEntityBase implements LayoutInterface {
  /**
   * The Layout ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Layout label.
   *
   * @var string
   */
  protected $label;

}
