<div class="py-2 cursor-pointer !w-full flex items-start justify-start gap-2">
    @svg($field['icon'],'text-primary-500 w-5 h-5')
    <span class="w-full flex items-center justify-between gap-2">
        <span class="flex flex-col items-start justify-between gap-2">
            <span class="font-semibold">{{ $field['title'] }}</span>
            {{--<span class="text-sm field-desc">{{ $field['description'] }}</span>--}}
        </span>
        <span class="tip" x-tooltip="{
                content: @js($field['description']),
                theme: $store.theme,
            }">
            @svg('heroicon-o-information-circle','mx-2 w-4 h-4 text-gray-400')
        </span>
    </span>
</div>