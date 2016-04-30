<?php
/**
 * @file
 * Template for the Reservation layout.
 */
?>
<div class="layout layout--reservation">
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

  <div class="container padding--lg--top padding--lg--bottom">
    <div class="row">
      <?php if ($content['region_c']): ?>
        <div class="layout__region layout__region--region-c col-sm-4">
          <?php print $content['region_c']; ?>
        </div>
      <?php endif; ?>
      <?php if ($content['region_d']): ?>
        <div class="layout__region layout__region--region-d col-sm-8">
          <?php print $content['region_d']; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
