<?php

declare(strict_types=1);

namespace LogTea;

/**
 * Search/social metadata for the company pages (tool pages use ToolSeo).
 * The main keyword theme is "برمجة/تصميم مواقع في سوريا".
 *
 * Each entry: title (<title>, ~60 chars max), description (meta description,
 * ~150 chars), keywords, and card (text of the 1200×630 social image that
 * scripts/og-images.php renders into public/assets/img/og/pages/{page}.jpg).
 */
final class PageSeo
{
    /** @return array{title:string,description:string,keywords:string,image:string} */
    public static function for(string $page): array
    {
        $seo = self::all()[$page];
        $image = '/assets/img/og/pages/' . $page . '.jpg';

        return [
            'title' => $seo['title'],
            'description' => $seo['description'],
            'keywords' => implode(', ', $seo['keywords']),
            'image' => is_file(LOGTEA_ROOT . '/public' . $image) ? $image : '/assets/img/og-image.png',
        ];
    }

    /** @return array<string,array{title:string,subtitle:string,icon:string,tags:list<string>}> keyed by page */
    public static function cards(): array
    {
        return array_map(static fn (array $seo): array => $seo['card'], self::all());
    }

    private static function all(): array
    {
        return [

            'home' => [
                'title'       => 'شركة برمجة وتصميم مواقع في سوريا | LogTea',
                'description' => 'هل تبحث عن برمجة موقع في سوريا؟ LogTea شركة برمجة وتصميم مواقع ومتاجر إلكترونية وأنظمة إدارة في دمشق منذ 2019 — استشارتك الأولى مجانية.',
                'keywords'    => ['برمجة موقع في سوريا', 'برمجة مواقع في سوريا', 'تصميم مواقع في سوريا', 'شركة برمجة مواقع في سوريا', 'شركة تصميم مواقع في دمشق', 'تصميم متجر إلكتروني في سوريا', 'تطوير مواقع', 'LogTea', 'web design Syria', 'web development Damascus'],
                'card'        => ['title' => 'برمجة مواقع في سوريا', 'subtitle' => 'Web Design & Development', 'icon' => 'code', 'tags' => ['مواقع شركات', 'متاجر إلكترونية', 'أنظمة إدارة']],
            ],

            'services' => [
                'title'       => 'خدمات برمجة وتصميم المواقع والمتاجر في سوريا | LogTea',
                'description' => 'برمجة مواقع الشركات، تصميم المتاجر الإلكترونية، أنظمة الإدارة ومنصات SaaS، وحلول الذكاء الاصطناعي — خدمات LogTea لبرمجة المواقع في سوريا والمنطقة العربية.',
                'keywords'    => ['خدمات برمجة المواقع', 'برمجة مواقع الشركات في سوريا', 'تصميم متجر إلكتروني', 'برمجة أنظمة إدارة', 'تصميم UI/UX', 'حلول الذكاء الاصطناعي', 'web development services Syria'],
                'card'        => ['title' => 'خدماتنا', 'subtitle' => 'Our Services', 'icon' => 'design', 'tags' => ['تصميم', 'برمجة', 'متاجر', 'ذكاء اصطناعي']],
            ],

            'portfolio' => [
                'title'       => 'أعمالنا في برمجة المواقع والمتاجر الإلكترونية | LogTea',
                'description' => 'نماذج من أعمال LogTea في برمجة وتصميم المواقع: مواقع شركات ومتاجر إلكترونية وأنظمة إدارة ومنصات SaaS أنجزناها لعملائنا، مع نتيجة كل مشروع.',
                'keywords'    => ['أعمال برمجة مواقع', 'نماذج مواقع', 'نماذج متاجر إلكترونية', 'معرض أعمال تصميم مواقع', 'LogTea portfolio'],
                'card'        => ['title' => 'أعمالنا', 'subtitle' => 'Our Work', 'icon' => 'dashboard', 'tags' => ['مواقع', 'متاجر إلكترونية', 'منصات SaaS']],
            ],

            'about' => [
                'title'       => 'من نحن | LogTea — شركة برمجة مواقع في دمشق',
                'description' => 'تعرّف على LogTea: شركة برمجة وتصميم مواقع مقرها دمشق، بدأت عام 2019 وتحوّل أفكار عملائها في سوريا والمنطقة العربية إلى مواقع ومنتجات رقمية متقنة.',
                'keywords'    => ['LogTea', 'شركة برمجة في دمشق', 'شركة تصميم مواقع سورية', 'فريق برمجة مواقع', 'من نحن'],
                'card'        => ['title' => 'من نحن', 'subtitle' => 'About LogTea', 'icon' => 'bulb', 'tags' => ['مقرنا دمشق', 'منذ 2019', 'أكثر من 120 مشروع']],
            ],

            'tools' => [
                'title'       => 'أدوات PDF مجانية: دمج وضغط وتحويل الملفات | LogTea',
                'description' => 'أدوات مجانية لدمج وضغط وتحويل ملفات PDF وWord وExcel والصور — بدون تسجيل، ومعالجة سريعة وآمنة، وتُحذف ملفاتك تلقائياً. خدمة مجانية من LogTea.',
                'keywords'    => ['أدوات PDF مجانية', 'دمج PDF', 'ضغط PDF', 'تحويل PDF إلى Word', 'تحويل Word إلى PDF', 'ضغط الصور', 'free PDF tools'],
                'card'        => ['title' => 'أدوات ملفات مجانية', 'subtitle' => 'Free PDF & File Tools', 'icon' => 'tools', 'tags' => ['مجاناً', 'بدون تسجيل', 'حذف تلقائي للملفات']],
            ],

            'contact' => [
                'title'       => 'اطلب برمجة موقعك في سوريا — تواصل معنا | LogTea',
                'description' => 'تريد برمجة موقع في سوريا؟ تواصل مع فريق LogTea مباشرة عبر LinkedIn واحصل على استشارة أولى مجانية. مقرنا في دمشق، ومكاتبنا في إسطنبول وعُمان.',
                'keywords'    => ['طلب برمجة موقع', 'برمجة موقع في سوريا', 'استشارة تصميم مواقع مجانية', 'تواصل مع LogTea', 'شركة برمجة في دمشق'],
                'card'        => ['title' => 'تواصل معنا', 'subtitle' => 'Contact Us', 'icon' => 'mail', 'tags' => ['استشارة مجانية', 'رد خلال 24 ساعة', 'مقرنا دمشق']],
            ],

        ];
    }
}
