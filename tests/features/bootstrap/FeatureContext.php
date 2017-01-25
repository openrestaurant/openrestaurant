<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Mink\Exception\ExpectationException;
use Drupal\DrupalExtension\Context\RawDrupalContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawDrupalContext implements SnippetAcceptingContext {

  /**
   * @When I fill in :field ckeditor field with :value
   */
  public function iFillInCkeditorFieldWith($field, $value) {
    $el = $this->getSession()->getPage()->findField($field);

    if (empty($el)) {
      throw new ExpectationException('Could not find CKEditor field: ' . $field, $this->getSession());
    }

    $fieldId = $el->getAttribute('id');
    $this->getSession()
      ->executeScript("CKEDITOR.instances[\"$fieldId\"].setData(\"$value\");");
  }
}
