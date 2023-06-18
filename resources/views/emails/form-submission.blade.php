<x-mail::message>
# New submission on form: {{ $form->name }}

<x-mail::button :url="$url">
view the entry
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>