<?php

require __DIR__ . '/../src/bootstrap.php';

use LogTea\Support\Icons;
use LogTea\Support\TempCleanup;
use LogTea\ToolRegistry;

TempCleanup::run();

$slug = $_GET['slug'] ?? '';
$tool = ToolRegistry::find($slug);

if ($tool === null) {
    http_response_code(404);
    $pageTitle = 'الأداة غير موجودة | LogTea';
    ob_start();
    ?>
    <section class="page-banner">
      <div class="container">
        <h1>الأداة غير موجودة</h1>
        <p>الرابط الذي زرته غير صحيح أو أن الأداة لم تعد متوفرة.</p>
        <a href="/#tools" class="btn btn-primary" style="margin-top:20px;">تصفح كل الأدوات</a>
      </div>
    </section>
    <?php
    $content = ob_get_clean();
    require __DIR__ . '/../templates/layout.php';
    exit;
}

$pageTitle = $tool['name_ar'] . ' | LogTea';
$pageDescription = $tool['desc_ar'];
$activePage = 'tools';

$related = array_filter(ToolRegistry::byCategory($tool['category']), static fn ($s) => $s !== $slug, ARRAY_FILTER_USE_KEY);
$related = array_slice($related, 0, 5, true);

$acceptList = implode(',', array_map(static fn ($e) => '.' . $e, $tool['accept']));
$jsConfig = [
    'slug' => $slug,
    'accept' => $tool['accept'],
    'multiple' => (bool) ($tool['multiple'] ?? false),
    'minFiles' => $tool['min_files'] ?? 1,
    'submitLabel' => 'ابدأ المعالجة',
];

ob_start();
?>
<section class="page-banner">
  <div class="container">
    <div class="breadcrumb"><a href="/">الرئيسية</a><span class="breadcrumb-sep">/</span><a href="/#tools">الأدوات</a><span class="breadcrumb-sep">/</span><span><?= htmlspecialchars($tool['name_ar']) ?></span></div>
    <h1><?= htmlspecialchars($tool['name_ar']) ?></h1>
    <p><?= htmlspecialchars($tool['desc_ar']) ?></p>
  </div>
</section>

<div class="container">
  <div class="tool-layout" data-tool-app='<?= htmlspecialchars(json_encode($jsConfig, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8') ?>'>
    <div class="tool-main">
      <div class="tool-upload-area">
        <div class="dropzone">
          <div class="dropzone-icon"><?= Icons::svg($tool['icon']) ?></div>
          <h3>اسحب الملف هنا أو اضغط للاختيار</h3>
          <p>الصيغ المدعومة: <?= htmlspecialchars($acceptList) ?><?= ($tool['multiple'] ?? false) ? ' — يمكن اختيار أكثر من ملف' : '' ?></p>
          <input type="file" accept="<?= htmlspecialchars($acceptList) ?>" <?= ($tool['multiple'] ?? false) ? 'multiple' : '' ?> />
        </div>
        <div class="file-list"></div>

        <?php if (!empty($tool['options'])): ?>
        <div class="tool-options">
          <?php foreach ($tool['options'] as $opt): ?>
            <?php
              $dependsAttr = '';
              if (!empty($opt['depends_on'])) {
                  $depKey = array_key_first($opt['depends_on']);
                  $dependsAttr = ' data-depends-on="' . htmlspecialchars($depKey . ':' . $opt['depends_on'][$depKey]) . '"';
              }
            ?>
            <div class="opt-field"<?= $dependsAttr ?>>
              <label><?= htmlspecialchars($opt['label_ar']) ?><?php if ($opt['type'] === 'range'): ?> (<span class="opt-range-value"><?= htmlspecialchars((string) $opt['default']) ?></span>)<?php endif; ?></label>
              <?php if ($opt['type'] === 'select'): ?>
                <select data-opt="<?= htmlspecialchars($opt['name']) ?>">
                  <?php foreach ($opt['choices'] as $choice): ?>
                    <option value="<?= htmlspecialchars($choice['value']) ?>" <?= $choice['value'] === $opt['default'] ? 'selected' : '' ?>><?= htmlspecialchars($choice['label_ar']) ?></option>
                  <?php endforeach; ?>
                </select>
              <?php elseif ($opt['type'] === 'range'): ?>
                <input type="range" data-opt="<?= htmlspecialchars($opt['name']) ?>" min="<?= (int) $opt['min'] ?>" max="<?= (int) $opt['max'] ?>" value="<?= (int) $opt['default'] ?>" />
              <?php elseif ($opt['type'] === 'password'): ?>
                <input type="password" data-opt="<?= htmlspecialchars($opt['name']) ?>" placeholder="<?= htmlspecialchars($opt['label_ar']) ?>" />
              <?php elseif ($opt['type'] === 'number'): ?>
                <input type="number" data-opt="<?= htmlspecialchars($opt['name']) ?>" value="<?= htmlspecialchars((string) $opt['default']) ?>" />
              <?php else: ?>
                <input type="text" data-opt="<?= htmlspecialchars($opt['name']) ?>" value="<?= htmlspecialchars((string) $opt['default']) ?>" placeholder="<?= htmlspecialchars($opt['label_ar']) ?>" />
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if (isset($tool['note_ar'])): ?>
          <div class="tool-note">ملاحظة: <?= htmlspecialchars($tool['note_ar']) ?></div>
        <?php endif; ?>

        <div class="tool-actions">
          <button type="button" class="btn btn-primary btn-lg tool-submit" disabled>ابدأ المعالجة</button>
        </div>

        <div class="tool-progress">
          <div class="progress-bar"><div class="progress-bar-fill"></div></div>
          <div class="progress-label">جارِ الرفع...</div>
        </div>

        <div class="tool-error"></div>
      </div>

      <div class="tool-result">
        <div class="result-icon"><?= Icons::svg('pagenum') ?></div>
        <h3>تم بنجاح!</h3>
        <p class="result-filename"></p>
        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
          <a href="#" class="btn btn-primary result-download">تنزيل الملف</a>
          <button type="button" class="btn btn-ghost tool-reset">معالجة ملف آخر</button>
        </div>
      </div>
    </div>

    <aside class="tool-sidebar">
      <div class="sidebar-card">
        <h4>خصوصيتك</h4>
        <div class="sidebar-trust">
          <span>🔒 لا حاجة لإنشاء حساب</span>
          <span>🗑️ حذف تلقائي خلال ساعة</span>
          <span>💯 بدون أي رسوم</span>
        </div>
      </div>
      <?php if ($related): ?>
      <div class="sidebar-card">
        <h4>أدوات ذات صلة</h4>
        <ul>
          <?php foreach ($related as $rSlug => $rTool): ?>
            <li><a href="/tools/<?= htmlspecialchars($rSlug) ?>"><?= htmlspecialchars($rTool['name_ar']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>
    </aside>
  </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../templates/layout.php';
