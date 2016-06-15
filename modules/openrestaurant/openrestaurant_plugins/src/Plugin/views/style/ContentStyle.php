<?php

namespace Drupal\openrestaurant_plugins\Plugin\views\style;

use Drupal\views\Plugin\views\style\StylePluginBase;

/**
 * Style plugin to make theming views content simpler.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "content",
 *   title = @Translation("Content"),
 *   help = @Translation("Simplifies theming for views content."),
 *   theme = "views_view_content",
 *   display_types = { "normal" }
 * )
 *
 */
class ContentStyle extends StylePluginBase {
  /**
   * Does the style plugin allows to use style plugins.
   *
   * @var bool
   */
  protected $usesRowPlugin = TRUE;

  /**
   * Does the style plugin support custom css class for the rows.
   *
   * @var bool
   */
  protected $usesRowClass = TRUE;
}
