@if(!empty($resp->response))
    <x-filament::button
            tag="a" target="_blank" size="sm" outlined
            href="{{ Storage::disk(config('zeus-bolt.uploads.disk'))->url($resp->response) }}">
        {{ __('view file') }}
    </x-filament::button>
@endif