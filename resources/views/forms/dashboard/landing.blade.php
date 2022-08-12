<x-zeus::app withoutSideNav>

<div class="mt-6 py-4">
    <div class="h-full">
        <div class="relative z-10 pb-8 sm:pb-16 md:pb-20  lg:w-full lg:pb-28 xl:pb-32 h-full">
            <main class="mt-10 mx-auto px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28 h-full">
                <div class="flex flex-col md:flex-row w-full items-start justify-between md:justify-start h-full md:h-1/2">
                    <div class="text-left z-20 md:z-30 w-full md:w-1/2 flex flex-col items-center md:items-start justify-start md:justify-center h-full">
                        <h1 class="tracking-tight font-extrabold text-gray-900 titleHome text-6xl flex gap-4">
                            <img class="h-32" src="{{ asset('images/logo-gold-200.png') }}" alt="{{ config('zeus.name', config('app.name', 'Laravel')) }}">
                            <span>
                                <span class="text-6xl flex w-full m-auto text-green-600 filter drop-shadow-md">
                                    @zeus
                                </span>
                                <span class="block font-bold xl:inline text-gray-500">
                                    <span class="absolute">
                                        Form Manager for your Site
                                    </span>
                                </span>
                            </span>
                        </h1>
                        <h2 class="mt-3 text-gray-500 sm:mt-5 text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            you can simply customize this page or disable it completely.<br>
                            this is a starting point for you and your users.<br>
                            for more read the docs.<br>
                        </h2>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start w-full">
                            <div class="rounded-md shadow">
                                <a href="{{ route('zeus.admin.forms.list') }}" class="w-full flex items-center justify-center px-8 py-3  text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 px-4 py-2">
                                    Admin
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="{{ route('zeus.user.entries.list') }}" class="w-full flex items-center justify-center px-8 py-3  text-base font-medium rounded-md text-green-700 bg-gray-200 hover:bg-gray-200 px-4 py-2">
                                    User Entries
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="{{ route('zeus.user.forms.list') }}" class="w-full flex items-center justify-center px-8 py-3  text-base font-medium rounded-md text-green-700 bg-gray-200 hover:bg-gray-200 px-4 py-2">
                                    Forms List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>

</x-zeus::app>
