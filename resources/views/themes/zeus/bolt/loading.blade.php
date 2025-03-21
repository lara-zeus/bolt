<div>
    <div class="bolt-loading"></div>
    @teleport('.bolt-loading')
        <div wire:loading class="px-4">
            @svg('heroicon-o-arrow-path', 'text-primary-600 w-6 h-6 animate-spin')
        </div>
    @endteleport
</div>
