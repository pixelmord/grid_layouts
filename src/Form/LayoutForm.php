<?php

/**
 * @file
 * Contains Drupal\grid_layouts\Form\LayoutForm.
 */

namespace Drupal\grid_layouts\Form;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class LayoutForm.
 *
 * @package Drupal\grid_layouts\Form
 */
class LayoutForm extends EntityForm {
  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $layout = $this->entity;
    $form['label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $layout->label(),
      '#description' => $this->t("Label for the Layout."),
      '#required' => TRUE,
    );

    $form['id'] = array(
      '#type' => 'machine_name',
      '#default_value' => $layout->id(),
      '#machine_name' => array(
        'exists' => '\Drupal\grid_layouts\Entity\Layout::load',
      ),
      '#disabled' => !$layout->isNew(),
    );

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $layout = $this->entity;
    $status = $layout->save();

    if ($status) {
      drupal_set_message($this->t('Saved the %label Layout.', array(
        '%label' => $layout->label(),
      )));
    }
    else {
      drupal_set_message($this->t('The %label Layout was not saved.', array(
        '%label' => $layout->label(),
      )));
    }
    $form_state->setRedirectUrl($layout->urlInfo('collection'));
  }

}
