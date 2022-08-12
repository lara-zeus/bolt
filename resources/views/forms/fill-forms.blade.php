<div x-data x-init="tippy('[data-tippy-content]', {animation: 'perspective',});">

    <x-slot name="header">
        <h2>{{ $form->name ?? '' }}</h2>
        <p class="text-gray-400 text-mdd my-4">{{ $form->desc ?? '' }}</p>
    </x-slot>

    <form wire:submit.prevent="store">
        <x-zeus::box shadowless class="max-w-4xl mx-auto">
            {!! nl2br($form->details) !!}
            <div class="text-gray-400 text-sm">
                @if($form->start_date !== null)
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ __('Available from') }}:

                    <span>{{ optional($form->start_date)->format('Y/m/d') }}</span>,
                    {{ trans('to') }}: <span>{{ optional($form->end_date)->format('Y/m/d') }}</span>
                @endif
            </div>

            <div>
                @if (app()->isLocal() && $errors->any())
                    <div class="mt-5">
                        <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>
                        <p class="text-gray-400 text-xs">this shown for dev only!</p>
                        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </x-zeus::box>

        @if($form->sections->count() !== 0)
            @foreach($form->sections as $section)
                <x-zeus::box class="max-w-4xl mx-auto">
                    <section>
                        <span class="@if (isset($sec) && $section->id != $sec) hidden @endif">
                            @if(isset($section->name) && !empty($section->name))
                                <h2 class="text-xl font-semibold text-green-600 capitalize dark:text-white mb-4">
                                    <i class="fa fa-indent "></i> {!! $section->name !!}
                                    @if (isset($options['sectionsToPages']) && $options['sectionsToPages'] == 1)
                                        <span class="float-{{ trans('Common.left') }}">
                                            {{ trans('Frontend/App/Forms.step') }} {{ $secNo }} {{ trans('Frontend/App/Forms.from') }} {{ $form->sections->count() }}
                                        </span>
                                    @endif
                                </h2>
                            @endif
                        </span>

                        @foreach($form->fields as $field)
                            @if($section->id === $field->section_id)
                                <div class="p-4">
                                    <label class="text-gray-700 @error('fieldResponse.'.$field['id'].'.response') text-red-500 @enderror dark:text-gray-200 text-xl" for="{{ $field->html_id }}">{{ $field->name }}</label>
                                    @if(isset($field->description) && !empty($field->description))
                                        <cite class="block italic">{{ $field->description }}</cite>
                                    @endif
                                    {{--@if($fieldResponse[$field->id]['response'] == 1)
                                        111111
                                    @endif--}}

                                    <div>
                                        @includeif('zeus::fields.'.$field->type)
                                    </div>
                                    @error('fieldResponse.'.$field['id'].'.response')
                                    <div class="mt-3 text-red-500 text-sm">{{ $message }}</div> @enderror
                                </div>
                            @endif
                        @endforeach
                    </section>
                </x-zeus::box>
            @endforeach
        @endif

        @guest
            Captcha
        @endguest

        <div id="result"></div>

        <div class="p-4 text-center">
            <x-zeus::elements.button type="submit">Save</x-zeus::elements.button>
        </div>

    </form>

</div>
