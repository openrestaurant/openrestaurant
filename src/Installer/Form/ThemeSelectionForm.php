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
    // Clear all messages.
    drupal_get_messages();

    $form['#title'] = t('Select default theme');

    $form['default_theme'] = [
      '#title' => $this->t('Default theme'),
      '#title_display' => 'invisible',
      '#type' => 'radios',
      '#required' => TRUE,
      '#options' => $this->getThemeOptions(),
      '#default_value' => 'sizzle',
    ];

    $form['import_demo_content'] = [
      '#title' => $this->t('Import demo content'),
      '#type' => 'checkbox',
      '#default_value' => 1,
      '#description' => $this->t('If checked, demo content from the selected theme will be installed.'),
    ];

    $form['actions'] = array('#type' => 'actions');
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save and continue'),
      '#weight' => 15,
      '#button_type' => 'primary',
    );

    // Add a link to the theme store.
    $theme_store_message = $this->t('Download a premium theme from our <a href="@url">theme store</a>.', [
      '@url' => 'http://www.open.restaurant/#themes',
    ]);

    $form['message'] = [
      '#markup' => '<h3>' . $theme_store_message . '</h3>'
    ];

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

    // Import demo content.
    $import_demo_content = $form_state->getValue('import_demo_content');
    if ($import_demo_content) {
      \Drupal::service('demo_content.manager')->importFromExtension($default_theme);
    }
  }

  /**
   * Returns an #options ready array of themes.
   * @return array
   */
  protected function getThemeOptions() {
    global $base_url;

    $options = [];
    $themes = \Drupal::service('theme_handler')->rebuildThemeData();

    // Build options array.
    foreach ($themes as $name => $theme) {
      // Only show themes compatible with Open Restaurant.
      if (!isset($theme->info['package']) || (isset($theme->info['hidden']) && $theme->info['hidden'])) {
        continue;
      }

      if ($theme->info['package'] == OPEN_RESTAURANT_DISTRIBUTION_NAME) {
        $options[$name] = '<h4>' . $theme->info['name'] . '</h4>';
        $options[$name] .= '<p class="description">' . $theme->info['description'] . '</p>';
        $options[$name] .= '<img src="' . $base_url . '/' . $theme->info['screenshot'] . '" />';
      }
    }

    return $options;
  }
}