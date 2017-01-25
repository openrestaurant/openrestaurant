<?php

namespace Drupal\openrestaurant\Installer\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Extension\ThemeHandlerInterface;
use Drupal\Core\Extension\ThemeInstallerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\demo_content\DemoContentManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides the site configuration form.
 */
class ThemeSelectionForm extends ConfigFormBase {

  /**
   * The theme handler.
   *
   * @var \Drupal\Core\Extension\ThemeHandlerInterface
   */
  protected $themeHandler;

  /**
   * The demo content manager.
   *
   * @var \Drupal\demo_content\DemoContentManagerInterface
   */
  protected $demoContentManager;

  /**
   * The theme installer.
   *
   * @var \Drupal\Core\Extension\ThemeInstallerInterface
   */
  private $themeInstaller;

  /**
   * @inheritDoc
   */
  public function __construct(ConfigFactoryInterface $config_factory, ThemeHandlerInterface $themeHandler, ThemeInstallerInterface $themeInstaller, DemoContentManagerInterface $demoContentManager) {
    parent::__construct($config_factory);
    $this->themeHandler = $themeHandler;
    $this->demoContentManager = $demoContentManager;
    $this->themeInstaller = $themeInstaller;
  }

  /**
   * @inheritDoc
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('theme_handler'),
      $container->get('theme_installer'),
      $container->get('demo_content.manager')
    );
  }


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
    $form['message'] = [
      '#type' => 'html_tag',
      '#tag' => 'h3',
      '#value' => $this->t('Download a premium theme from our <a href="@url" target="_blank">theme store</a>.', [
        '@url' => 'http://www.open.restaurant/#themes',
      ])
    ];

    // Add theme notes.
    $form['notes'] = [
      '#type' => 'html_tag',
      '#tag' => 'small',
      '#value' => $this->t('If your theme is not showing, please make sure it is in the <strong>/web/themes</strong> directory and it is <a href="@url" target="_blank">compatible with Open Restaurant</a>.', [
        '@url' => 'http://docs.open.restaurant/en/2.x/theming/#compatibility-with-open-restaurant'
      ]),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $default_theme = $form_state->getValue('default_theme');

    // Install the theme.
    $this->themeInstaller->install([$default_theme]);

    // Set it as default.
    $this->themeHandler->setDefault($default_theme);

    // Import demo content.
    $import_demo_content = $form_state->getValue('import_demo_content');
    if ($import_demo_content) {
      $this->demoContentManager->importFromExtension($default_theme);
    }
  }

  /**
   * Returns an #options ready array of themes.
   * @return array
   */
  protected function getThemeOptions() {
    global $base_url;

    $options = [];
    $themes = $this->themeHandler->rebuildThemeData();

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
