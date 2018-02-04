<?php

/**
 * @file
 * Contains program.page.inc.
 *
 * Page callback for Program entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Program templates.
 *
 * Default template: program.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_program(array &$variables) {
  // Fetch Program Entity Object.
  $program = $variables['elements']['#program'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
