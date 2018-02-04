<?php

namespace Drupal\program\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Program entities.
 */
class ProgramViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
