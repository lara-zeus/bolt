---
title: Sharing & Embedding
weight: 5
---

# Sharing a Form:

Bolt Pro will provide your users with a new tab, that let them share the form to social media and other webpages very easily.

To customize the social media sharing icons or use any other widget, create the file:
`resources/views/vendor/zeus/filament/social-share.blade.php`.

And add any social platform you want.

## Embedding a Form

The embed forms will be accessible from the route name `bolt.form.embed` and 
the url is; `/bolt/embed/$form->slug`

To customize the layout you can create the file:
`resources/views/vendor/zeus/filament/embed-layout.blade.php`

The default content is:

```html
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ __('filament-panels::layout.direction') ?? 'ltr' }}" class="antialiased filament js-focus-visible">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="application-name" content="{{ config('app.name', 'Laravel') }}">

    <!-- Seo Tags -->
    <x-seo::meta/>
    <!-- Seo Tags -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&family=KoHo:ital,wght@0,200;0,300;0,500;0,700;1,200;1,300;1,600;1,700&display=swap" rel="stylesheet">

    @livewireStyles
    @filamentStyles
    @stack('styles')

    <link rel="stylesheet" href="{{ asset('vendor/zeus/frontend.css') }}">

    <style>
        * {font-family: 'KoHo', 'Almarai', sans-serif;}
        [x-cloak] {display: none !important;}
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 dark:text-gray-100 dark:bg-gray-900 @if(app()->isLocal()) debug-screens @endif">

<div class="container mx-auto my-6">
    {{ $slot }}
</div>

@stack('scripts')
@livewireScripts
@filamentScripts
@livewire('notifications')

<script>
    const theme = localStorage.getItem('theme')

    if ((theme === 'dark') || (! theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark')
    }
</script>

</body>
</html>
```