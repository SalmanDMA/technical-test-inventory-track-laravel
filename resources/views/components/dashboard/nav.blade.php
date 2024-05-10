<nav class="fixed top-0 right-0 bg-white w-full lg:w-[calc(100%-288px)] py-2 px-8 shadow-lg z-50">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-6 lg:gap-0">
            <button class="block lg:hidden">
                <i class="fa-solid fa-bars text-xl" id="sidebarToggle"></i>
            </button>
            <ul class="hidden sm:flex items-center">
                @php
                    $segments = explode('/', request()->path());
                    $totalSegments = count($segments);
                @endphp

                @foreach ($segments as $index => $segment)
                    @php
                        $isLastSegment = $index == $totalSegments - 1;
                        $isSecondLastSegmentAndIndexIsMoreThanThree =
                            count($segments) > 3 && $index == $totalSegments - 2;
                        $textColorClass =
                            $isLastSegment || $totalSegments == 1 || $isSecondLastSegmentAndIndexIsMoreThanThree
                                ? 'text-slate-500 pointer-events-none'
                                : 'text-primary hover:underline';
                        $path = $index == 0 ? '/dashboard' : '/dashboard/' . strtolower(ucfirst($segment));
                    @endphp

                    <li>
                        <a href="{{ $path }}" class="{{ $textColorClass }}">{{ ucfirst($segment) }}</a>
                    </li>

                    @if ($index < $totalSegments - 1)
                        <li class="text-slate-500 px-2">/</li>
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="relative">
            <button class="flex items-center gap-3 focus:outline-none" id="dropdownMenuButton">
                <div class="flex-col hidden sm:flex">
                    <h3 class="font-poppins text-slate-950 font-semibold text-end">{{ auth()->user()->name }}</h3>
                    <p class="text-sm font-medium text-slate-500 font-gelasio text-end">{{ auth()->user()->email }}
                    </p>
                </div>
                <img src="{{ auth()->user()->avatar == null ? asset('images/avatar.jpeg') : Storage::url('photo-users/' . auth()->user()->avatar) }}"
                    alt="avatar" class="size-12 rounded-full">
                <i class="fa-solid fa-chevron-down text-slate-500 text-lg transition-all duration-300 ease-in-out"
                    id="dropdownMenuIcon"></i>
            </button>
            <div class="absolute top-full right-0 mt-2 w-56 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden transition-all duration-300 ease-in-out"
                id="dropdownMenuItem">
                <div class="flex-col flex sm:hidden py-4 border-b-[1.5px] border-slate-200">
                    <h3 class="font-poppins text-slate-950 font-semibold text-center">{{ auth()->user()->name }}
                    </h3>
                    <p class="text-sm font-medium text-slate-500 font-gelasio text-center">
                        {{ auth()->user()->email }}
                    </p>
                </div>
                <div>
                    <a href="{{ route('dashboard.profile') }}"
                        class="flex items-center gap-2 px-6 py-4 text-gray-700 hover:bg-gray-100">
                        <i class="fa-solid fa-address-card text-xl"></i>
                        <span class="font-gelasio font-medium text-lg">Profile</span>
                    </a>
                </div>
                <div>
                    <a href="{{ route('logout') }}"
                        class="flex items-center gap-2 px-6 py-4 text-gray-700 hover:bg-gray-100"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-right-from-bracket text-xl"></i>
                        <span class="font-gelasio font-medium text-lg">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
