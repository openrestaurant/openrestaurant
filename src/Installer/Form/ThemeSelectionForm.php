<?php

namespace Drupal\openrestaurant\Installer\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides the site configuration form.
 */
class ThemeSelectionForm extends ConfigFormBase {

  /**
   * @inheritDoc
   */
  public function getFormId() {
    return 'install_theme_selection_form';
  }

  /**
   * @inheritDoc
   */
  protected function getEditableConfigNames() {
    return [
      'system.theme.default'
    ];
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#title'] = t('Select default theme');

    $form['default_theme'] = [
      '#title' => $this->t('Select theme'),
      '#type' => 'select',
      '#options' => $this->getThemeOptions(),
      '#description' => $this->t('Select the default theme.'),
    ];

    $form['actions'] = array('#type' => 'actions');
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save and continue'),
      '#weight' => 15,
      '#button_type' => 'primary',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $default_theme = $form_state->getValue('default_theme');

    // Install the theme.
    \Drupal::service('theme_handler')->install([$default_theme]);

    // Set it as default.
    \Drupal::service('theme_handler')->setDefault($default_theme);
  }

  /**
   * Returns an #options ready array of themes.
   * @return array
   */
  protected function getThemeOptions() {
    $options = [];
    $themes = \Drupal::service('theme_handler')->rebuildThemeData();

    // Build options array.
    foreach ($themes as $name => $theme) {
      // Only show themes compatible with Open Restaurant.
      if (!isset($theme->info['package'])) {
        continue;
      }

      if ($theme->info['package'] == OPEN_RESTAURANT_DISTRIBUTION_NAME) {
        $options[$name] = $theme->info['name'];
      }
    }

    return $options;
  }
}