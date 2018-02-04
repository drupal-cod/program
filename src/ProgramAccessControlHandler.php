<?php

namespace Drupal\program;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Program entity.
 *
 * @see \Drupal\program\Entity\Program.
 */
class ProgramAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\program\Entity\ProgramInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished program entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published program entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit program entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete program entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add program entities');
  }

}
