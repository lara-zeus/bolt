<x-forms::field-wrapper
        :id="$getId()"
        :label="$getLabel()"
        :label-sr-only="$isLabelHidden()"
        :helper-text="$getHelperText()"
        :hint="$getHint()"
        :hint-icon="$getHintIcon()"
        :required="$isRequired()"
        :state-path="$getStatePath()"
>
    <div class="flex items-center justify-between">
    <div class="flex-1">
            <h5 class="text-lg font-bold tracking-tight">
                Form details
            </h5>

            <p class="text-gray-500">
                Name, slug, and other options
            </p>
    </div>
        <div class="flex justify-end gap-2" x-data="{ state: $wire.entangle('{{ $getStatePath() }}') }">
            @include('zeus-bolt::forms.modals.options')
            @include('zeus-bolt::forms.modals.texts')
            @include('zeus-bolt::forms.modals.settings')
        </div>
    </div>
</x-forms::field-wrapper>
