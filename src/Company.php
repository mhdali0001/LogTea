<?php

declare(strict_types=1);

namespace LogTea;

use LogTea\Support\Seo;

/**
 * Company facts shown on the contact page and published as the site-wide
 * schema.org organization (see templates/layout.php), so both always agree.
 */
final class Company
{
    /** @return list<array{name:string,role:string,url:string}> `role` is optional and shown under the name when set. */
    public static function team(): array
    {
        return [
            ['name' => 'Omayir Alghannam', 'role' => '', 'url' => 'https://www.linkedin.com/in/omayir-alghannam/'],
            ['name' => 'Ibrahim Sabban', 'role' => '', 'url' => 'https://www.linkedin.com/in/ibrahim-sabban-9b6a5a1b4/'],
            ['name' => 'Mhd Ali', 'role' => '', 'url' => 'https://www.linkedin.com/in/mhdali000/'],
        ];
    }

    /** @return list<array<string,mixed>> the first entry is the headquarters */
    public static function offices(): array
    {
        return [
            ['badge' => 'المقر الرئيسي', 'city' => 'دمشق', 'district' => 'المالكي', 'country' => 'SY', 'address' => 'المالكي، سوريا', 'note' => 'نعمل مع عملاء المنطقة العربية والعالم', 'hq' => true],
            ['badge' => 'مكتب تركيا', 'city' => 'إسطنبول', 'district' => 'الفاتح', 'country' => 'TR', 'address' => 'الفاتح، تركيا', 'note' => 'نخدم عملاء تركيا وأوروبا', 'hq' => false],
            ['badge' => 'مكتب عُمان', 'city' => 'بركاء', 'district' => null, 'country' => 'OM', 'address' => 'سلطنة عُمان', 'note' => 'نخدم عملاء الخليج العربي', 'hq' => false],
        ];
    }

    /**
     * `days` uses JS Date#getDay() numbering (0 = Sunday … 6 = Saturday) so the
     * contact page can highlight today; `opens`/`closes` feed the schema.
     *
     * @return list<array{days:list<int>,label:string,time:string,opens:string,closes:string}>
     */
    public static function hours(): array
    {
        return [
            ['days' => [0, 1, 2, 3, 4], 'label' => 'الأحد — الخميس', 'time' => '9:00 ص — 10:00 م', 'opens' => '09:00', 'closes' => '22:00'],
            ['days' => [5], 'label' => 'الجمعة', 'time' => '2:00 م — 8:00 م', 'opens' => '14:00', 'closes' => '20:00'],
            ['days' => [6], 'label' => 'السبت', 'time' => '10:00 ص — 6:00 م', 'opens' => '10:00', 'closes' => '18:00'],
        ];
    }

    /** The organization node every page's JSON-LD graph starts from. */
    public static function schema(): array
    {
        $dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $address = static fn (array $office): array => array_filter([
            '@type' => 'PostalAddress',
            'streetAddress' => $office['district'],
            'addressLocality' => $office['city'],
            'addressCountry' => $office['country'],
        ]);
        $offices = self::offices();

        return [
            '@type' => 'ProfessionalService',
            '@id' => Seo::url('/#organization'),
            'name' => 'LogTea',
            'alternateName' => 'LogTea Software Solutions',
            'url' => Seo::url('/'),
            'logo' => ['@type' => 'ImageObject', 'url' => Seo::url('/assets/img/logo.png'), 'width' => 952, 'height' => 262],
            'image' => Seo::url('/assets/img/og-image.png'),
            'slogan' => 'نكتب الشيفرة .. نصنع الحلول',
            'description' => 'شركة برمجة وتصميم مواقع ومتاجر إلكترونية وأنظمة إدارة في سوريا، مقرها دمشق، وتخدم عملاءها في المنطقة العربية.',
            'foundingDate' => '2019',
            'address' => $address($offices[0]),
            'location' => array_map(static fn (array $o): array => [
                '@type' => 'Place',
                'name' => $o['badge'] . ' — ' . $o['city'],
                'address' => $address($o),
            ], $offices),
            'areaServed' => [
                ['@type' => 'Country', 'name' => 'سوريا'],
                ['@type' => 'Country', 'name' => 'تركيا'],
                ['@type' => 'Country', 'name' => 'سلطنة عُمان'],
                ['@type' => 'Place', 'name' => 'دول الخليج العربي'],
            ],
            'knowsAbout' => array_merge(
                ['برمجة المواقع', 'تصميم المواقع'],
                array_values(array_map(static fn (array $s): string => $s['name_ar'], ServiceRegistry::all())),
                ['Laravel', 'React', 'Vue.js', 'Next.js']
            ),
            'openingHoursSpecification' => array_map(static fn (array $h): array => [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => array_map(static fn (int $d): string => $dayNames[$d], $h['days']),
                'opens' => $h['opens'],
                'closes' => $h['closes'],
            ], self::hours()),
            'member' => array_map(static fn (array $m): array => [
                '@type' => 'Person',
                'name' => $m['name'],
                'sameAs' => $m['url'],
            ], self::team()),
        ];
    }
}
