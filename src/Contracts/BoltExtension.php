<?php

namespace LaraZeus\Bolt\Contracts;

use Illuminate\Database\Eloquent\Model;

interface BoltExtension
{
    public function label(): string;

    /**
     * before display the form, do some checks
     * for example check if the request() param is existed, or the user is logged in !
     *
     * @param Model $form
     * @param string $data
     * @param string $action create or update
     *
     *
     * @return array|bool
     */
    public function canView(Model $form, $data, string $action = 'create'): bool|array;

    /**
     * what to show at the beginning of the form
     *
     * return a blade file with view()->render()
     *
     * @param Model $form
     * @param null $data
     * @param string $action create or update
     *
     * @return string
     */
    public function render(Model $form, $data, string $action = 'create'): string;

    public function formComponents(Model $form, $data, string $action = 'create'): array;

    /**
     * before storing the form, do some checks or validation
     * this will be called before the VCF checks
     *
     * @param Model $form
     * @param                         $data
     * @param string $action create or update
     *
     * @return bool
     */
    public function preStore($form, $data, string $action = 'create'): bool;

    /**
     * the store logic for the app, insert ticket or any DB ONLY calls, don't send here anything
     * and you must return the saved app, if you want to depend on it in the postStore
     *
     * @param Model $form
     * @param                         $data
     * @param string $action create or update
     *
     * @return array ['msg','lockedItem']
     * @throws \Exception
     *
     */
    public function store($form, $data, string $action = 'create'): array;

    /**
     * this typically used for sending only, it will executed after the DB::transaction
     *
     * @param Model $form
     * @param $data
     * @param string $action create or update
     */
    public function postStore(Model $form, $data, string $action = 'create'): void;

    /**
     * this will show any info after saving the form, like ticket num or more buttons and links
     * also it's better to use blade file, view()->render()
     *
     * @param Model $form
     * @param        $data
     * @param string $action create or update
     *
     * @return string
     */
    public function SubmittedRender(Model $form, $data, string $action = 'create'): string;
}
