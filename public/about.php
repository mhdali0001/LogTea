<?php

require __DIR__ . '/../src/bootstrap.php';

use LogTea\Support\Seo;
use LogTea\Support\TempCleanup;

TempCleanup::run();

$pageTitle = 'من نحن | LogTea';
$pageDescription = 'LogTea شركة تصميم وتطوير مواقع تؤمن بأن كل فكرة تستحق أن تتحول إلى حل رقمي متقن. تعرّف على قصتنا ورسالتنا وقيمنا.';
$activePage = 'about';
$canonicalPath = '/about.php';

$values = [
    ['💡', 'الابتكار أولاً', 'نتبنى أحدث التقنيات ونجرب باستمرار. البقاء في المقدمة ليس خياراً بل ضرورة في عالم التكنولوجيا المتسارع.'],
    ['🏆', 'الجودة لا تُساوَم', 'نكتب كوداً نفتخر به. كل سطر يمر بمراجعة دقيقة، وكل ميزة تُختبر بعناية. الجودة ليست تكلفة إضافية — هي نقطة الانطلاق.'],
    ['🤝', 'الشراكة الحقيقية', 'نتعامل مع مشاريع عملائنا كما لو أنها مشاريعنا. ننجح معاً أو نتعلم معاً. نجاحك هو نجاحنا.'],
    ['🔒', 'الأمان في كل خطوة', 'الأمن ليس ميزة إضافية — هو أساس كل ما نبنيه. من أول سطر كود حتى الإطلاق وما بعده.'],
    ['⚡', 'السرعة والكفاءة', 'تسليم مبكر، تغذية راجعة سريعة، وتحسين مستمر. وقتك ثمين ونحن ندرك ذلك.'],
    ['🌱', 'العطاء للمجتمع', 'نؤمن بمشاركة ما نصنعه؛ لذلك نوفّر أدوات ملفات مجانية يستخدمها الجميع بدون تسجيل أو رسوم.'],
];

$techGroups = [
    'Design'          => ['🎨 Figma', '📐 UI/UX', '📱 Responsive', '↔️ RTL'],
    'Frontend'        => ['⚛️ React', '▲ Next.js', '💚 Vue.js', '🔷 TypeScript', '🎨 Tailwind CSS'],
    'Backend & APIs'  => ['🔴 Laravel', '🐘 PHP', '🟢 Node.js', '🐍 Python', '🔗 REST APIs'],
    'AI & Cloud'      => ['🧠 OpenAI API', '🤖 TensorFlow', '☁️ AWS', '🐳 Docker', '⚙️ GitHub Actions'],
];

ob_start();
?>
<section class="page-banner">
  <div class="page-banner-grid"></div>
  <div class="container">
    <div class="breadcrumb"><a href="/">الرئيسية</a><span class="breadcrumb-sep">/</span><span>من نحن</span></div>
    <h1>نكتب الشيفرة<br/><span class="text-teal">نصنع الحلول</span></h1>
    <p>شركة تصميم وتطوير مواقع تؤمن بأن كل فكرة تستحق أن تتحول إلى واقع رقمي متقن يُحدث فرقاً حقيقياً في أعمال عملائها</p>
    <div class="banner-stat-row">
      <div class="banner-stat"><strong>50+</strong><span>عميل سعيد</span></div>
      <div class="banner-stat"><strong>120+</strong><span>مشروع مكتمل</span></div>
      <div class="banner-stat"><strong>5+</strong><span>سنوات خبرة</span></div>
      <div class="banner-stat"><strong>10+</strong><span>تقنية متخصصة</span></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="story-grid">
      <div class="story-img" data-reveal>
        <img src="/assets/img/brand-identity.jpg" alt="الهوية البصرية لـ LogTea" class="story-photo" loading="lazy" />
        <div class="story-card-float">
          <div><div class="scf-num">120+</div><div class="scf-label">مشروع ناجح</div></div>
        </div>
      </div>
      <div data-reveal>
        <div class="section-tag">قصتنا</div>
        <h2 class="section-title">لماذا <span class="text-teal">LogTea</span>؟</h2>
        <div class="story-text">
          <p>بدأت القصة عام 2019 بشغف حقيقي بالتكنولوجيا ورغبة صادقة في صنع الفرق. مثلما تصنع كوب الشاي الجيد من أجود أوراق الشاي بعناية واهتمام — نحن نصمم مواقعنا ونبني حلولنا البرمجية بنفس الدقة والاهتمام.</p>
          <p>"Log" هي سجلات الكود التي نكتبها يومياً، و"Tea" هي الطاقة والإبداع الذي نضخه في كل مشروع. نصدق أن البرمجة فن قبل أن تكون علم، وأن كل سطر كود هو فرصة لصنع شيء جميل.</p>
          <p>اليوم، فريقنا من المصممين والمطورين يعمل يداً بيد لتقديم مواقع ومتاجر وأنظمة متكاملة تُسرّع نمو أعمال عملائنا — ونشارك جزءاً مما نبنيه مع الجميع عبر أدوات ملفات مجانية.</p>
        </div>
        <div class="btn-row">
          <a href="/contact.php" class="btn btn-primary">ابدأ معنا</a>
          <a href="/portfolio.php" class="btn btn-ghost">شاهد أعمالنا</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section section-dark">
  <div class="container">
    <div class="section-header" data-reveal>
      <div class="section-tag">رسالتنا ورؤيتنا</div>
      <h2 class="section-title">نؤمن بأن <span class="text-teal">التكنولوجيا</span> تغيّر العالم</h2>
    </div>
    <div class="mv-grid">
      <div class="mv-card" data-reveal>
        <div class="mv-num">01</div>
        <h3>رسالتنا</h3>
        <p>تمكين الأفراد والمؤسسات من تحقيق أهدافهم الرقمية من خلال مواقع وحلول برمجية مبتكرة وموثوقة، بناءً على شراكة حقيقية تقوم على الشفافية والثقة المتبادلة.</p>
      </div>
      <div class="mv-card" data-reveal>
        <div class="mv-num">02</div>
        <h3>رؤيتنا</h3>
        <p>أن نكون الشريك التقني الأول الذي تلجأ إليه الشركات والمؤسسات في المنطقة العربية عندما تريد تحويل أفكارها إلى منتجات رقمية تنافسية على المستوى العالمي.</p>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-header" data-reveal>
      <div class="section-tag">قيمنا</div>
      <h2 class="section-title">ما الذي <span class="text-teal">يميزنا</span></h2>
    </div>
    <div class="values-grid">
      <?php foreach ($values as [$emoji, $title, $desc]): ?>
        <div class="value-card" data-reveal><span class="vc-emoji"><?= $emoji ?></span><h3><?= htmlspecialchars($title) ?></h3><p><?= htmlspecialchars($desc) ?></p></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section-dark">
  <div class="container">
    <div class="section-header" data-reveal>
      <div class="section-tag">التقنيات</div>
      <h2 class="section-title">أدواتنا <span class="text-teal">المفضلة</span></h2>
    </div>
    <div class="tech-groups">
      <?php foreach ($techGroups as $group => $pills): ?>
        <div class="tech-group" data-reveal>
          <h3><?= htmlspecialchars($group) ?></h3>
          <div class="tech-pills"><?php foreach ($pills as $pill): ?><div class="tech-pill"><?= htmlspecialchars($pill) ?></div><?php endforeach; ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="cta-banner">
  <div class="container" data-reveal>
    <h2>انضم إلى عائلة <span class="text-teal">LogTea</span></h2>
    <p>هل تريد شريكاً تقنياً موثوقاً يفهم احتياجاتك ويسعى لتحقيق أهدافك؟</p>
    <div class="cta-banner-btns">
      <a href="/contact.php" class="btn btn-primary btn-lg">تواصل معنا الآن</a>
      <a href="/services.php" class="btn btn-ghost btn-lg">استعرض الخدمات</a>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();

$extraHead = Seo::jsonLd([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'الرئيسية', 'item' => Seo::url('/')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'من نحن', 'item' => Seo::url('/about.php')],
    ],
]);

require __DIR__ . '/../templates/layout.php';
