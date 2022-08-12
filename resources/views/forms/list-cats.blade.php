<div x-data x-init="tippy('[data-tippy-content]', {animation: 'perspective',});">
    <x-slot name="header">
        <h2>List All Forms</h2>
    </x-slot>

    <x-slot name="breadcrumb">
        <x-former::breadcrumb-item label="List"/>
    </x-slot>

    <div class="grid grid-cols-4 gap-2">
        @foreach($categories as $cat)
            <x-former::box>
                <div class="text-xl text-gray-600">
                    <h4>{{ $cat->name ?? '' }}</h4>
                </div>
                <div>
                    @foreach($cat->forms as $form )
                        @if($cat->id == $form->category_id)
                            <a class="text-green-600 py-2 px-1.5 hover:bg-gray-200 rounded-md transition ease-in-out duration-500 block cursor-pointer" href="{{ route('former.user.form.show', ['slug' => $form->slug]) }}">
                                <i class="fa fa-angle-double-{{ trans('Common.left') }}"></i>
                                {{ $form->name ?? '' }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </x-former::box>
        @endforeach
    </div>
</div>
