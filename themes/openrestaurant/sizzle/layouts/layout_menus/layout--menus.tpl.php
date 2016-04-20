<?php
/**
 * @file
 * Template for the Menus layout.
 */
?>
<div class="layout layout--menus">
  <?php if ($content['region_a']): ?>
    <div class="layout__region layout__region--region-a border--sm--bottom">
      <?php print $content['region_a']; ?>
    </div>
  <?php endif; ?>

  <?php if ($content['region_b']): ?>
    <div class="layout__region layout__region--region-b padding--xs--top padding--xs--bottom border--sm--bottom">
      <div class="container">
        <?php print $content['region_b']; ?>
      </div>
    </div>
  <?php endif; ?>

  <div class="container">
    <div class="row">
      <?php if ($content['region_c']): ?>
        <div class="layout__region layout__region--region-c col-sm-3">
          <?php print $content['region_c']; ?>
        </div>
      <?php endif; ?>
      <?php if ($content['region_d']): ?>
        <div class="layout__region layout__region--region-d col-sm-9">
          <div class="layout__region__inner">
            <?php print $content['region_d']; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <?php if ($content['region_e']): ?>
    <div class="layout__region layout__region--region-e">
      <?php print $content['region_e']; ?>
    </div>
  <?php endif; ?>
</div>
