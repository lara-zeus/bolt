<div class="space-y-4">
    @php $availableFields = \LaraZeus\Bolt\Classes\Helpers::availableFields(); @endphp
    <x-zeus::input.group for="field-type-{{ $fld }}" inline label="Field Type" :error="$errors->first('fields.'.$sec . '.'. $fld.'.type')">
        <x-zeus::input.select id="field-type-{{ $fld }}" wire:model="fields.{{ $sec }}.{{ $fld }}.type" x-ref="fieldType" x-on:change="showOptionsFor = $refs.fieldType.value">
            <option disabled value="0">Select Type...</option>
            @foreach($availableFields->groupBy('isZeus')->sort() as $zeus => $inputs)
                @if($loop->count > 1)
                    @if($zeus)
                        <option disabled value="">Zeus Fields:</option>
                    @else
                        <option disabled value="">App Fields:</option>
                    @endif
                @endif
                @foreach($inputs as $fieldType)
                    <option value="{{ $fieldType['type'] }}">{{ $fieldType['title'] }}</option>
                @endforeach
            @endforeach
        </x-zeus::input.select>
    </x-zeus::input.group>

    @if(!empty($fields[$sec][$fld]['type']) && !in_array($fields[$sec][$fld]['type'],$availableFields->where('settings_view', '===', null)->pluck('type')->toArray(),true))
        <div x-cloak>
            <div class="relative mb-4">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center">
                    <button @click="isCollapsed = !isCollapsed" type="button" class="px-2 bg-gray-200 text-sm text-gray-500 focus:outline-none focus:ring-0 focus:ring-offset-0">
                        <span x-show="isCollapsed" x-cloak>
                            <svg class="inline align-text-bottom -ml-1.5 mr-1 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6" />
                            </svg>
                            <span class="align-top">Show less</span>
                        </span>
                        <span x-show="!isCollapsed">
                        <svg class="inline align-text-bottom -ml-1.5 mr-1 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                        <span class="align-top">Show more</span>
                    </span>
                    </button>
                </div>
            </div>
            <div x-show.transition.origin.top.left="isCollapsed">
                @foreach($availableFields->where('settings_view', '!=', null) as $fieldOptions)
                    <div x-show="showOptionsFor === '{{ $fieldOptions['type'] }}'">
                        @include('zeus-bolt::fields.options.'.$fieldOptions['settings_view'],['fld'=>$fld, 'type'=>$fieldOptions['type']])
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
