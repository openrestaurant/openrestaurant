<?php

namespace Drupal\snazzymaps\Controller;

use Drupal\Core\Controller\ControllerBase;

class SnazzyMapsStylesController extends ControllerBase {
  public function overview() {
    $config = $this->config('snazzymaps.settings');

    return array(
      '#markup' => $config->get('api_key'),
    );
  }
}
