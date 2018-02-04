<?php

namespace Drupal\program;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\program\Entity\ProgramInterface;

/**
 * Defines the storage handler class for Program entities.
 *
 * This extends the base storage class, adding required special handling for
 * Program entities.
 *
 * @ingroup program
 */
class ProgramStorage extends SqlContentEntityStorage implements ProgramStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(ProgramInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {program_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {program_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(ProgramInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {program_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('program_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
