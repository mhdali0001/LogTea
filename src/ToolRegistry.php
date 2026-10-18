<?php

declare(strict_types=1);

namespace LogTea;

/**
 * Single source of truth for every tool: its metadata (used to render the
 * homepage grid and the generic tool page), its accepted files, its option
 * form fields, and the Tools\* class that performs the actual work.
 */
final class ToolRegistry
{
    /** @return array<string,array<string,mixed>> keyed by slug */
    public static function all(): array
    {
        return [

            'merge-pdf' => [
                'category'   => 'pdf',
                'icon'       => 'merge',
                'name_ar'    => 'دمج ملفات PDF',
                'name_en'    => 'Merge PDF',
                'desc_ar'    => 'ادمج عدة ملفات PDF في ملف واحد بالترتيب الذي تريده',
                'desc_en'    => 'Combine multiple PDF files into a single document, in the order you choose',
                'accept'     => ['pdf'],
                'multiple'   => true,
                'min_files'  => 2,
                'options'    => [],
                'class'      => Tools\MergePdfTool::class,
            ],

            'split-pdf' => [
                'category'  => 'pdf',
                'icon'      => 'split',
                'name_ar'   => 'تقسيم ملف PDF',
                'name_en'   => 'Split PDF',
                'desc_ar'   => 'استخرج صفحات محددة أو قسّم الملف إلى صفحات منفصلة',
                'desc_en'   => 'Extract a page range or split the file into separate pages',
                'accept'    => ['pdf'],
                'multiple'  => false,
                'options'   => [
                    ['name' => 'mode', 'type' => 'select', 'label_ar' => 'طريقة التقسيم', 'label_en' => 'Split mode', 'default' => 'range', 'choices' => [
                        ['value' => 'range', 'label_ar' => 'استخراج نطاق صفحات', 'label_en' => 'Extract a page range'],
                        ['value' => 'all', 'label_ar' => 'كل صفحة في ملف مستقل (ZIP)', 'label_en' => 'Every page as a separate file (ZIP)'],
                    ]],
                    ['name' => 'range', 'type' => 'text', 'label_ar' => "نطاق الصفحات (مثال: \u{2066}1-3,5\u{2069})", 'label_en' => 'Page range (e.g. 1-3,5)', 'default' => '', 'depends_on' => ['mode' => 'range']],
                ],
                'class' => Tools\SplitPdfTool::class,
            ],

            'rotate-pdf' => [
                'category'  => 'pdf',
                'icon'      => 'rotate',
                'name_ar'   => 'تدوير صفحات PDF',
                'name_en'   => 'Rotate PDF',
                'desc_ar'   => 'صحّح اتجاه صفحة واحدة أو كل الصفحات',
                'desc_en'   => 'Fix the orientation of one page or the whole document',
                'accept'    => ['pdf'],
                'multiple'  => false,
                'options'   => [
                    ['name' => 'angle', 'type' => 'select', 'label_ar' => 'زاوية الدوران', 'label_en' => 'Rotation angle', 'default' => '90', 'choices' => [
                        ['value' => '90', 'label_ar' => '90° يمين', 'label_en' => '90° clockwise'],
                        ['value' => '180', 'label_ar' => '180°', 'label_en' => '180°'],
                        ['value' => '270', 'label_ar' => '90° يسار', 'label_en' => '90° counter-clockwise'],
                    ]],
                    ['name' => 'pages', 'type' => 'text', 'label_ar' => 'الصفحات (اتركه فارغاً لكل الصفحات)', 'label_en' => 'Pages (leave empty for all)', 'default' => ''],
                ],
                'class' => Tools\RotatePdfTool::class,
            ],

            'add-page-numbers' => [
                'category'  => 'pdf',
                'icon'      => 'pagenum',
                'name_ar'   => 'ترقيم صفحات PDF',
                'name_en'   => 'Add Page Numbers',
                'desc_ar'   => 'أضف ترقيماً تلقائياً لصفحات الملف',
                'desc_en'   => 'Add automatic page numbering to your document',
                'accept'    => ['pdf'],
                'multiple'  => false,
                'options'   => [
                    ['name' => 'position', 'type' => 'select', 'label_ar' => 'الموضع', 'label_en' => 'Position', 'default' => 'bottom-center', 'choices' => [
                        ['value' => 'bottom-center', 'label_ar' => 'أسفل المنتصف', 'label_en' => 'Bottom center'],
                        ['value' => 'bottom-right', 'label_ar' => 'أسفل اليمين', 'label_en' => 'Bottom right'],
                        ['value' => 'bottom-left', 'label_ar' => 'أسفل اليسار', 'label_en' => 'Bottom left'],
                    ]],
                    ['name' => 'start', 'type' => 'number', 'label_ar' => 'البدء من رقم', 'label_en' => 'Start at', 'default' => '1'],
                ],
                'class' => Tools\PageNumbersTool::class,
            ],

            'add-password-pdf' => [
                'category'  => 'pdf',
                'icon'      => 'lock',
                'name_ar'   => 'إضافة كلمة مرور لملف PDF',
                'name_en'   => 'Add Password to PDF',
                'desc_ar'   => 'احمِ ملفك بكلمة مرور يجب إدخالها لفتحه',
                'desc_en'   => 'Protect your file with a password required to open it',
                'accept'    => ['pdf'],
                'multiple'  => false,
                'options'   => [
                    ['name' => 'password', 'type' => 'password', 'label_ar' => 'كلمة المرور الجديدة', 'label_en' => 'New password', 'required' => true],
                ],
                'class' => Tools\AddPasswordTool::class,
            ],

            'compress-pdf' => [
                'category'  => 'pdf',
                'icon'      => 'compress',
                'name_ar'   => 'ضغط ملف PDF',
                'name_en'   => 'Compress PDF',
                'desc_ar'   => 'قلّل حجم الملف مع الحفاظ على المحتوى',
                'desc_en'   => 'Reduce the file size while keeping the content intact',
                'accept'    => ['pdf'],
                'multiple'  => false,
                'note_ar'   => 'النتائج تعتمد على كيفية إنشاء الملف الأصلي — أفضل النتائج مع الملفات الممسوحة ضوئياً أو غير المضغوطة مسبقاً.',
                'note_en'   => 'Results depend on how the original file was produced — best gains on scanned or previously-uncompressed PDFs.',
                'options'   => [],
                'class' => Tools\CompressPdfTool::class,
            ],

            'pdf-to-word' => [
                'category'  => 'convert',
                'icon'      => 'word',
                'name_ar'   => 'تحويل PDF إلى Word',
                'name_en'   => 'PDF to Word',
                'desc_ar'   => 'حوّل محتوى PDF النصي إلى ملف Word قابل للتعديل',
                'desc_en'   => 'Turn the text content of a PDF into an editable Word file',
                'accept'    => ['pdf'],
                'multiple'  => false,
                'note_ar'   => 'يعتمد على استخراج النص، لذا قد لا يحافظ على التنسيق والجداول الدقيقة للملف الأصلي.',
                'note_en'   => 'Based on text extraction, so exact formatting and tables from the original may not be preserved.',
                'options'   => [],
                'class' => Tools\PdfToWordTool::class,
            ],

            'pdf-to-excel' => [
                'category'  => 'convert',
                'icon'      => 'excel',
                'name_ar'   => 'تحويل PDF إلى Excel',
                'name_en'   => 'PDF to Excel',
                'desc_ar'   => 'استخرج الجداول والنصوص من PDF إلى جدول بيانات',
                'desc_en'   => 'Extract tables and text from a PDF into a spreadsheet',
                'accept'    => ['pdf'],
                'multiple'  => false,
                'note_ar'   => 'يعتمد على استخراج النص وتقدير الأعمدة، وأفضل النتائج مع الجداول البسيطة الواضحة.',
                'note_en'   => 'Based on text extraction with column estimation — works best on simple, clear tables.',
                'options'   => [],
                'class' => Tools\PdfToExcelTool::class,
            ],

            'pdf-to-ppt' => [
                'category'  => 'convert',
                'icon'      => 'ppt',
                'name_ar'   => 'تحويل PDF إلى PowerPoint',
                'name_en'   => 'PDF to PowerPoint',
                'desc_ar'   => 'حوّل كل صفحة من PDF إلى شريحة عرض تقديمي',
                'desc_en'   => 'Turn each PDF page into a presentation slide',
                'accept'    => ['pdf'],
                'multiple'  => false,
                'note_ar'   => 'كل صفحة تصبح شريحة تحتوي نصّها المستخرج — بدون تطابق بصري دقيق مع تصميم الصفحة الأصلي.',
                'note_en'   => 'Each page becomes a slide with its extracted text — not a pixel-exact match of the original layout.',
                'options'   => [],
                'class' => Tools\PdfToPptTool::class,
            ],

            'pdf-to-image' => [
                'category'  => 'convert',
                'icon'      => 'image',
                'name_ar'   => 'تحويل PDF إلى صور',
                'name_en'   => 'PDF to Images',
                'desc_ar'   => 'استخرج الصور الممسوحة ضوئياً المضمّنة داخل ملف PDF',
                'desc_en'   => 'Extract scanned images embedded inside a PDF',
                'accept'    => ['pdf'],
                'multiple'  => false,
                'note_ar'   => 'يعمل مع ملفات PDF الممسوحة ضوئياً (صفحة = صورة). الصفحات النصية/الرسومية لا يمكن تحويلها إلى صورة كاملة بدون Ghostscript.',
                'note_en'   => 'Works on scanned PDFs (page = image). Text/vector pages cannot be rasterized into a full image without Ghostscript.',
                'options'   => [],
                'class' => Tools\PdfToImageTool::class,
            ],

            'compress-image' => [
                'category'  => 'image',
                'icon'      => 'compress',
                'name_ar'   => 'ضغط الصور',
                'name_en'   => 'Compress Images',
                'desc_ar'   => 'قلّل حجم صورك JPG وPNG وWebP دون فقدان كبير في الجودة',
                'desc_en'   => 'Shrink your JPG, PNG and WebP images with minimal quality loss',
                'accept'    => ['jpg', 'jpeg', 'png', 'webp'],
                'multiple'  => true,
                'options'   => [
                    ['name' => 'quality', 'type' => 'range', 'label_ar' => 'مستوى الجودة', 'label_en' => 'Quality level', 'min' => 30, 'max' => 95, 'default' => 75],
                ],
                'class' => Tools\CompressImageTool::class,
            ],

            'image-to-pdf' => [
                'category'  => 'pdf',
                'icon'      => 'image',
                'name_ar'   => 'تحويل الصور إلى PDF',
                'name_en'   => 'Images to PDF',
                'desc_ar'   => 'اجمع عدة صور في ملف PDF واحد',
                'desc_en'   => 'Combine several images into a single PDF file',
                'accept'    => ['jpg', 'jpeg', 'png', 'webp'],
                'multiple'  => true,
                'min_files' => 1,
                'options'   => [
                    ['name' => 'orientation', 'type' => 'select', 'label_ar' => 'اتجاه الصفحة', 'label_en' => 'Page orientation', 'default' => 'auto', 'choices' => [
                        ['value' => 'auto', 'label_ar' => 'تلقائي (حسب كل صورة)', 'label_en' => 'Automatic (per image)'],
                        ['value' => 'P', 'label_ar' => 'عمودي', 'label_en' => 'Portrait'],
                        ['value' => 'L', 'label_ar' => 'أفقي', 'label_en' => 'Landscape'],
                    ]],
                ],
                'class' => Tools\ImageToPdfTool::class,
            ],

            'word-to-pdf' => [
                'category'  => 'convert',
                'icon'      => 'word',
                'name_ar'   => 'تحويل Word إلى PDF',
                'name_en'   => 'Word to PDF',
                'desc_ar'   => 'حوّل مستندات Word (.docx) إلى PDF',
                'desc_en'   => 'Convert Word documents (.docx) to PDF',
                'accept'    => ['docx'],
                'multiple'  => false,
                'options'   => [],
                'class' => Tools\WordToPdfTool::class,
            ],

            'excel-to-pdf' => [
                'category'  => 'convert',
                'icon'      => 'excel',
                'name_ar'   => 'تحويل Excel إلى PDF',
                'name_en'   => 'Excel to PDF',
                'desc_ar'   => 'حوّل جداول Excel (.xlsx) إلى PDF',
                'desc_en'   => 'Convert Excel spreadsheets (.xlsx) to PDF',
                'accept'    => ['xlsx', 'xls'],
                'multiple'  => false,
                'options'   => [],
                'class' => Tools\ExcelToPdfTool::class,
            ],

            'ppt-to-pdf' => [
                'category'  => 'convert',
                'icon'      => 'ppt',
                'name_ar'   => 'تحويل PowerPoint إلى PDF',
                'name_en'   => 'PowerPoint to PDF',
                'desc_ar'   => 'حوّل عروض PowerPoint (.pptx) إلى PDF',
                'desc_en'   => 'Convert PowerPoint presentations (.pptx) to PDF',
                'accept'    => ['pptx'],
                'multiple'  => false,
                'note_ar'   => 'تحويل أساسي يحافظ على النصوص والصور، دون تطابق بصري دقيق مع تصميم الشريحة الأصلي.',
                'note_en'   => 'Basic conversion that preserves text and images, without a pixel-exact match of the original slide design.',
                'options'   => [],
                'class' => Tools\PptToPdfTool::class,
            ],

        ];
    }

    public static function find(string $slug): ?array
    {
        $tools = self::all();
        if (!isset($tools[$slug])) {
            return null;
        }
        $tool = $tools[$slug];
        $tool['slug'] = $slug;

        return $tool;
    }

    /** @return array<string,array<string,mixed>> */
    public static function byCategory(string $category): array
    {
        return array_filter(self::all(), static fn (array $t): bool => $category === 'all' || $t['category'] === $category);
    }
}
