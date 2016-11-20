<?php

namespace Drupal\snazzymaps\Controller;

use Drupal\Core\Controller\ControllerBase;
use GuzzleHttp\Client;

class SnazzyMapsExploreController extends ControllerBase {
  public function overview() {
    $results = array();
    $config = $this->config('snazzymaps.settings');

    // Create a new Guzzle client.
    $client = new Client(array(
      'base_uri' => 'https://snazzymaps.com',
    ));

    // Ask for the maps.
    $response = $client->request('GET', 'explore.json', array(
      'query' => array(
        'key' => $config->get('api_key'),
      ),
    ));

    if ($response->getStatusCode() == 200) {
      $explore_data = json_decode($response->getBody());
      $results = $explore_data->styles;
    }

    return array(
      '#theme' => 'snazzymaps_results',
      '#results' => $results,
    );
  }
}
