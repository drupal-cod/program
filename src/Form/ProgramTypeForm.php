<?php

namespace Drupal\program\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ProgramTypeForm.
 */
class ProgramTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $program_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $program_type->label(),
      '#description' => $this->t("Label for the Program type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $program_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\program\Entity\ProgramType::load',
      ],
      '#disabled' => !$program_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $program_type = $this->entity;
    $status = $program_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Program type.', [
          '%label' => $program_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Program type.', [
          '%label' => $program_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($program_type->toUrl('collection'));
  }

}
