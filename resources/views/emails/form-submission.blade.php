<x-mail::message>
# {{ __('New submission on form') }}: {{ $form->name }}

<x-mail::button :url="$url">
{{ __('view the entry') }}
</x-mail::button>

{{ __('Thanks') }},<br>
{{ config('app.name') }}
</x-mail::message>