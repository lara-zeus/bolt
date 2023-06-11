@if(!empty($resp->response))
    <a target="_blank" href="{{ Storage::disk(config('zeus-bolt.uploads.disk'))->url($resp->response) }}">
        {{ __('view file') }}
    </a>
@endif