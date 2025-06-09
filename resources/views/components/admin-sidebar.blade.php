<div class="h-full py-4 px-3 bg-gray-800 text-gray-200 flex flex-col"> {{-- Added flex flex-col here --}}
    {{-- Top section with "Admin Panel" / "AP" text --}}
    <div class="mb-6 flex items-center justify-between">
        {{-- "Admin Panel" is shown when the sidebar is open --}}
        <div x-show="isSidebarOpen" class="text-xl font-semibold">{{ __('Admin Panel') }}</div>
        {{-- "AP" is shown when the sidebar is collapsed --}}
        <div x-show="!isSidebarOpen" class="text-xl font-semibold">{{ __('AP') }}</div>
    </div>

    {{-- This div contains the main navigation links and is set to grow ('flex-grow') --}}
    {{-- to push the logout button to the bottom. --}}
    <div class="flex-grow">
        <ul class="space-y-2">
            <li>
                {{-- Dashboard Link --}}
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-base font-normal text-gray-300 rounded-lg hover:bg-gray-700 group {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="flex-shrink-0 w-6 h-6 text-gray-400 group-hover:text-white {{ request()->routeIs('admin.dashboard') ? 'text-white' : '' }}" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 01-8 8v-8H2z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
                    <span class="ml-3 sidebar-text" x-show="isSidebarOpen">{{ __('Dashboard') }}</span>
                </a>
            </li>
            <li>
                {{-- Elections Link --}}
                <a href="{{ route('elections.index') }}" class="flex items-center p-2 text-base font-normal text-gray-300 rounded-lg hover:bg-gray-700 group {{ request()->routeIs('elections.index') || request()->routeIs('elections.edit') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="flex-shrink-0 w-6 h-6 text-gray-400 group-hover:text-white {{ request()->routeIs('elections.index') || request()->routeIs('elections.edit') ? 'text-white' : '' }}" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
                    <span class="ml-3 sidebar-text" x-show="isSidebarOpen">{{ __('Elections') }}</span>
                </a>
            </li>
            <li>
                {{-- Create Election Link --}}
                <a href="{{ route('elections.create') }}" class="flex items-center p-2 text-base font-normal text-gray-300 rounded-lg hover:bg-gray-700 group {{ request()->routeIs('elections.create') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="flex-shrink-0 w-6 h-6 text-gray-400 group-hover:text-white {{ request()->routeIs('elections.create') ? 'text-white' : '' }}" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"></path><path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"></path></svg>
                    <span class="ml-3 sidebar-text" x-show="isSidebarOpen">{{ __('Create Election') }}</span>
                </a>
            </li>
            <li>
                {{-- Applications Link with pending count badge --}}
                @php
                    // Ensure the Application model is imported or fully qualified at the top of the file using:
                    // use App\Models\Application;
                    $pendingApplicationsCount = \App\Models\Application::where('status', 'pending')->count();
                @endphp
                <a href="{{ route('admin.applications.index') }}" class="flex items-center p-2 text-base font-normal text-gray-300 rounded-lg hover:bg-gray-700 group {{ request()->routeIs('admin.applications.index') || request()->routeIs('admin.applications.show') || request()->routeIs('admin.applications.edit') ? 'bg-gray-700 text-white' : '' }}">
                    {{-- Icon Container (Relative for absolute positioning of badge in collapsed state) --}}
                    <div class="relative flex-shrink-0">
                        {{-- Icon for Applications --}}
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-white {{ request()->routeIs('admin.applications.index') || request()->routeIs('admin.applications.show') || request()->routeIs('admin.applications.edit') ? 'text-white' : '' }}" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>

                        {{-- Badge for collapsed state: visible when sidebar is NOT open --}}
                        <span x-show="!isSidebarOpen" class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                            {{ $pendingApplicationsCount }}
                        </span>
                    </div>

                    {{-- Text for Applications Link --}}
                    <span class="ml-3 sidebar-text" x-show="isSidebarOpen">{{ __('Applications') }}</span>

                    {{-- Badge for open state: visible when sidebar IS open and next to text --}}
                    <span x-show="isSidebarOpen" class="ml-2 inline-flex items-center justify-center px-2 py-0.5 text-xs font-semibold rounded-full bg-red-600 text-white leading-none">
                        {{ $pendingApplicationsCount }}
                    </span>
                </a>
            </li>
            <li>
                {{-- Users Link --}}
                <a href="{{ route('users.index') }}" class="flex items-center p-2 text-base font-normal text-gray-300 rounded-lg hover:bg-gray-700 group {{ request()->routeIs('users.index') || request()->routeIs('users.edit') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="flex-shrink-0 w-6 h-6 text-gray-400 group-hover:text-white {{ request()->routeIs('users.index') || request()->routeIs('users.edit') ? 'text-white' : '' }}" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2zM11 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2h-2z"></path></svg>
                    <span class="ml-3 sidebar-text" x-show="isSidebarOpen">{{ __('Users') }}</span>
                </a>
            </li>
            <li>
                {{-- Results Link --}}
                <a href="{{ route('admin.results') }}" class="flex items-center p-2 text-base font-normal text-gray-300 rounded-lg hover:bg-gray-700 group {{ request()->routeIs('admin.results') || request()->routeIs('admin.elections.results') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="flex-shrink-0 w-6 h-6 text-gray-400 group-hover:text-white {{ request()->routeIs('admin.results') || request()->routeIs('admin.elections.results') ? 'text-white' : '' }}" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2h4.586A2 2 0 0113 3.414L16.586 7A2 2 0 0117 8.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9 1.5V6H9v.5a1 1 0 001 1h2a1 1 0 001-1z" clip-rule="evenodd"></path></svg>
                    <span class="ml-3 sidebar-text" x-show="isSidebarOpen">{{ __('Results') }}</span>
                </a>
            </li>
            <li>
                {{-- Profile Link --}}
                <a href="{{ route('profile.edit') }}" class="flex items-center p-2 text-base font-normal text-gray-300 rounded-lg hover:bg-gray-700 group {{ request()->routeIs('profile.edit') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="flex-shrink-0 w-6 h-6 text-gray-400 group-hover:text-white {{ request()->routeIs('profile.edit') ? 'text-white' : '' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.125h15.002c.398 0 .73-.228.91-.606l3-7.004A2.25 2.25 0 0018.75 10.5h-1.586l-4.7-8.19a.75.75 0 00-.53-.234h-4.622a.75.75 0 00-.529.234l-4.7 8.19H5.25a2.25 2.25 0 00-2.182 2.496l3 7.004c.18.378.512.606.91.606z" />
                    </svg>
                    <span class="ml-3 sidebar-text" x-show="isSidebarOpen">{{ __('Profile') }}</span>
                </a>
            </li>
        </ul>
    </div>

    {{-- Logout button, positioned at the bottom of the sidebar using mt-auto --}}
    <div class="mt-auto pt-4 border-t border-gray-700"> {{-- mt-auto pushes it to the bottom --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center p-2 text-base font-normal text-gray-300 rounded-lg hover:bg-gray-700 group w-full text-left">
                <svg class="flex-shrink-0 w-6 h-6 text-gray-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4m6-3L9 9m3-3h-3m3 3H9m9 14l-9-9m9 9l3-3m-3 3l-3-3" />
                </svg>
                <span class="ml-3 sidebar-text" x-show="isSidebarOpen">{{ __('Log Out') }}</span>
            </button>
        </form>
    </div>
</div>
