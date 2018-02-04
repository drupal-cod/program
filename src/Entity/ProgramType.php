<?php

namespace Drupal\program\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Program type entity.
 *
 * @ConfigEntityType(
 *   id = "program_type",
 *   label = @Translation("Program type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\program\ProgramTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\program\Form\ProgramTypeForm",
 *       "edit" = "Drupal\program\Form\ProgramTypeForm",
 *       "delete" = "Drupal\program\Form\ProgramTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\program\ProgramTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "program_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "program",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/program_type/{program_type}",
 *     "add-form" = "/admin/structure/program_type/add",
 *     "edit-form" = "/admin/structure/program_type/{program_type}/edit",
 *     "delete-form" = "/admin/structure/program_type/{program_type}/delete",
 *     "collection" = "/admin/structure/program_type"
 *   }
 * )
 */
class ProgramType extends ConfigEntityBundleBase implements ProgramTypeInterface {

  /**
   * The Program type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Program type label.
   *
   * @var string
   */
  protected $label;

}
