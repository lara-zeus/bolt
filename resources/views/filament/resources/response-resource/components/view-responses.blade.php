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
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}') }" class="space-y-4 my-6 mx-4 ">
        @include('zeus-bolt::filament.resources.response-resource.pages.show-entry')
    </div>
</x-forms::field-wrapper>
