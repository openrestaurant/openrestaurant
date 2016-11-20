<?php

namespace Drupal\snazzymaps\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class SnazzyMapsSettingsForm extends ConfigFormBase {
  /**
   * @inheritDoc
   */
  public function getFormId() {
    return 'snazzymaps_settings_form';
  }

  /**
   * @inheritDoc
   */
  protected function getEditableConfigNames() {
    return ['snazzymaps.settings'];
  }

  /**
   * @inheritDoc
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('snazzymaps.settings');

    // Display a help mesage.
    $form['api_key_help'] = array(
      '#markup' => '<p>' . $this->t('If you have a <a href="@url">Snazzy Maps</a> account you can access your favorites and private styles from within the module. Sign up for an <a href="@api_key_url">API Key</a> and paste it into the text box below to access these styles.', array(
          '@url' => 'https://snazzymaps.com',
          '@api_key_url' => 'https://snazzymaps.com/account/developer',
        )) . '</p>',
    );

    // The API Key.
    $form['api_key'] = array(
      '#title' => $this->t('API Key'),
      '#type' => 'textfield',
      '#description' => $this->t('Enter your API key here.'),
      '#default_value' => $config->get('api_key'),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * @inheritDoc
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Save config.
    $config = $this->config('snazzymaps.settings');
    $config
      ->set('api_key', $form_state->getValue('api_key'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}
