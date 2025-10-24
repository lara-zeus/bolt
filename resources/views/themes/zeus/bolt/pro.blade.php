@php
    use Illuminate\Support\Facades\Storage;
    use LaraZeus\Bolt\Facades\Bolt;
@endphp
@if(
    Bolt::hasPro()
    && optional($zeusForm->options)['logo'] !== null
    && optional($zeusForm)->options['cover'] !== null
)
    <div
        style="background-image: url('{{ Storage::disk(config('zeus-bolt.uploadDisk'))->url($zeusForm->options['cover']) }}')"
        class="flex justify-start items-center px-4 py-6 gap-4 rounded-lg bg-clip-border bg-origin-border bg-cover bg-center"
    >
        <img
            class="bg-white rounded-full shadow-md shadow-primary-100 sm:w-24 object-cover"
            src="{{ Storage::disk(config('zeus-bolt.uploadDisk'))->url($zeusForm->options['logo']) }}"
            alt="logo"
        />
        <div class="bg-white/80 p-4 space-y-1 rounded-lg w-full text-left">
            <h4 class="text-primary-800 text-2xl font-bold dark:text-white">
                {{ $zeusForm->name ?? '' }}
            </h4>
            @if(filled($zeusForm->description))
                <h5 class="text-primary-600 font-normal">
                    {{ $zeusForm->description ?? '' }}
                </h5>
            @endif
            @if($zeusForm->start_date !== null)
                <div class="text-primary-800 flex items-center justify-start gap-2 text-sm">
                    @svg('heroicon-o-calendar','h-5 w-5 inline-flex')
                    <span class="flex items-center justify-center gap-1">
                        <span>{{ __('Available from') }}:</span>
                        <span>{{ optional($zeusForm->start_date)->format($this->form->getDefaultDateDisplayFormat()) }}</span>,
                        <span>{{ __('to') }}:</span>
                        <span>{{ optional($zeusForm->end_date)->format($this->form->getDefaultDateDisplayFormat()) }}</span>
                    </span>
                </div>
            @endif
        </div>
    </div>
@endif
