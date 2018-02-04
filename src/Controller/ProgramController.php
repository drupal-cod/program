<?php

namespace Drupal\program\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\program\Entity\ProgramInterface;

/**
 * Class ProgramController.
 *
 *  Returns responses for Program routes.
 */
class ProgramController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Program  revision.
   *
   * @param int $program_revision
   *   The Program  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($program_revision) {
    $program = $this->entityManager()->getStorage('program')->loadRevision($program_revision);
    $view_builder = $this->entityManager()->getViewBuilder('program');

    return $view_builder->view($program);
  }

  /**
   * Page title callback for a Program  revision.
   *
   * @param int $program_revision
   *   The Program  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($program_revision) {
    $program = $this->entityManager()->getStorage('program')->loadRevision($program_revision);
    return $this->t('Revision of %title from %date', ['%title' => $program->label(), '%date' => format_date($program->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Program .
   *
   * @param \Drupal\program\Entity\ProgramInterface $program
   *   A Program  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(ProgramInterface $program) {
    $account = $this->currentUser();
    $langcode = $program->language()->getId();
    $langname = $program->language()->getName();
    $languages = $program->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $program_storage = $this->entityManager()->getStorage('program');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $program->label()]) : $this->t('Revisions for %title', ['%title' => $program->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all program revisions") || $account->hasPermission('administer program entities')));
    $delete_permission = (($account->hasPermission("delete all program revisions") || $account->hasPermission('administer program entities')));

    $rows = [];

    $vids = $program_storage->revisionIds($program);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\program\ProgramInterface $revision */
      $revision = $program_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $program->getRevisionId()) {
          $link = $this->l($date, new Url('entity.program.revision', ['program' => $program->id(), 'program_revision' => $vid]));
        }
        else {
          $link = $program->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.program.translation_revert', ['program' => $program->id(), 'program_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.program.revision_revert', ['program' => $program->id(), 'program_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.program.revision_delete', ['program' => $program->id(), 'program_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['program_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
