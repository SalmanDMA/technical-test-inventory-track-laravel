<aside class="bg-slate-800 min-h-screen w-72 fixed top-0 z-[70] transition-all duration-300 ease-in-out" id="sidebar">
    <div class="px-5 py-4 flex justify-center items-center shadow-sm shadow-white">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="size-12">
        <h1 class="text-2xl font-semibold font-poppins ml-3 text-white">InventoryTrack</h1>
    </div>
    <div class="flex flex-col gap-2 pt-8 px-8">
        <h3 class="font-poppins text-slate-400 text-lg">Main</h3>
        <x-dashboard.aside-item url="{{ route('dashboard.index') }}" title="Dashboard" icon="fa-solid fa-house"
            activeUrl="{{ request()->routeIs('dashboard.index') }}" />
        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')
            <h3 class="font-poppins text-slate-400 text-lg mt-4">Management</h3>
            <x-dashboard.aside-item url="{{ route('dashboard.items') }}" title="Items" icon="fa-solid fa-sitemap"
                activeUrl="{{ request()->routeIs('dashboard.items') }}" />
            <x-dashboard.aside-item url="{{ route('dashboard.users') }}" title="Users" icon="fa-solid fa-users"
                activeUrl="{{ request()->routeIs('dashboard.users') }}" />
            <x-dashboard.aside-item url="{{ route('dashboard.activities') }}" title="Activities"
                icon="fa-solid fa-chart-line" activeUrl="{{ request()->routeIs('dashboard.activities') }}" />
        @else
            <h3 class="font-poppins text-slate-400 text-lg mt-4">List</h3>
            <x-dashboard.aside-item url="{{ route('dashboard.items') }}" title="Items" icon="fa-solid fa-sitemap"
                activeUrl="{{ request()->routeIs('dashboard.items') }}" />
            <x-dashboard.aside-item url="{{ route('dashboard.activities') }}" title="Activities"
                icon="fa-solid fa-chart-line" activeUrl="{{ request()->routeIs('dashboard.activities') }}" />
            <h3 class="font-poppins text-slate-400 text-lg mt-4">Form</h3>
            <x-dashboard.aside-item url="{{ route('dashboard.loan') }}" title="Loan"
                icon="fa-solid fa-truck-ramp-box" activeUrl="{{ request()->routeIs('dashboard.loan') }}" />
            <x-dashboard.aside-item url="{{ route('dashboard.return') }}" title="Return" icon="fa-solid fa-rotate-left"
                activeUrl="{{ request()->routeIs('dashboard.return') }}" />
        @endif
    </div>
</aside>
