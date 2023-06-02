<x-filament::page>
    @forelse ($rows as $row)
        @include('zeus-bolt::themes.zeus.show-entry',['response'=>$row])
    @empty
        <div class="flex justify-center items-center space-x-2">
            <x-clarity-data-cluster-line class="h-8 w-8 text-gray-400"/>
            <span class="font-medium py-8 text-gray-400 text-xl">No responses found...</span>
        </div>
    @endforelse

    @if ($rows->hasPages())
        <x-tables::pagination :paginator="$rows"/>
    @endif

</x-filament::page>
