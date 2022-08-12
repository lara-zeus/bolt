<div class="flex gap-4">
    <img class="w-9 h-9 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($getRecord->name) }}'&color=FFFFFF&background=111827" alt="{{ $getRecord->email }}"/>
    <p class="flex flex-col">
        <span>{{ $getRecord->name }}</span>
        <span class="text-xs">{{ $getRecord->email }}</span>
    </p>
</div>