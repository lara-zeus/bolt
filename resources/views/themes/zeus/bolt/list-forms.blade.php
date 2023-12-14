<div class="mx-4">

    <x-slot name="header">
        <h2>{{ __('List All Forms') }}</h2>
    </x-slot>

    <x-slot name="breadcrumbs">
        <li class="flex items-center">
            {{ __('Forms') }}
        </li>
    </x-slot>

    {{ \LaraZeus\Bolt\Facades\Bolt::renderHookBlade('zeus-forms.before') }}

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2">
        @foreach($categories as $category)
            <x-filament::section>
                @if($category->logo !== null)
                    <img alt="{{ $category->name }} {{ __('Logo') }}" class="w-full h-32 object-center object-cover mb-4" src="{{ $category->logo_url }}"/>
                @endif

                <p>
                    {{ $category->name }}
                    <cite class="block">{{ $category->description }}</cite>
                </p>

                @foreach($category->forms as $form)
                    <a href="{{ route('bolt.form.show', ['slug' => $form->slug]) }}" class="flex flex-col py-2 px-1.5 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-md transition ease-in-out duration-500 block cursor-pointer">
                        <span class="text-primary-600 dark:text-primary-500 hover:dark:text-primary-300">
                            {{ $form->name ?? '' }}
                        </span>
                        <cite class="text-primary-600 dark:text-primary-500 hover:dark:text-primary-300">
                            {{ $form->description }}
                        </cite>
                    </a>
                @endforeach
            </x-filament::section>
        @endforeach
    </div>

    {{ \LaraZeus\Bolt\Facades\Bolt::renderHookBlade('zeus-forms.before') }}

</div>
