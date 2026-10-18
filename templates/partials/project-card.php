<?php

use LogTea\Support\Icons;

/**
 * Expects: $project (array from ProjectRegistry::all()).
 */
?>
<article class="port-card" data-category="<?= htmlspecialchars(implode(' ', $project['categories'])) ?>" data-reveal>
  <div class="port-visual<?= $project['image'] ? '' : ' port-visual-icon' ?>"<?= $project['image'] ? ' style="--img:url(\'' . htmlspecialchars($project['image']) . '\')"' : '' ?>>
    <?php if ($project['image']): ?>
      <img src="<?= htmlspecialchars($project['image']) ?>" alt="<?= htmlspecialchars($project['title']) ?>" loading="lazy" />
    <?php else: ?>
      <?= Icons::svg($project['icon'] ?? 'code') ?>
    <?php endif; ?>
    <span class="port-label"><?= htmlspecialchars($project['label']) ?></span>
  </div>
  <div class="port-card-body">
    <h3><?= htmlspecialchars($project['title']) ?></h3>
    <p><?= htmlspecialchars($project['desc']) ?></p>
    <div class="port-card-footer">
      <span class="port-result"><?= htmlspecialchars($project['result']) ?></span>
      <div class="port-tags">
        <?php foreach ($project['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?>
      </div>
    </div>
  </div>
</article>
