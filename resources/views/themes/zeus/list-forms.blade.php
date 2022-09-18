<div class="mx-4">
    <x-slot name="header">
        <h2>List All Forms</h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2">

        @foreach(\LaraZeus\Bolt\Models\Category::has('forms')->where('is_active',1)->get() as $category)
            <x-zeus::box>
                {{ $category->name }}<br>
                <cite>{{ $category->desc }}</cite><br>
                @foreach(\LaraZeus\Bolt\Models\Form::get() as $form)
                    <a class="flex flex-col py-2 px-1.5 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-md transition ease-in-out duration-500 block cursor-pointer"
                       href="{{ route('bolt.user.form.show', ['slug' => $form->slug]) }}">
                            <span class="text-primary-600 dark:text-primary-500 hover:dark:text-primary-300">
                                {{ $form->name ?? '' }}
                            </span>
                        <cite class="text-secondary-600 dark:text-secondary-500 hover:dark:text-secondary-300">
                            {{ $form->desc }}
                        </cite>
                    </a>
                @endforeach
            </x-zeus::box>
        @endforeach
    </div>
</div>
