<x-mail::message>
# {{ __('zeus-bolt::messages.new_submission_on_form') }}: {{ $form->name }}

<x-mail::button :url="$url">
{{ __('zeus-bolt::response.view_the_entry') }}
</x-mail::button>

{{ __('zeus-bolt::messages.thanks') }},<br>
{{ config('app.name') }}
</x-mail::message>