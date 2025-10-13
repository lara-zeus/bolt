<?php

return [
    /**
     * set the default domain.
     */
    'domain' => null,

    /**
     * set the default path for the forms homepage.
     */
    'prefix' => 'bolt',

    /*
     * set database table prefix
     */
    'table-prefix' => 'bolt_',

    /**
     * the middleware you want to apply on all the blog routes
     * for example if you want to make your blog for users only, add the middleware 'auth'.
     */
    'middleware' => ['web'],

    /**
     * you can overwrite any model and use your own
     * you can also configure the model per panel in your panel provider using:
     * ->skyModels([ ... ])
     */
    'models' => [
        'Category' => \LaraZeus\Bolt\Models\Category::class,
        'Collection' => \LaraZeus\Bolt\Models\Collection::class,
        'Field' => \LaraZeus\Bolt\Models\Field::class,
        'FieldResponse' => \LaraZeus\Bolt\Models\FieldResponse::class,
        'Form' => \LaraZeus\Bolt\Models\Form::class,
        'FormsStatus' => \LaraZeus\Bolt\Models\FormsStatus::class,
        'Response' => \LaraZeus\Bolt\Models\Response::class,
        'Section' => \LaraZeus\Bolt\Models\Section::class,
        'User' => config('auth.providers.users.model'),
    ],

    'collectors' => [
        'fields' => [
            'path' => 'app/Zeus/Fields',
            'namespace' => '\\App\\Zeus\\Fields\\',
        ],

        'dataSources' => [
            'path' => 'app/Zeus/DataSources',
            'namespace' => 'App\\Zeus\\DataSources\\',
        ],
    ],

    'defaultMailable' => \LaraZeus\Bolt\Mail\FormSubmission::class,

    'uploadDisk' => env('BOLT_FILESYSTEM_DISK', 'public'),

    'uploadDirectory' => env('BOLT_FILESYSTEM_DIRECTORY', 'forms'),

    'uploadVisibility' => env('BOLT_FILESYSTEM_VISIBILITY', 'public'),

    /*
     * if you have installed Bolt Pro, you can enable the presets here
     */
    'show_presets' => false,

    /**
     * the preset comes with a demo forms:
     * a Contact form and Ticket support form.
     * if you dont want them, feel free to set this to false
     * */
    'show_core_presets' => true,

    /**
     * the preview for the presets is using sushi:
     * you can enable/disable the cache here
     * */
    'should_cache_preset' => env('BOLT_CACHE_PRESET', true),

    /*
     * if you have installed Bolt Pro, you can enable the form design option here
     */
    'allow_design' => false,

    /**
     * since `collections` or 'data sources' have many types, we cannot lazy load them
     * but we cache them for a while to get better performance
     * the key is: dataSource_*_response_md5
     *
     * here you can set the duration of the cache
     */
    'cache' => [
        'collection_values' => 30, // on seconds
    ],
];
