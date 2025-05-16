<?php

/**
 * This file is used for the translations related to the resources labels and relative needed text in filament panel
 */

return [
    'groups' => [
        'users' => 'کاربران',
        'main' => 'صفحه اصلی',
        'blog' => 'بلاگ',
        'telegram_bot' => 'ربات تلگرام',
        'fd_topics' => 'موضوعات فری دیسکاشن',
    ],

    'user' => [
        'label' => 'کاربر',
        'plural_label' => 'کاربران',
        'model_label' => 'کاربر',
        'role' => 'نقش‌های کاربر',
        'table' => [
            'name' => [
                'type' => 'text',
                'required' => true,
                'label' => 'نام',
            ],
            'email' => [
                'type' => 'email',
                'required' => true,
                'label' => 'ایمیل',
            ],
            'role' => [
                'type' => 'text',
                'label' => 'نقش',
            ],
            'avatar' => [
                'type' => 'image',
                'required' => true,
                'label' => 'آواتار',
            ],
            'email_verified' => [
                'type' => 'bool_badge',
                'required' => true,
                'label' => 'تایید ایمیل',
            ],
            'password' => [
                'type' => 'password',
                'required' => true,
                'label' => 'کلمه عبور',
            ],
        ],
        'profile' => [
            'label' => 'پروفایل',
            'plural_label' => 'پروفایل',
            'model_label' => 'پروفایل',
            'form' => [
                'user_not_model_instance' => 'کاربر فعلی باید یک موجودیت از مدل باشد.',
                'info_section' => [
                    'heading' => 'اطلاعات حساب',
                    'description' => 'تغییر اطلاعات حساب: نام، ایمیل، عکس پروفایل',
                    'verify_email' => 'تایید ایمیل',
                ],
                'password_section' => [
                    'heading' => 'تغییر کلمه عبور',
                    'description' => 'برای امنیت بیشتر حساب کاربری خود رمزی امن و طولانی که در جای دیگری استفاده نکرده‌اید انتخاب کنید.',
                    'current_pwd' => 'کلمه عبور فعلی',
                    'new_pwd' => 'کلمه عبور جدید',
                    'pwd_confirmation' => 'تایید کلمه عبور',
                ],
            ],
        ],
    ],

    'role' => [
        'label' => 'نقش',
        'plural_label' => 'نقش‌ها',
        'model_label' => 'نقش',
        'table' => [
            'name' => [
                'type' => 'text',
                'required' => true,
                'label' => 'نام',
            ],
            'guard_name' => [
                'type' => 'text',
                'required' => true,
                'label' => 'نام محافظ',
            ],
        ],
    ],

    'permission' => [
        'label' => 'مجوز',
        'plural_label' => 'مجوزها',
        'model_label' => 'مجوز',
        'table' => [
            'name' => [
                'type' => 'text',
                'required' => true,
                'label' => 'نام',
            ],
            'guard_name' => [
                'type' => 'text',
                'required' => true,
                'label' => 'نام محافظ',
            ],
        ],
    ],

    'about-me' => [
        'label' => 'درباره من',
        'plural_label' => 'درباره من',
        'model_label' => 'درباره من',
        'table' => [
            'image' => [
                'type' => 'image',
                'required' => true,
                'label' => 'تصویر',
            ],
            'description_translated' => [
                'type' => 'richtext_json',
                'required' => true,
                'label' => 'توضیحات',
            ],
            'active' => [
                'type' => 'bool_badge',
                'required' => true,
                'label' => 'فعال',
            ],
        ],
    ],

    'category' => [
        'label' => 'دسته‌بندی',
        'plural_label' => 'دسته‌بندی‌ها',
        'model_label' => 'دسته‌بندی',
        'table' => [
            'name' => [
                'type' => 'text',
                'required' => true,
                'label' => 'نام',
            ],
            'slug' => [
                'type' => 'text',
                'required' => true,
                'label' => 'نام مستعار',
            ],
        ],
    ],

    'chat-bot-user' => [
        'label' => 'کاربر چت‌بات',
        'plural_label' => 'کاربران چت‌بات',
        'model_label' => 'کاربر چت‌بات',
        'table' => [
            'chat_id' => [
                'type' => 'text',
                'label' => 'آی‌دی چت',
            ],
            'username' => [
                'type' => 'text',
                'label' => 'نام کاربری',
            ],
            'is_bot' => [
                'type' => 'bool_badge',
                'label' => 'ربات',
            ],
            'is_premium' => [
                'type' => 'bool_badge',
                'label' => 'پریمیوم',
            ],
            'has_subscription' => [
                'type' => 'bool_badge',
                'label' => 'دارای اشتراک',
            ],
            'balance' => [
                'type' => 'text',
                'label' => 'موجودی حساب',
            ],
            'remaining_requests_count' => [
                'type' => 'text',
                'label' => 'تعداد درخواست‌های باقی‌مانده',
            ],
        ],
    ],

    'contact-form' => [
        'label' => 'درخواست تماس',
        'plural_label' => 'درخواست‌های تماس',
        'model_label' => 'درخواست تماس',
        'table' => [
            'name' => [
                'type' => 'text',
                'label' => 'نام',
            ],
            'email' => [
                'type' => 'text',
                'label' => 'ایمیل',
            ],
            'subject' => [
                'type' => 'text',
                'label' => 'موضوع',
            ],
            'message' => [
                'type' => 'text',
                'label' => 'متن درخواست',
            ],
            'priority' => [
                'type' => 'text_badge',
                'enum' => \App\Enum\Priority::class,
                'label' => 'اولویت',
            ],
            'answered' => [
                'type' => 'bool_badge',
                'label' => 'پاسخ داده شده',
            ],
            'locale' => [
                'type' => 'text',
                'label' => 'زبان',
            ],
            'created_at' => [
                'type' => 'text',
                'label' => 'زمان ثبت',
            ],
            'updated_at' => [
                'type' => 'text',
                'label' => 'زمان پاسخ',
            ],
        ],
        'reply_action' => [
            'label' => 'پاسخ',
            'color' => 'success',
            'icon' => 'heroicon-c-chat-bubble-bottom-center-text',
            'message' => 'پیام',
            'modal_heading' => 'پاسخ به درخواست',
            'modal_submit_action' => 'ارسال',
        ],
    ],

    'contact-info' => [
        'label' => 'اطلاعات تماس',
        'plural_label' => 'اطلاعات تماس',
        'model_label' => 'اطلاعات تماس',
        'table' => [
            'platform' => [
                'type' => 'text',
                'required' => true,
                'label' => 'پلتفرم',
            ],
            'icon' => [
                'type' => 'text',
                'required' => true,
                'label' => 'آیکون (fontawesome)',
            ],
            'url' => [
                'type' => 'text',
                'required' => true,
                'label' => 'آدرس پروفایل',
            ],
        ],
    ],

    'experience' => [
        'label' => 'تجربه کاری',
        'plural_label' => 'تجربه‌های کاری',
        'model_label' => 'تجربه کاری',
        'table' => [
            'job_title_translated' => [
                'type' => 'text_json',
                'required' => true,
                'label' => 'عنوان شغلی',
            ],
            'company_translated' => [
                'type' => 'text_json',
                'required' => true,
                'label' => 'کمپانی',
            ],
            'from' => [
                'type' => 'date',
                'required' => true,
                'label' => 'تاریخ شروع',
            ],
            'to' => [
                'type' => 'date',
                'required' => true,
                'label' => 'تاریخ پایان',
            ],
            'description_translated' => [
                'type' => 'textarea_json',
                'required' => true,
                'label' => 'توضیحات',
            ],
        ],
        'form' => [
            'section' => [
                'job_title' => 'عنوان شغلی',
                'company' => 'شرکت',
                'description' => 'توضیحات',
            ],
        ],
    ],

    'portfolio' => [
        'label' => 'پورتفولیو',
        'plural_label' => 'پورتفولیو',
        'model_label' => 'پورتفولیو',
        'table' => [
            'thumbnail' => [
                'type' => 'image',
                'required' => true,
                'label' => 'تصویر',
            ],
            'title_translated' => [
                'type' => 'text_json',
                'required' => true,
                'label' => 'عنوان',
            ],
            'description_translated' => [
                'type' => 'textarea_json',
                'required' => true,
                'label' => 'توضیحات',
            ],
            'slug' => [
                'type' => 'text',
                'required' => true,
                'label' => 'آدرس',
            ],
        ],
    ],

    'post' => [
        'label' => 'پست',
        'plural_label' => 'پست‌ها',
        'model_label' => 'پست',
        'table' => [
            'author.name' => [
                'type' => 'text',
                'required' => true,
                'label' => 'نویسنده',
            ],
            'category.name' => [
                'type' => 'text',
                'required' => true,
                'label' => 'دسته بندی',
            ],
            'category' => [
                'type' => 'ignore',
                'label' => 'دسته بندی',
            ],
            'title_translated' => [
                'type' => 'text',
                'required' => true,
                'label' => 'عنوان',
            ],
            'seo_title_translated' => [
                'type' => 'text',
                'required' => true,
                'label' => 'عنوان (SEO)',
            ],
            'image' => [
                'type' => 'image',
                'required' => true,
                'label' => 'تصویر',
            ],
            'slug' => [
                'type' => 'text',
                'required' => true,
                'label' => 'آدرس',
            ],
            'meta_description_translated' => [
                'type' => 'text',
                'required' => true,
                'label' => 'توضیحات متا',
            ],
            'meta_keywords_translated' => [
                'type' => 'text',
                'required' => true,
                'label' => 'کلمات کلیدی متا',
            ],
            'status' => [
                'type' => 'text_badge',
                'enum' => \App\Enum\PublishStatus::class,
                'required' => true,
                'label' => 'وضعیت انتشار',
            ],
        ],
    ],

    'post-translation' => [
        'label' => 'ترجمه پست',
        'plural_label' => 'ترجمه پست‌ها',
        'model_label' => 'ترجمه پست',
        'table' => [
            'post.title_translated' => [
                'type' => 'text',
                'label' => 'پست',
            ],
            'post' => [
                'type' => 'ignore',
                'label' => 'پست',
            ],
            'locale' => [
                'type' => 'text',
                'required' => true,
                'label' => 'زبان',
            ],
            'excerpt' => [
                'type' => 'textarea',
                'required' => true,
                'label' => 'مقدمه',
            ],
            'body' => [
                'type' => 'richtext',
                'required' => true,
                'label' => 'بدنه متن',
            ],
        ],
    ],

    'skill' => [
        'label' => 'مهارت',
        'plural_label' => 'مهارت‌ها',
        'model_label' => 'مهارت',
        'table' => [
            'skill_name' => [
                'type' => 'text',
                'required' => true,
                'label' => 'مهارت',
            ],
            'proficiency' => [
                'type' => 'number',
                'required' => true,
                'label' => 'تخصص',
            ],
        ],
    ],

    'fd-topic' => [
        'label' => 'موضوع فری دیسکاشن',
        'plural_label' => 'موضوعات فری دیسکاشن',
        'model_label' => 'موضوع فری دیسکاشن',
        'table' => [
            'name' => [
                'type' => 'text',
                'required' => true,
                'label' => 'نام',
            ],
            'type' => [
                'type' => 'text_badge',
                'enum' => \App\Enum\FdTypes::class,
                'required' => true,
                'label' => 'نوع',
            ],
            'description' => [
                'type' => 'richtext',
                'required' => true,
                'label' => 'توضیحات',
            ],
        ],
    ],
];
