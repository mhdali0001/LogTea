<?php

declare(strict_types=1);

namespace LogTea;

/**
 * Single source of truth for the company's services: drives the homepage
 * service cards, the detailed services page, the footer links and the
 * contact form's "service" dropdown.
 */
final class ServiceRegistry
{
    /** @return array<string,array<string,mixed>> keyed by anchor id */
    public static function all(): array
    {
        return [

            'web-design' => [
                'icon'     => 'design',
                'tone'     => 1,
                'name_en'  => 'Web Design',
                'name_ar'  => 'تصميم المواقع',
                'summary'  => 'واجهات عصرية وتجربة مستخدم مدروسة تعكس هوية علامتك وتحوّل الزوار إلى عملاء',
                'desc'     => 'نصمم مواقع تُشبه علامتك التجارية وتخدم أهدافها. نبدأ بفهم جمهورك، ثم نبني تجربة استخدام واضحة وواجهات أنيقة تعمل بسلاسة على كل الشاشات — من الهاتف إلى الشاشات الكبيرة.',
                'features' => [
                    'تصميم UI/UX مخصص بالكامل لهويتك',
                    'نماذج أولية تفاعلية قبل التطوير',
                    'تصميم متجاوب لكل الأجهزة',
                    'دعم كامل للغة العربية واتجاه RTL',
                    'تجربة مستخدم مبنية على رحلة العميل',
                    'دليل تصميم (Design System) قابل لإعادة الاستخدام',
                ],
                'tags'     => ['UI/UX', 'Figma', 'Responsive', 'RTL'],
                'badge'    => 'UI / UX',
                'url'      => '/services.php#web-design',
            ],

            'web-development' => [
                'icon'     => 'code',
                'tone'     => 2,
                'featured' => true,
                'name_en'  => 'Web Development',
                'name_ar'  => 'تطوير المواقع والتطبيقات',
                'summary'  => 'مواقع وتطبيقات ويب سريعة وآمنة بأحدث الأطر والتقنيات',
                'desc'     => 'نحوّل التصميم إلى موقع حقيقي سريع وآمن وسهل الإدارة. من المواقع التعريفية إلى المنصات المعقدة — نكتب كوداً نظيفاً قابلاً للتوسع، ونهتم بالأداء وتحسين الظهور في محركات البحث من اليوم الأول.',
                'features' => [
                    'مواقع تعريفية وشركات بلوحة تحكم سهلة',
                    'تطبيقات ويب بـ React / Next.js و Vue.js',
                    'أنظمة Laravel / PHP عالية الكفاءة',
                    'تحسين محركات البحث (SEO) تقنياً',
                    'سرعة تحميل وأداء عالٍ',
                    'استضافة ونشر ودعم فني بعد الإطلاق',
                ],
                'tags'     => ['Laravel', 'React / Next.js', 'Vue.js', 'SEO'],
                'badge'    => 'Web',
                'url'      => '/services.php#web-development',
            ],

            'ecommerce' => [
                'icon'     => 'cart',
                'tone'     => 5,
                'name_en'  => 'E-Commerce',
                'name_ar'  => 'المتاجر الإلكترونية',
                'summary'  => 'متاجر إلكترونية متكاملة بتجربة تسوق مميزة وبوابات دفع آمنة',
                'desc'     => 'نبني متاجر إلكترونية تبيع فعلاً: تجربة تسوق سلسة، صفحات منتجات جذابة، دفع آمن، وإدارة سهلة للمخزون والطلبات — حتى تركّز أنت على تنمية تجارتك.',
                'features' => [
                    'متجر بتصميم يعكس علامتك التجارية',
                    'ربط بوابات الدفع الإلكتروني',
                    'إدارة المنتجات والمخزون والطلبات',
                    'كوبونات وعروض وبرامج ولاء',
                    'تقارير مبيعات وتحليلات',
                    'تجربة شراء محسّنة للجوال',
                ],
                'tags'     => ['Next.js', 'Stripe', 'Shopify API', 'Payments'],
                'badge'    => 'E-Commerce',
                'url'      => '/services.php#ecommerce',
            ],

            'systems' => [
                'icon'     => 'dashboard',
                'tone'     => 3,
                'name_en'  => 'Management Systems',
                'name_ar'  => 'أنظمة الإدارة ومنصات SaaS',
                'summary'  => 'أنظمة ولوحات تحكم مخصصة لإدارة أعمالك ومؤسستك بكفاءة',
                'desc'     => 'نطوّر أنظمة إدارة مصممة على مقاس مؤسستك: جمعيات، مدارس، عيادات، وشركات. لوحات تحكم واضحة، صلاحيات للمستخدمين، وتقارير تساعدك على اتخاذ القرار.',
                'features' => [
                    'أنظمة إدارة مخصصة لطبيعة عملك',
                    'لوحات تحكم وتقارير لحظية',
                    'صلاحيات وأدوار متعددة للمستخدمين',
                    'حجوزات ومواعيد وإشعارات',
                    'منصات SaaS متعددة اللغات',
                    'ربط مع أنظمة وخدمات خارجية (APIs)',
                ],
                'tags'     => ['Laravel', 'Vue.js', 'MySQL', 'REST API'],
                'badge'    => 'Systems',
                'url'      => '/services.php#systems',
            ],

            'ai' => [
                'icon'     => 'ai',
                'tone'     => 4,
                'name_en'  => 'AI Solutions',
                'name_ar'  => 'حلول الذكاء الاصطناعي',
                'summary'  => 'دمج الذكاء الاصطناعي في موقعك ومنتجك: مساعدات ذكية وأتمتة',
                'desc'     => 'نضيف الذكاء الاصطناعي إلى موقعك أو نظامك حيث يصنع فرقاً حقيقياً: مساعد ذكي يجيب عملاءك، أتمتة للمهام المتكررة، أو نماذج مخصصة لتحليل الصور والبيانات.',
                'features' => [
                    'Chatbots ومساعدين ذكيين لموقعك',
                    'تكامل مع نماذج OpenAI و Claude و Gemini',
                    'معالجة اللغة العربية (NLP)',
                    'رؤية حاسوبية للتعرف على الصور',
                    'أتمتة العمليات المتكررة',
                ],
                'tags'     => ['Python', 'TensorFlow', 'OpenAI', 'LangChain'],
                'badge'    => 'AI',
                'url'      => '/services.php#ai',
            ],

            'tools' => [
                'icon'     => 'tools',
                'tone'     => 6,
                'free'     => true,
                'name_en'  => 'Free Online Tools',
                'name_ar'  => 'أدوات الملفات المجانية',
                'summary'  => 'أدوات مجانية لملفات PDF والصور والمستندات — بدون تسجيل',
                'desc'     => 'كجزء من التزامنا بتسهيل العمل الرقمي، نوفّر مجموعة أدوات مجانية لمعالجة الملفات تعمل مباشرة من المتصفح: دمج وضغط وتحويل ملفات PDF والصور والمستندات — بدون تسجيل، وتُحذف ملفاتك تلقائياً.',
                'features' => [
                    'دمج وتقسيم وتدوير وترقيم ملفات PDF',
                    'تحويل Word و Excel و PowerPoint إلى PDF',
                    'تحويل PDF إلى Word و Excel و PowerPoint',
                    'ضغط ملفات PDF والصور',
                    'حماية ملفات PDF بكلمة مرور',
                    'بدون تسجيل — حذف تلقائي للملفات',
                ],
                'tags'     => ['PDF', 'Word', 'Excel', 'Images'],
                'badge'    => 'مجاناً',
                'url'      => '/tools.php',
            ],

        ];
    }
}
