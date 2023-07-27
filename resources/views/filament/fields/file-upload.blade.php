@if(!empty($resp->response))
    <x-filament::button
            tag="a" target="_blank" size="sm" outlined
            href="{{ Storage::disk(\LaraZeus\Bolt\BoltPlugin::get()->getUploadDisk())->url($resp->response) }}">
        {{ __('view file') }}
    </x-filament::button>
@endif
