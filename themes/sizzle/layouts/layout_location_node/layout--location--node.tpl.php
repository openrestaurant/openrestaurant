<?php
/**
 * @file
 * Template for the Location node layout.
 */
?>
<div class="layout layout--location--node">
  <?php if ($content['region_a']): ?>
    <div class="layout__region layout__region--region-a border--sm--bottom">
      <?php print $content['region_a']; ?>
    </div>
  <?php endif; ?>

  <?php if ($content['region_b']): ?>
    <div class="layout__region layout__region--region-b padding--xs--top padding--xs--bottom">
      <div class="container">
        <?php print $content['region_b']; ?>
      </div>
    </div>
  <?php endif; ?>

  <?php if ($content['region_c']): ?>
    <div class="layout__region layout__region--region-c container padding--lg--top padding--lg--bottom">
      <?php print $content['region_c']; ?>
    </div>
  <?php endif; ?>

  <?php if ($content['region_d'] || $content['region_e'] ): ?>
    <div class="row">
      <div class="col-md-6 layout__region layout__region--region-d">
        <?php print $content['region_d']; ?>
      </div>
      <div class="col-md-6 layout__region layout__region--region-e">
        <?php print $content['region_e']; ?>
      </div>
    </div>
  <?php endif; ?>
</div>
