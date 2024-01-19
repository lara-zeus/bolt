<?php

return [
    /**
     * set the default domain.
     */
    'domain' => null,

    /**
     * set the default path for the blog homepage.
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
    ],

    'defaultMailable' => \LaraZeus\Bolt\Mail\FormSubmission::class,

    'uploadDisk' => 'public',

    'uploadDirectory' => 'forms',

    'show_presets' => false,

    'allow_design' => false,
];
