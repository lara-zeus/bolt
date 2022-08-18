---
title: Configuration
weight: 3
---

## Configuration

to publish the config file run the command:

```bash
php artisan vendor:publish --tag=zeus-sky-config
```

you can pass `--force` option to force publishing the config file

the config file will contain the following:

```php
return [
    /**
     * set the default path for the blogs homepage
     */
    'path' => 'blog',

    /**
     * the middleware you want to apply on all the blogs routes
     * for example if you want to make your blog for users only, add the middleware 'auth'
     */
    'middleware' => ['web'],

    /**
     * set the prefix for posts URL.
     */
    'post_uri_prefix' => 'post',

    /**
     * set the prefix for pages URL.
     */
    'page_uri_prefix' => 'page',

    /**
     * enable or disable individual Resources.
     */
    'enabled_resources' => [
        LaraZeus\Sky\Filament\Resources\PostResource::class,
        LaraZeus\Sky\Filament\Resources\PageResource::class,
        LaraZeus\Sky\Filament\Resources\TagResource::class,
        LaraZeus\Sky\Filament\Resources\FaqResource::class,
    ],
    
    /**
     * this will be setup the default seo site title. read more about it in 'laravel-seo'
     */
    'site_title' => config('app.name', 'Laravel').' | '.'Blogs',

    /**
     * this will be setup the default seo site description. read more about it in 'laravel-seo'
     */
    'site_description' => 'All about '.config('app.name', 'Laravel').' Blogs',

    /**
     * this will be setup the default seo site color theme. read more about it in 'laravel-seo'
     */
    'site_color' => '#F5F5F4',

    /**
     * you can use the default layout as a starting point for your blog.
     * however, if you're already using your own component, just set the path here
     */
    'layout' => 'zeus::components.app',

    /**
     * the default theme, for now we only have one theme, and soon we will provide more free and premium themes.
     */
    'theme' => 'zeus',

    /**
     * available locales, this currently used only in tags manager.
     */
    'translatable_Locales' => ['en','ar'],
];
```
