<?php

return [
    /**
     * set the default path for the blogs homepage.
     */
    'path' => 'bolt',

    /**
     * the middleware you want to apply on all the blogs routes
     * for example if you want to make your blog for users only, add the middleware 'auth'.
     */
    'middleware' => ['web'],

    /**
     * set the prefix for forms URL.
     */
    'post_uri_prefix' => 'form',

    'layout' => 'zeus::components.app',

    /**
     * this will be setup the default seo site title. read more about it in 'laravel-seo'.
     */
    'site_title' => config('app.name', 'Laravel').' | Blogs',

    /**
     * this will be setup the default seo site description. read more about it in 'laravel-seo'.
     */
    'site_description' => 'All about '.config('app.name', 'Laravel').' Blogs',

    /**
     * this will be setup the default seo site color theme. read more about it in 'laravel-seo'.
     */
    'site_color' => '#F5F5F4',

    'uploads' => [
        'disk' => 'public',
        'directory' => 'logos',
    ],

    /**
     * available locales, this currently used only in tags manager.
     */
    'translatable_Locales' => ['en', 'ar'],
];
