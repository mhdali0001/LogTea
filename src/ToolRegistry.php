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

            'watermark-pdf' => [
                'category'  => 'pdf',
                'icon'      => 'watermark',
                'name_ar'   => 'إضافة علامة مائية إلى PDF',
                'name_en'   => 'Watermark PDF',
                'desc_ar'   => 'اطبع نصاً شفافاً مثل «سري» أو اسم شركتك على كل صفحات الملف',
                'desc_en'   => 'Stamp a transparent text such as "Confidential" or your company name on every page',
                'accept'    => ['pdf'],
                'multiple'  => false,
                'options'   => [
                    ['name' => 'text', 'type' => 'text', 'label_ar' => 'نص العلامة المائية', 'label_en' => 'Watermark text', 'default' => ''],
                    ['name' => 'layout', 'type' => 'select', 'label_ar' => 'اتجاه النص', 'label_en' => 'Text direction', 'default' => 'diagonal', 'choices' => [
                        ['value' => 'diagonal', 'label_ar' => 'مائل عبر الصفحة', 'label_en' => 'Diagonal across the page'],
                        ['value' => 'horizontal', 'label_ar' => 'أفقي في المنتصف', 'label_en' => 'Horizontal, centered'],
                    ]],
                    ['name' => 'opacity', 'type' => 'range', 'label_ar' => 'درجة وضوح العلامة', 'label_en' => 'Watermark opacity', 'min' => 5, 'max' => 100, 'default' => 25],
                ],
                'class' => Tools\WatermarkPdfTool::class,
            ],

            'remove-pdf-pages' => [
                'category'  => 'pdf',
                'icon'      => 'trash',
                'name_ar'   => 'حذف صفحات من PDF',
                'name_en'   => 'Remove PDF Pages',
                'desc_ar'   => 'احذف الصفحات غير المرغوبة من ملف PDF واحتفظ بالباقي',
                'desc_en'   => 'Delete unwanted pages from a PDF and keep the rest',
                'accept'    => ['pdf'],
                'multiple'  => false,
                'options'   => [
                    ['name' => 'pages', 'type' => 'text', 'label_ar' => "الصفحات المراد حذفها (مثال: \u{2066}2,5-7\u{2069})", 'label_en' => 'Pages to remove (e.g. 2,5-7)', 'default' => ''],
                ],
                'class' => Tools\RemovePagesTool::class,
            ],

            'organize-pdf' => [
                'category'  => 'pdf',
                'icon'      => 'reorder',
                'name_ar'   => 'ترتيب صفحات PDF',
                'name_en'   => 'Organize PDF',
                'desc_ar'   => 'أعد ترتيب صفحات الملف كما تريد أو اعكس ترتيبها بالكامل',
                'desc_en'   => 'Put the pages in any order you want, or reverse them all',
                'accept'    => ['pdf'],
                'multiple'  => false,
                'options'   => [
                    ['name' => 'mode', 'type' => 'select', 'label_ar' => 'طريقة الترتيب', 'label_en' => 'Ordering', 'default' => 'custom', 'choices' => [
                        ['value' => 'custom', 'label_ar' => 'ترتيب مخصص', 'label_en' => 'Custom order'],
                        ['value' => 'reverse', 'label_ar' => 'عكس ترتيب كل الصفحات', 'label_en' => 'Reverse all pages'],
                    ]],
                    ['name' => 'order', 'type' => 'text', 'label_ar' => "الترتيب الجديد (مثال: \u{2066}3,1,2,4-6\u{2069})", 'label_en' => 'New order (e.g. 3,1,2,4-6)', 'default' => '', 'depends_on' => ['mode' => 'custom']],
                ],
                'class' => Tools\OrganizePdfTool::class,
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

            'pdf-to-text' => [
                'category'  => 'convert',
                'icon'      => 'text',
                'name_ar'   => 'استخراج النص من PDF',
                'name_en'   => 'PDF to Text',
                'desc_ar'   => 'انسخ كل نصوص ملف PDF إلى ملف نصي TXT جاهز للتعديل',
                'desc_en'   => 'Pull all the text out of a PDF into an editable TXT file',
                'accept'    => ['pdf'],
                'multiple'  => false,
                'options'   => [],
                'class' => Tools\PdfToTextTool::class,
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

            'resize-image' => [
                'category'  => 'image',
                'icon'      => 'resize',
                'name_ar'   => 'تغيير حجم الصور',
                'name_en'   => 'Resize Images',
                'desc_ar'   => 'غيّر أبعاد صورك بالبكسل أو بنسبة مئوية مع الحفاظ على تناسبها',
                'desc_en'   => 'Change image dimensions in pixels or by percentage, keeping the proportions',
                'accept'    => ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp'],
                'multiple'  => true,
                'options'   => [
                    ['name' => 'mode', 'type' => 'select', 'label_ar' => 'طريقة التغيير', 'label_en' => 'Resize by', 'default' => 'percent', 'choices' => [
                        ['value' => 'percent', 'label_ar' => 'نسبة مئوية', 'label_en' => 'Percentage'],
                        ['value' => 'size', 'label_ar' => 'أبعاد بالبكسل', 'label_en' => 'Pixel dimensions'],
                    ]],
                    ['name' => 'percent', 'type' => 'number', 'label_ar' => 'النسبة المئوية من الحجم الأصلي', 'label_en' => 'Percentage of the original size', 'default' => '50', 'depends_on' => ['mode' => 'percent']],
                    ['name' => 'width', 'type' => 'number', 'label_ar' => 'العرض (بكسل)', 'label_en' => 'Width (px)', 'default' => '', 'depends_on' => ['mode' => 'size']],
                    ['name' => 'height', 'type' => 'number', 'label_ar' => 'الارتفاع (بكسل) — اختياري', 'label_en' => 'Height (px) — optional', 'default' => '', 'depends_on' => ['mode' => 'size']],
                ],
                'class' => Tools\ResizeImageTool::class,
            ],

            'convert-image' => [
                'category'  => 'image',
                'icon'      => 'convert',
                'name_ar'   => 'تحويل صيغة الصور',
                'name_en'   => 'Convert Images',
                'desc_ar'   => 'حوّل صورك بين JPG وPNG وWebP، ومن GIF وBMP',
                'desc_en'   => 'Convert images between JPG, PNG and WebP, and from GIF and BMP',
                'accept'    => ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp'],
                'multiple'  => true,
                'options'   => [
                    ['name' => 'format', 'type' => 'select', 'label_ar' => 'الصيغة المطلوبة', 'label_en' => 'Target format', 'default' => 'jpg', 'choices' => [
                        ['value' => 'jpg', 'label_ar' => 'JPG', 'label_en' => 'JPG'],
                        ['value' => 'png', 'label_ar' => 'PNG', 'label_en' => 'PNG'],
                        ['value' => 'webp', 'label_ar' => 'WebP', 'label_en' => 'WebP'],
                    ]],
                ],
                'class' => Tools\ConvertImageTool::class,
            ],

            'crop-image' => [
                'category'  => 'image',
                'icon'      => 'crop',
                'name_ar'   => 'قص الصور',
                'name_en'   => 'Crop Images',
                'desc_ar'   => 'قص صورك بمقاسات جاهزة لإنستغرام والستوري ويوتيوب',
                'desc_en'   => 'Crop images to ready-made ratios for Instagram, stories and YouTube',
                'accept'    => ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp'],
                'multiple'  => true,
                'options'   => [
                    ['name' => 'ratio', 'type' => 'select', 'label_ar' => 'نسبة القص', 'label_en' => 'Aspect ratio', 'default' => '1:1', 'choices' => [
                        ['value' => '1:1', 'label_ar' => '1:1 — مربع (منشور إنستغرام، صورة شخصية)', 'label_en' => '1:1 — Square'],
                        ['value' => '4:5', 'label_ar' => '4:5 — منشور إنستغرام عمودي', 'label_en' => '4:5 — Instagram portrait'],
                        ['value' => '9:16', 'label_ar' => '9:16 — ستوري وريلز وتيك توك', 'label_en' => '9:16 — Stories & Reels'],
                        ['value' => '16:9', 'label_ar' => '16:9 — يوتيوب والشاشات العريضة', 'label_en' => '16:9 — YouTube & widescreen'],
                        ['value' => '4:3', 'label_ar' => '4:3 — أفقي كلاسيكي', 'label_en' => '4:3 — Classic landscape'],
                        ['value' => '3:4', 'label_ar' => '3:4 — عمودي كلاسيكي', 'label_en' => '3:4 — Classic portrait'],
                        ['value' => '3:2', 'label_ar' => '3:2 — صور الكاميرا الأفقية', 'label_en' => '3:2 — Camera landscape'],
                        ['value' => '2:3', 'label_ar' => '2:3 — صور الكاميرا العمودية', 'label_en' => '2:3 — Camera portrait'],
                    ]],
                ],
                'class' => Tools\CropImageTool::class,
            ],

            'rotate-image' => [
                'category'  => 'image',
                'icon'      => 'rotate',
                'name_ar'   => 'تدوير الصور وقلبها',
                'name_en'   => 'Rotate & Flip Images',
                'desc_ar'   => 'دوّر صورك 90° أو 180° أو اقلبها أفقياً وعمودياً',
                'desc_en'   => 'Rotate images by 90° or 180°, or flip them horizontally and vertically',
                'accept'    => ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp'],
                'multiple'  => true,
                'options'   => [
                    ['name' => 'action', 'type' => 'select', 'label_ar' => 'العملية', 'label_en' => 'Action', 'default' => 'right', 'choices' => [
                        ['value' => 'right', 'label_ar' => 'تدوير 90° يمين', 'label_en' => 'Rotate 90° clockwise'],
                        ['value' => 'left', 'label_ar' => 'تدوير 90° يسار', 'label_en' => 'Rotate 90° counter-clockwise'],
                        ['value' => '180', 'label_ar' => 'تدوير 180°', 'label_en' => 'Rotate 180°'],
                        ['value' => 'flip-h', 'label_ar' => 'قلب أفقي (مرآة)', 'label_en' => 'Flip horizontally (mirror)'],
                        ['value' => 'flip-v', 'label_ar' => 'قلب عمودي', 'label_en' => 'Flip vertically'],
                    ]],
                ],
                'class' => Tools\RotateImageTool::class,
            ],

            'favicon-generator' => [
                'category'  => 'image',
                'icon'      => 'browser',
                'name_ar'   => 'صانع أيقونة الموقع Favicon',
                'name_en'   => 'Favicon Generator',
                'desc_ar'   => 'حوّل شعارك إلى أيقونة موقع favicon.ico بكل المقاسات المطلوبة',
                'desc_en'   => 'Turn your logo into a favicon.ico and every icon size browsers need',
                'accept'    => ['jpg', 'jpeg', 'png', 'webp'],
                'multiple'  => false,
                'options'   => [
                    ['name' => 'fit', 'type' => 'select', 'label_ar' => 'ملاءمة الصورة للمربع', 'label_en' => 'Fit to square', 'default' => 'contain', 'choices' => [
                        ['value' => 'contain', 'label_ar' => 'الصورة كاملة مع خلفية شفافة', 'label_en' => 'Whole image on a transparent background'],
                        ['value' => 'cover', 'label_ar' => 'قص المنتصف ليملأ المربع', 'label_en' => 'Crop the center to fill the square'],
                    ]],
                ],
                'class' => Tools\FaviconTool::class,
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

            'csv-to-excel' => [
                'category'  => 'convert',
                'icon'      => 'csv',
                'name_ar'   => 'تحويل CSV إلى Excel',
                'name_en'   => 'CSV to Excel',
                'desc_ar'   => 'حوّل ملفات CSV إلى جدول Excel منسّق يدعم العربية',
                'desc_en'   => 'Turn CSV files into a tidy Excel spreadsheet with full Arabic support',
                'accept'    => ['csv'],
                'multiple'  => false,
                'options'   => [],
                'class' => Tools\CsvToExcelTool::class,
            ],

            'excel-to-csv' => [
                'category'  => 'convert',
                'icon'      => 'csv',
                'name_ar'   => 'تحويل Excel إلى CSV',
                'name_en'   => 'Excel to CSV',
                'desc_ar'   => 'صدّر أوراق Excel إلى ملفات CSV جاهزة للاستيراد في أي نظام',
                'desc_en'   => 'Export Excel sheets to CSV files ready to import into any system',
                'accept'    => ['xlsx', 'xls'],
                'multiple'  => false,
                'options'   => [
                    ['name' => 'delimiter', 'type' => 'select', 'label_ar' => 'الفاصل بين الأعمدة', 'label_en' => 'Column separator', 'default' => 'comma', 'choices' => [
                        ['value' => 'comma', 'label_ar' => 'فاصلة ( , )', 'label_en' => 'Comma ( , )'],
                        ['value' => 'semicolon', 'label_ar' => 'فاصلة منقوطة ( ; )', 'label_en' => 'Semicolon ( ; )'],
                        ['value' => 'tab', 'label_ar' => 'مسافة جدولة (Tab)', 'label_en' => 'Tab'],
                    ]],
                ],
                'class' => Tools\ExcelToCsvTool::class,
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
