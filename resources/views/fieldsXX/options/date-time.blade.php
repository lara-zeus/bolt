<div>
    <x-zeus::input.group for="dateType-{{ $fld }}" inline label="Date Type">
        <x-zeus::input.select id="dateType-{{ $fld }}" wire:model="fields.{{ $sec }}.{{ $fld }}.options.dateType">
            <option value="">select date type</option>
            <option value="date">date only</option>
            <option value="time">time only</option>
            <option value="datetime">date and time</option>
        </x-zeus::input.select>
    </x-zeus::input.group>
</div>
