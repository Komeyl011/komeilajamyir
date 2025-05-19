<?php

/**
 * This file is used for the translations related to the resources labels and relative needed text in filament panel
 */

return [
    'groups' => [
        'users' => 'Users',
        'main' => 'Main page',
        'blog' => 'Blog',
        'telegram_bot' => 'Telegram bot',
        'fd_topics' => 'Free discussion topics',
    ],

    'user' => [
        'label' => 'User',
        'plural_label' => 'Users',
        'model_label' => 'User',
        'role' => 'User roles',
        'table' => [
            'name' => [
                'type' => 'text',
                'required' => true,
                'label' => 'name',
            ],
            'email' => [
                'type' => 'email',
                'required' => true,
                'label' => 'email',
            ],
            'role' => [
                'type' => 'text',
                'label' => 'role',
            ],
            'avatar' => [
                'type' => 'image',
                'required' => true,
                'label' => 'avatar',
            ],
            'email_verified' => [
                'type' => 'bool_badge',
                'required' => true,
                'label' => 'is verified',
            ],
            'password' => [
                'type' => 'password',
                'required' => true,
                'label' => 'Password',
            ],
        ],
        'profile' => [
            'label' => 'User profile',
            'plural_label' => 'User profile',
            'model_label' => 'User profile',
            'form' => [
                'user_not_model_instance' => 'The authenticated user object must be an Eloquent model to allow the profile page to update it.',
                'info_section_heading' => 'Account info',
                'info_section' => [
                    'heading' => 'Account info',
                    'description' => 'Update your account\'s profile information and email address.',
                    'verify_email' => 'Verify your email',
                ],
                'password_section' => [
                    'heading' => 'Update Password',
                    'description' => 'Ensure your account is using long, random password to stay secure.',
                    'current_pwd' => 'Current password',
                    'new_pwd' => 'New password',
                    'pwd_confirmation' => 'Password confirmation',
                ],
            ],
        ],
    ],

    'role' => [
        'label' => 'Role',
        'plural_label' => 'Roles',
        'model_label' => 'Role',
        'table' => [
            'name' => [
                'type' => 'text',
                'required' => true,
                'label' => 'name',
            ],
            'guard_name' => [
                'type' => 'text',
                'required' => true,
                'label' => 'guard name',
            ],
        ],
    ],

    'permission' => [
        'label' => 'Permission',
        'plural_label' => 'Permissions',
        'model_label' => 'Permission',
        'table' => [
            'name' => [
                'type' => 'text',
                'required' => true,
                'label' => 'name',
            ],
            'guard_name' => [
                'type' => 'text',
                'required' => true,
                'label' => 'guard name',
            ],
        ],
    ],

    'about-me' => [
        'label' => 'About me',
        'plural_label' => 'About me',
        'model_label' => 'About me',
        'table' => [
            'image' => [
                'type' => 'image',
                'required' => true,
                'label' => 'image',
            ],
            'description_translated' => [
                'type' => 'richtext_json',
                'required' => true,
                'label' => 'description',
            ],
            'active' => [
                'type' => 'bool_badge',
                'required' => true,
                'label' => 'active',
            ],
        ],
    ],

    'category' => [
        'label' => 'Category',
        'plural_label' => 'Categories',
        'model_label' => 'Category',
        'table' => [
            'name_translated' => [
                'type' => 'text',
                'required' => true,
                'label' => 'name',
            ],
            'name' => [
                'type' => 'ignore',
                'required' => true,
                'label' => 'name',
            ],
            'slug' => [
                'type' => 'text',
                'required' => true,
                'label' => 'slug',
            ],
        ],
    ],

    'chat-bot-user' => [
        'label' => 'ChatBot user',
        'plural_label' => 'ChatBot users',
        'model_label' => 'ChatBot user',
        'table' => [
            'chat_id' => [
                'type' => 'text',
                'label' => 'Chat ID',
            ],
            'username' => [
                'type' => 'text',
                'label' => 'Username',
            ],
            'is_bot' => [
                'type' => 'bool_badge',
                'label' => 'Is bot',
            ],
            'is_premium' => [
                'type' => 'bool_badge',
                'label' => 'Is premium',
            ],
            'has_subscription' => [
                'type' => 'bool_badge',
                'label' => 'has subscription',
            ],
            'balance' => [
                'type' => 'text',
                'label' => 'account balance',
            ],
            'remaining_requests_count' => [
                'type' => 'text',
                'label' => 'remaining requests',
            ],
        ],
    ],

    'contact-form' => [
        'label' => 'Contact request',
        'plural_label' => 'Contact requests',
        'model_label' => 'Contact request',
        'table' => [
            'name' => [
                'type' => 'text',
                'label' => 'name',
            ],
            'email' => [
                'type' => 'text',
                'label' => 'email',
            ],
            'subject' => [
                'type' => 'text',
                'label' => 'subject',
            ],
            'message' => [
                'type' => 'text',
                'label' => 'message',
            ],
            'priority' => [
                'type' => 'text_badge',
                'enum' => \App\Enum\Priority::class,
                'label' => 'priority',
            ],
            'answered' => [
                'type' => 'bool_badge',
                'label' => 'answered',
            ],
            'locale' => [
                'type' => 'text',
                'label' => 'Locale',
            ],
            'created_at' => [
                'type' => 'text',
                'label' => 'Submitted at',
            ],
            'updated_at' => [
                'type' => 'text',
                'label' => 'Answered at',
            ],
        ],
        'reply_action' => [
            'label' => 'Respond',
            'color' => 'success',
            'icon' => 'heroicon-c-chat-bubble-bottom-center-text',
            'message' => 'message',
            'modal_heading' => 'Send a reply',
            'modal_submit_action' => 'send',
        ],
    ],

    'contact-info' => [
        'label' => 'Contact info',
        'plural_label' => 'Contact info',
        'model_label' => 'Contact info',
        'table' => [
            'platform' => [
                'type' => 'text',
                'required' => true,
                'label' => 'platform',
            ],
            'icon' => [
                'type' => 'text',
                'required' => true,
                'label' => 'Icon (font awesome)',
            ],
            'url' => [
                'type' => 'text',
                'required' => true,
                'label' => 'Profile url',
            ],
        ],
    ],

    'experience' => [
        'label' => 'experience',
        'plural_label' => 'experiences',
        'model_label' => 'experience',
        'table' => [
            'job_title_translated' => [
                'type' => 'text_json',
                'required' => true,
                'label' => 'title',
            ],
            'company_translated' => [
                'type' => 'text_json',
                'required' => true,
                'label' => 'company',
            ],
            'from' => [
                'type' => 'date',
                'required' => true,
                'label' => 'start date',
            ],
            'to' => [
                'type' => 'date',
                'required' => true,
                'label' => 'end date',
            ],
            'description_translated' => [
                'type' => 'textarea_json',
                'required' => true,
                'label' => 'description',
            ],
        ],
    ],

    'portfolio' => [
        'label' => 'portfolio',
        'plural_label' => 'portfolio',
        'model_label' => 'portfolio',
        'table' => [
            'thumbnail' => [
                'type' => 'image',
                'required' => true,
                'label' => 'thumbnail',
            ],
            'title_translated' => [
                'type' => 'text_json',
                'required' => true,
                'label' => 'title',
            ],
            'description_translated' => [
                'type' => 'textarea_json',
                'required' => true,
                'label' => 'description',
            ],
            'slug' => [
                'type' => 'text',
                'required' => true,
                'label' => 'slug',
            ],
        ],
    ],

    'post' => [
        'label' => 'post',
        'plural_label' => 'posts',
        'model_label' => 'post',
        'table' => [
            'author.name' => [
                'type' => 'text',
                'required' => true,
                'label' => 'author',
            ],
            'category.name_translated' => [
                'type' => 'text',
                'required' => true,
                'label' => 'category',
            ],
            'category' => [
                'type' => 'ignore',
                'label' => 'category',
            ],
            'title_translated' => [
                'type' => 'text_json',
                'required' => true,
                'label' => 'title',
            ],
            'seo_title_translated' => [
                'type' => 'text_json',
                'required' => true,
                'label' => 'title (SEO)',
            ],
            'image' => [
                'type' => 'image',
                'required' => true,
                'label' => 'image',
            ],
            'slug' => [
                'type' => 'text',
                'required' => true,
                'label' => 'slug',
            ],
            'meta_description_translated' => [
                'type' => 'text_json',
                'required' => true,
                'label' => 'meta description',
            ],
            'meta_keywords_translated' => [
                'type' => 'text_json',
                'required' => true,
                'label' => 'meta keywords',
            ],
            'status' => [
                'type' => 'text_badge',
                'enum' => \App\Enum\PublishStatus::class,
                'required' => true,
                'label' => 'publish status',
            ],
        ],
    ],

    'post-translation' => [
        'label' => 'post translation',
        'plural_label' => 'post translations',
        'model_label' => 'post translation',
        'table' => [
            'post.title_translated' => [
                'type' => 'text',
                'label' => 'post',
            ],
            'post' => [
                'type' => 'ignore',
                'label' => 'post',
            ],
            'locale' => [
                'type' => 'text',
                'required' => true,
                'label' => 'locale',
            ],
            'excerpt' => [
                'type' => 'textarea',
                'required' => true,
                'label' => 'excerpt',
            ],
            'body' => [
                'type' => 'richtext',
                'required' => true,
                'label' => 'body',
            ],
        ],
    ],

    'skill' => [
        'label' => 'skill',
        'plural_label' => 'skills',
        'model_label' => 'skill',
        'table' => [
            'skill_name' => [
                'type' => 'text',
                'required' => true,
                'label' => 'skill',
            ],
            'proficiency' => [
                'type' => 'number',
                'required' => true,
                'label' => 'proficiency',
            ],
        ],
    ],

    'fd-topic' => [
        'label' => 'FreeDiscussion topic',
        'plural_label' => 'FreeDiscussion topics',
        'model_label' => 'FreeDiscussion topic',
        'table' => [
            'name' => [
                'type' => 'text',
                'required' => true,
                'label' => 'name',
            ],
            'type' => [
                'type' => 'text_badge',
                'enum' => \App\Enum\FdTypes::class,
                'required' => true,
                'label' => 'type',
            ],
            'description' => [
                'type' => 'richtext',
                'required' => true,
                'label' => 'description',
            ],
        ],
    ],
];
