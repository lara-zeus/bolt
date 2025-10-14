<?php

namespace LaraZeus\Bolt\Contracts;

use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Response;

interface Extension
{
    public function label(): string;

    // the home page for your ext to use in the frontend,
    // for example with thunder it is: route('thunder.offices.list')
    public function route(): string;

    /**
     * before displaying the form, do some checks
     * for example check if the $data['extensionSlug'] param is existed, or the user is logged in !
     *
     * @param  Form  $form  Bolt form
     * @param  array  $data  extra data
     */
    public function canView(Form $form, array $data): bool | array | null;

    /**
     * what to show at the beginning of the form
     *
     * return a blade file with view()->render()
     *
     * @param  Form  $form  Bolt form
     * @param  array  $data  extra data
     */
    public function render(Form $form, array $data): ?string;

    /*
     * return an array of filament components to add them to the form
     *
     * @param  Form  $form Bolt form
     */
    public function formComponents(Form $form): ?array;

    /*
     * will triggered before saving the form, if you want to perform some validation
     *
     * you can throw an exception or return true
     */
    public function preStore(Form $form, array $data): bool;

    /**
     * the store logic for the app, insert ticket or any DB ONLY calls, don't send here anything,
     * and you must return the saved app, if you want to depend on it in the postStore
     *
     * @param  Form  $form  Bolt form
     * @param  array  $data  extra data
     *
     * @throws \Exception
     */
    public function store(Form $form, array $data): ?array;

    /**
     * this typically used for sending only, it will execute after the DB::transaction
     *
     * @param  Form  $form  Bolt form
     */
    public function postStore(Form $form, array $data): void;

    /**
     * this will show any info after saving the form, like ticket num or more buttons and links
     * also it's better to use blade file, view()->render()
     *
     * @param  Form  $form  Bolt form
     */
    public function SubmittedRender(Form $form, array $data): ?string;

    /*
     * list all items connected to a form
     */
    public function getItems(Form $form): array;

    /*
     * return the url to the form, when clicking on `open`. append any parameters you need to your Extension
     */
    public function getUrl(Form $form, array $extension): string;

    /*
     * check if its allowed to delete the form
     */
    public function canDelete(Form $form, array $extension): bool;

    /*
     * check if its allowed to delete the response
     */
    public function canDeleteResponse(Form $form, array $extension): bool;
}
