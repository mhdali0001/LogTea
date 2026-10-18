<?php

use LogTea\Support\Icons;

/**
 * Expects: $slug, $tool (entry from ToolRegistry::all()).
 */
?>
<a href="/tools/<?= htmlspecialchars($slug) ?>" class="tool-card" data-cat="<?= $tool['category'] ?>"
   data-name="<?= htmlspecialchars(mb_strtolower($tool['name_ar'])) ?>"
   data-desc="<?= htmlspecialchars(mb_strtolower($tool['desc_ar'])) ?>">
  <div class="tool-icon"><?= Icons::svg($tool['icon']) ?></div>
  <?php if (isset($tool['note_ar'])): ?><span class="tc-badge">نطاق محدود</span><?php endif; ?>
  <h3><?= htmlspecialchars($tool['name_ar']) ?></h3>
  <p><?= htmlspecialchars($tool['desc_ar']) ?></p>
</a>
