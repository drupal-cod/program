<?php

namespace Drupal\program\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Program entities.
 *
 * @ingroup program
 */
interface ProgramInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Program name.
   *
   * @return string
   *   Name of the Program.
   */
  public function getName();

  /**
   * Sets the Program name.
   *
   * @param string $name
   *   The Program name.
   *
   * @return \Drupal\program\Entity\ProgramInterface
   *   The called Program entity.
   */
  public function setName($name);

  /**
   * Gets the Program creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Program.
   */
  public function getCreatedTime();

  /**
   * Sets the Program creation timestamp.
   *
   * @param int $timestamp
   *   The Program creation timestamp.
   *
   * @return \Drupal\program\Entity\ProgramInterface
   *   The called Program entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Program published status indicator.
   *
   * Unpublished Program are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Program is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Program.
   *
   * @param bool $published
   *   TRUE to set this Program to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\program\Entity\ProgramInterface
   *   The called Program entity.
   */
  public function setPublished($published);

  /**
   * Gets the Program revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Program revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\program\Entity\ProgramInterface
   *   The called Program entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Program revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Program revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\program\Entity\ProgramInterface
   *   The called Program entity.
   */
  public function setRevisionUserId($uid);

}
