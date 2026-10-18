<?php

declare(strict_types=1);

namespace LogTea;

/**
 * Portfolio projects shown on the homepage preview and the portfolio page.
 * `categories` keys must match the filter buttons in portfolio.php.
 */
final class ProjectRegistry
{
    /** @return array<string,string> filter key => label */
    public static function categories(): array
    {
        return [
            'web'        => 'مواقع الويب',
            'ecommerce'  => 'المتاجر الإلكترونية',
            'management' => 'أنظمة الإدارة',
            'saas'       => 'منصات SaaS',
            'ai'         => 'الذكاء الاصطناعي',
        ];
    }

    /** @return array<string,array<string,mixed>> keyed by slug */
    public static function all(): array
    {
        return [

            'myedutable' => [
                'title'      => 'منصة إدارة الجداول الدراسية — MyEduTable',
                'desc'       => 'منصة SaaS عالمية لإدارة الجداول الدراسية للمدارس والجامعات، مع خوارزميات ذكية لتوزيع الحصص ودعم متعدد اللغات',
                'image'      => '/assets/img/work/myedutable.png',
                'categories' => ['saas', 'web'],
                'label'      => 'SaaS',
                'result'     => '100+ مدرسة مشتركة',
                'tags'       => ['Vue.js', 'Python', 'AWS'],
                'featured'   => true,
            ],

            'aromenza' => [
                'title'      => 'متجر إلكتروني فاخر — Aromenza',
                'desc'       => 'منصة احترافية لعلامة Aromenza للعطور الفاخرة بتصميم راقٍ يعكس هوية العلامة التجارية مع تجربة مستخدم استثنائية',
                'image'      => '/assets/img/work/aromenza.jpg',
                'categories' => ['ecommerce', 'web'],
                'label'      => 'تجارة إلكترونية',
                'result'     => '↑ 85% معدل التحويل',
                'tags'       => ['Next.js', 'Shopify API', 'AWS'],
            ],

            'etta' => [
                'title'      => 'الموقع الإلكتروني — Etta Systems',
                'desc'       => 'موقع إلكتروني احترافي لشركة Etta Systems التقنية بتصميم عصري يعكس هوية العلامة التجارية مع أداء عالٍ وتجربة مستخدم سلسة',
                'image'      => '/assets/img/work/etta.png',
                'categories' => ['web'],
                'label'      => 'موقع شركة',
                'result'     => '↑ 200% حضور رقمي',
                'tags'       => ['Next.js', 'Tailwind CSS', 'Vercel'],
            ],

            'masalek' => [
                'title'      => 'نظام إدارة جمعية مسالك النور الخيرية',
                'desc'       => 'منصة رقمية متكاملة لإدارة عمليات الجمعية الخيرية، تشمل إدارة المستفيدين والمتبرعين وتتبع الحملات والتقارير المالية',
                'image'      => '/assets/img/work/masalek.jpg',
                'categories' => ['management', 'web'],
                'label'      => 'نظام إدارة',
                'result'     => '↑ 60% كفاءة إدارية',
                'tags'       => ['Laravel', 'Vue.js', 'MySQL'],
            ],

            'lava' => [
                'title'      => 'متجر إلكتروني — لافا للعطور والهدايا',
                'desc'       => 'منصة تجارة إلكترونية متكاملة لبيع العطور والهدايا الفاخرة، مع نظام إدارة مخزون وطلبات وتجربة تسوق مميزة',
                'image'      => '/assets/img/work/lava.png',
                'categories' => ['ecommerce', 'web'],
                'label'      => 'تجارة إلكترونية',
                'result'     => '↑ 120% مبيعات إلكترونية',
                'tags'       => ['Next.js', 'Stripe', 'MongoDB'],
            ],

            'denteam' => [
                'title'      => 'نظام إدارة عيادة الأسنان — Denteam Clinic',
                'desc'       => 'نظام إدارة متكامل لعيادة الأسنان يشمل حجز المواعيد الإلكتروني وملفات المرضى والفواتير ومتابعة خطط العلاج',
                'image'      => '/assets/img/work/denteam.png',
                'categories' => ['management', 'web'],
                'label'      => 'نظام إدارة',
                'result'     => '↑ 40% رضا المرضى',
                'tags'       => ['React', 'Laravel', 'MySQL'],
            ],

            'khula' => [
                'title'      => 'نظام إدارة الحصص المدرسية — خولة بنت الأزور',
                'desc'       => 'نظام ذكي لإدارة الجداول الدراسية والحصص، مع لوحة تحكم للمعلمين والإدارة ومتابعة الحضور والغياب',
                'image'      => '/assets/img/work/khula.jpg',
                'categories' => ['management', 'web'],
                'label'      => 'نظام إدارة',
                'result'     => '↓ 70% وقت إعداد الجداول',
                'tags'       => ['React', 'Node.js', 'PostgreSQL'],
            ],

            'sydr' => [
                'title'      => 'تطبيق دليل الأطباء السوريين — SYDR',
                'desc'       => 'تطبيق موبايل وموقع ويب لدليل الأطباء السوريين يُتيح للمرضى البحث بحسب التخصص والموقع والتقييم وحجز المواعيد إلكترونياً',
                'image'      => '/assets/img/work/sydr.png',
                'categories' => ['management', 'web'],
                'label'      => 'تطبيق طبي',
                'result'     => '500+ طبيب مسجل',
                'tags'       => ['React Native', 'Node.js', 'MongoDB'],
            ],

            'face-recognition' => [
                'title'      => 'نموذج التعرف على الوجه باستخدام CNN',
                'desc'       => 'تدريب نموذج شبكة عصبية تلافيفية مخصص للتعرف على الوجوه بدقة عالية، مع معالجة بيانات التدريب والـ Data Augmentation وضبط المعاملات',
                'image'      => null,
                'icon'       => 'ai',
                'categories' => ['ai'],
                'label'      => 'AI · CNN',
                'result'     => '97%+ دقة التعرف',
                'tags'       => ['Python', 'TensorFlow', 'OpenCV'],
            ],

        ];
    }

    /** @return array<string,mixed>|null */
    public static function featured(): ?array
    {
        foreach (self::all() as $slug => $project) {
            if (!empty($project['featured'])) {
                return $project + ['slug' => $slug];
            }
        }

        return null;
    }
}
