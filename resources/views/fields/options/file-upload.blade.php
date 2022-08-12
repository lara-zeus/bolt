<div>
    <x-zeus::input.group for="filesSize-{{ $fld }}" inline label="Max file size">
        <x-zeus::input.text wire:model="fields.{{ $sec }}.{{ $fld }}.options.filesSize" :error="$errors->first('fields.'.$sec . '.'. $fld.'.options.filesSize')" placeholder="Max file size"/>
    </x-zeus::input.group>

    <x-zeus::input.group for="filesType-{{ $fld }}" inline label="files Type">
        <x-zeus::input.select id="filesType-{{ $fld }}" wire:model="fields.{{ $sec }}.{{ $fld }}.options.filesType">
            <option value="">select date type</option>
            <option value="images">Images</option>
            <option value="docs">Docs</option>
            <option value="all">All</option>
        </x-zeus::input.select>
    </x-zeus::input.group>

</div>
