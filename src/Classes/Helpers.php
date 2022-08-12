<?php

namespace LaraZeus\Bolt\Classes;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use LaraZeus\Bolt\Models\Field;
use Symfony\Component\Finder\Finder;

class Helpers
{
    /**
     * this will render the fields with it's titles and it's answers
     *
     * @param  string  $form_id
     * @param  string  $response_id
     * @param  string  $view
     *
     * @return string $out the HTML outbut
     * @throws \Throwable
     */
    public function responsRender($form_id, $response_id, $view = 'Backend.Forms.Base.renderResponse')
    {
        // get the form fields with its crudPhrase
        $data['fields'] = Field
            ::with('crudPhrase')
            ->where('type', '!=', 'paragraph')
            ->where('form_id', $form_id)
            ->orderBy('ordering', 'ASC')
            ->get();

        $data['form_id'] = $form_id;
        $data['response_id'] = $response_id;

        return view($view, $data)->render();
    }

    public function getResponsWithUser($form, $resp)
    {
        $emailMsg = '';

        $emailMsg .= trans('Frontend/App/Forms.formDetails').':<br><br>
                <table cellpadding="5" cellspacing="0" border="1" width="100%" border="1" style="width: 100%">';
        $emailMsg .= $this->responsRender($form->id, $resp->id);
        $emailMsg .= '</table><br><br>';

        return $emailMsg;
    }

    public static function availableValidation()
    {
        $rules = [
            'accepted',
            'active_url',
            'after:date', //YYYY-MM-DD
            'before:date', //YYYY-MM-DD
            'alpha',
            'alpha_dash',
            'alpha_num',
            'array',
            'between:text', //1,10
            'confirmed',
            'date',
            'date_format:dateFormat', //YYYY-MM-DD
            //'different:fieldname',
            'digits:text', //value
            'digits_between:maxMin', //min,max
            'boolean',
            'email',
            //'exists:table,column',
            'image',
            'in:text', //foo,bar,...
            'not_in:text', //foo,bar,...
            'integer',
            'numeric',
            'ip',
            'max:text', //value
            'min:text', //value
            'mimes:text', //jpeg,png
            'regex:text', //[0-9]
            'required',
            //'required_if:field,value',
            //'required_with:foo,bar,...',
            //'required_with_all:foo,bar,...',
            //'required_without:foo,bar,...',
            //'required_without_all:foo,bar,...',
            //'same:field',
            'size:text', //value
            'timezone',
            //'unique:table,column,except,idColumn',
            'url',
        ];

        return collect($rules)
            ->mapWithKeys(function ($item) {
                $rule = (Str::contains($item, ':')) ? explode(':', $item)[0] : $item;
                return [$rule => str_replace('_', ' ', $rule)];
            })
            /*->transform(function ($item) {
                return [
                    'rule' => $item,
                    'label' => str_replace(
                        '_',
                        ' ',
                        (Str::contains($item, ':'))
                            ? explode(':', $item)[0]
                            : $item),
                ];
            })*/
            ->toArray();
    }

    public static function availableFields()
    {
        if (app()->isLocal()) {
            Cache::forget('Forms.Fields');
        }

        return Cache::remember('Forms.Fields', Carbon::parse('1 month'), function () {
            $appFields = self::appFields();
            $boltFields = self::boltFields();
            $coreFields = self::coreFields();

            $fields = collect();

            if (!$coreFields->isEmpty()) {
                $fields = $fields->merge($coreFields);
            }

            if (!$appFields->isEmpty()) {
                $fields = $fields->merge($appFields);
            }

            /*if (!$boltFields->isEmpty()) {
                $fields = $fields->merge($boltFields);
            }*/

            return $fields->sortBy('order');
        });
    }

    public static function coreFields()
    {
        $path = __DIR__.'/Fields/Classes';
        if (!is_dir($path)) {
            return collect();
        }
        $classes = self::loadClasses($path, __NAMESPACE__.'\\Fields\\Classes\\');
        $allFields = self::setFields($classes, true);

        return collect($allFields);
    }

    public static function appFields()
    {
        $path = app_path('Zeus/Fields');
        if (!is_dir($path)) {
            return collect();
        }
        $classes = self::loadClasses($path, 'App\\Zeus\\Fields\\');
        $allFields = self::setFields($classes, false);

        return collect($allFields);
    }

    protected static function boltFields()
    {
        $path = base_path('vendor/lara-zeus/bolt/src/Classes/Fields/Classes');
        if (!is_dir($path)) {
            return collect();
        }
        $classes = self::loadClasses($path, 'LaraZeus\\Bolt\\Classes\\Fields\\Classes\\');
        $allFields = self::setFields($classes, true);

        return collect($allFields);
    }

    protected static function setFields($classes, $isZeus)
    {
        $allFields = [];
        foreach ($classes as $class) {
            $fieldClass = new $class();
            if (!$fieldClass->disabled) {
                $fieldClass->definition['isZeus'] = $isZeus;
                $allFields[] = $fieldClass->definition;
            }
        }

        return $allFields;
    }

    public static function loadClasses($path, $namespace)
    {
        $classes = [];
        $path = array_unique(Arr::wrap($path));

        foreach ((new Finder())->in($path)->files() as $className) {
            $classes[] = $namespace.$className->getFilenameWithoutExtension();
        }

        return $classes;
    }
}
