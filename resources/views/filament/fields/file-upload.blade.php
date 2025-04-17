<div class="py-2">
    @if(filled($responseValue))
        <div class="flex flex-col gap-2 items-start justify-start">
            @foreach($responseValue as $file)
                <x-filament::link
                        target="_blank"
                        size="sm"
                        outlined
                        href="{{ $getUrl($file) }}"
                >
                        {{ __('view file') .': '. $loop->iteration }}
                </x-filament::link>
            @endforeach
        </div>
   @else
        <span class="text-gray-500">{{ __('no file uploaded') }}</span>
   @endif
</div>
