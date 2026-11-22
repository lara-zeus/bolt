<?php

use LaraZeus\Bolt\Fields\Classes\TextInput;
use LaraZeus\Bolt\Filament\Resources\FormResource\Pages\CreateForm;
use LaraZeus\Bolt\Models\Form;

use function Pest\Livewire\livewire;

beforeEach(function () {
    config()->set('app.locale', 'en');
    config()->set('app.fallback_locale', 'en');
    app()->setLocale('en');
    filament('spatie-translatable')->defaultLocales(['en', 'ar', 'ckb']);
});

it('auto-fills slug from the first locale name and does not overwrite it when switching locales', function () {
    livewire(CreateForm::class)
        ->assertSet('activeLocale', 'en')
        ->set('data.name', 'Contact Us')
        ->assertSet('data.slug', 'contact-us')
        ->set('activeLocale', 'ar')
        ->set('data.name', 'اتصل بنا')
        ->assertSet('data.slug', 'contact-us')
        ->set('activeLocale', 'ckb')
        ->set('data.name', 'پەیوەندیمان پێوە بکە')
        ->assertSet('data.slug', 'contact-us');
});

it('does not overwrite a manually entered slug when name is updated', function () {
    livewire(CreateForm::class)
        ->assertSet('activeLocale', 'en')
        ->set('data.slug', 'custom-slug')
        ->set('data.name', 'Contact Us')
        ->assertSet('data.slug', 'custom-slug');
});

it('creates a multi-locale form preserving translated names and original slug', function () {
    $component = livewire(CreateForm::class)
        ->assertSet('activeLocale', 'en');

    $sectionKey = array_key_first($component->get('data.sections'));
    $fieldKey = array_key_first($component->get("data.sections.{$sectionKey}.fields"));

    $component
        ->set('data.name', 'Contact Us')
        ->assertSet('data.slug', 'contact-us')
        ->set('data.description', 'English description')
        ->set("data.sections.{$sectionKey}.name", 'General')
        ->set("data.sections.{$sectionKey}.fields.{$fieldKey}.name", 'Full Name')
        ->set("data.sections.{$sectionKey}.fields.{$fieldKey}.type", '\\' . TextInput::class)
        ->set('activeLocale', 'ar')
        ->set('data.name', 'اتصل بنا')
        ->set('data.description', 'وصف عربي')
        ->set("data.sections.{$sectionKey}.name", 'عام')
        ->set("data.sections.{$sectionKey}.fields.{$fieldKey}.name", 'الاسم الكامل')
        ->assertSet('data.slug', 'contact-us')
        ->set('activeLocale', 'ckb')
        ->set('data.name', 'پەیوەندیمان پێوە بکە')
        ->set('data.description', 'وەسفی کوردی')
        ->set("data.sections.{$sectionKey}.name", 'گشتی')
        ->set("data.sections.{$sectionKey}.fields.{$fieldKey}.name", 'ناوی تەواو')
        ->assertSet('data.slug', 'contact-us')
        ->call('create')
        ->assertHasNoFormErrors();

    $form = Form::query()->latest('id')->firstOrFail();

    expect($form->slug)->toBe('contact-us')
        ->and($form->getTranslations('name'))->toEqual([
            'en' => 'Contact Us',
            'ar' => 'اتصل بنا',
            'ckb' => 'پەیوەندیمان پێوە بکە',
        ])
        ->and($form->getTranslations('description'))->toEqual([
            'en' => 'English description',
            'ar' => 'وصف عربي',
            'ckb' => 'وەسفی کوردی',
        ]);
});
