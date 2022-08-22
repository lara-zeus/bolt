<div>
    <button type="button" class="inline-flex h-6 w-11 border-2 border-transparent rounded-full transition ease-in-out duration-300 focus:outline-none focus:ring-0 bg-gray-500"
            x-data="{ on:  true}" role="switch" aria-checked="false" @click="on = !on" :class="{ 'bg-green-600': on, 'bg-gray-200': !(on) }">
    <span class="pointer-events-none relative inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-300 translate-x-0" :class="{ 'translate-x-5': on, 'translate-x-0': !(on) }">
        <span class="absolute inset-0 h-full w-full flex items-center justify-center transition-opacity opacity-100 ease-in duration-300" :class="{ 'opacity-0 ease-out duration-100': on, 'opacity-100 ease-in duration-300': !(on) }">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </span>
        <span class="absolute inset-0 h-full w-full flex items-center justify-center transition-opacity opacity-0 ease-out duration-100" aria-hidden="true" :class="{ 'opacity-100 ease-in duration-300': on, 'opacity-0 ease-out duration-100': !(on) }">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </span>
    </span>
    </button>
</div>
