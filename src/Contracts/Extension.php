<?php

namespace LaraZeus\Bolt\Contracts;

use Illuminate\Database\Eloquent\Model;
use LaraZeus\Bolt\Models\Form;

interface Extension
{
    public function label(): string;

    /**
     * before displaying the form, do some checks
     * for example check if the request() param is existed, or the user is logged in !
     *
     * @param Form $form Bolt form
     */
    public function canView(Form $form): bool|array|null;

    /**
     * what to show at the beginning of the form
     *
     * return a blade file with view()->render()
     *
     * @param Form $form Bolt form
     */
    public function render(Form $form): string|null;

    /*
     * return an array of filament components to add them to the form
     *
     * @param  Form  $form Bolt form
     */
    public function formComponents(Form $form): array|null;

    /**
     * before storing the form, do some checks or validation
     */
    /*public function preStore(Form $form): bool|null;*/

    /**
     * the store logic for the app, insert ticket or any DB ONLY calls, don't send here anything,
     * and you must return the saved app, if you want to depend on it in the postStore
     *
     * @param Form $form Bolt form
     * @param array $data extra data
     *
     * @throws \Exception
     */
    public function store(Form $form, array $data): array|null;

    /**
     * this typically used for sending only, it will execute after the DB::transaction
     *
     * @param Form $form Bolt form
     *
     */
    public function postStore(Form $form, array $data): void;

    /**
     * this will show any info after saving the form, like ticket num or more buttons and links
     * also it's better to use blade file, view()->render()
     *
     * @param Form $form Bolt form
     *
     */
    public function SubmittedRender(Form $form, array $data): string|null;

    /**
     * return the Model of the extension
     * for now used when showing the massage after submit the form
     *
     * @param Form $form Bolt form
     * @param array $data
     */
    /*public function getModel(Form $form, array $data): Model;*/
}
