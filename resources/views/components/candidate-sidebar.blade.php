<div class="h-full py-4 px-3 bg-gray-800 text-gray-200">
    <div class="mb-6">
        <div x-show="isSidebarOpen" class="text-xl font-semibold">{{ __('Candidate Panel') }}</div>
        <div x-show="!isSidebarOpen" class="text-xl font-semibold">{{ __('CP') }}</div>
    </div>
    <ul class="space-y-2">
        <li>
            <a href="{{ route('candidate.dashboard') }}" class="flex items-center p-2 text-base font-normal text-gray-300 rounded-lg hover:bg-gray-700 group">
                <svg class="flex-shrink-0 w-6 h-6 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 01-8 8v-8H2z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
                <span class="ml-3 sidebar-text" x-show="isSidebarOpen">{{ __('Dashboard') }}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('candidate.profile.create') }}" class="flex items-center p-2 text-base font-normal text-gray-300 rounded-lg hover:bg-gray-700 group">
                <svg class="flex-shrink-0 w-6 h-6 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                <span class="ml-3 sidebar-text" x-show="isSidebarOpen">{{ __('Create Profile') }}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('candidate.elections') }}" class="flex items-center p-2 text-base font-normal text-gray-300 rounded-lg hover:bg-gray-700 group">
                <svg class="flex-shrink-0 w-6 h-6 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
                <span class="ml-3 sidebar-text" x-show="isSidebarOpen">{{ __('My Elections') }}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('candidate.results') }}" class="flex items-center p-2 text-base font-normal text-gray-300 rounded-lg hover:bg-gray-700 group">
                <svg class="flex-shrink-0 w-6 h-6 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm3 4a1 1 0 00-2 0v6a1 1 0 002 0V9zm3-1a1 1 0 11-2 0v8a1 1 0 112 0V8zm3-1a1 1 0 11-2 0v10a1 1 0 112 0V7z" clip-rule="evenodd"></path></svg>
                <span class="ml-3 sidebar-text" x-show="isSidebarOpen">{{ __('Results') }}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('profile.edit') }}" class="flex items-center p-2 text-base font-normal text-gray-300 rounded-lg hover:bg-gray-700 group">
                <svg class="flex-shrink-0 w-6 h-6 text-gray-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.125h15.002c.398 0 .73-.228.91-.606l3-7.004A2.25 2.25 0 0018.75 10.5h-1.586l-4.7-8.19a.75.75 0 00-.53-.234h-4.622a.75.75 0 00-.529.234l-4.7 8.19H5.25a2.25 2.25 0 00-2.182 2.496l3 7.004c.18.378.512.606.91.606z" />
                </svg>
                <span class="ml-3 sidebar-text" x-show="isSidebarOpen">{{ __('Profile') }}</span>
            </a>
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center p-2 text-base font-normal text-gray-300 rounded-lg hover:bg-gray-700 group w-full text-left">
                    <svg class="flex-shrink-0 w-6 h-6 text-gray-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4m6-3L9 9m3-3h-3m3 3H9m9 14l-9-9m9 9l3-3m-3 3l-3-3" />
                    </svg>
                    <span class="ml-3 sidebar-text" x-show="isSidebarOpen">{{ __('Log Out') }}</span>
                </button>
            </form>
        </li>
    </ul>
</div>