<x-zeus::app>
    <div x-data x-init="tippy('[data-tippy-content]', {animation: 'perspective',});">
        <x-slot name="header">
            <h2>List All Forms</h2>
        </x-slot>

        <div class="grid grid-cols-4 gap-2">

            @foreach(\LaraZeus\Bolt\Models\Category::has('forms')->where('is_active',1)->get() as $category)
                <x-zeus::box>
                    {{ $category->name }}<br>

                    @foreach(\LaraZeus\Bolt\Models\Form::get() as $form)
                        <a class="text-green-600 py-2 px-1.5 hover:bg-gray-200 rounded-md transition ease-in-out duration-500 block cursor-pointer" href="{{ route('bolt.user.form.show', ['slug' => $form->slug]) }}">
                            <i class="fa fa-angle-double-{{ trans('Common.left') }}"></i>
                            {{ $form->name ?? '' }}
                        </a>
                    @endforeach
                </x-zeus::box>
            @endforeach
        </div>
    </div>
</x-zeus::app>
