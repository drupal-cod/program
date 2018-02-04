<?php

namespace Drupal\program;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface ProgramStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Program revision IDs for a specific Program.
   *
   * @param \Drupal\program\Entity\ProgramInterface $entity
   *   The Program entity.
   *
   * @return int[]
   *   Program revision IDs (in ascending order).
   */
  public function revisionIds(ProgramInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Program author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Program revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\program\Entity\ProgramInterface $entity
   *   The Program entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(ProgramInterface $entity);

  /**
   * Unsets the language for all Program with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
