<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<x-head title="Dashboard" />

<x-dashboard.layout>
    <div class="flex flex-col gap-4">
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
            @if (auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')
                <x-dashboard.card title="Total Users" value="{{ count($users) }}" icon="fa-solid fa-users" />
                <x-dashboard.card title="Total Items" value="{{ count($items) }}" icon="fa-solid fa-sitemap" />
                <x-dashboard.card title="Total Activities" value="{{ count($activities) }}"
                    icon="fa-solid fa-chart-line" />
            @else
                <x-dashboard.card title="Total Loan" value="{{ count($loans) }}" icon="fa-solid fa-truck-ramp-box" />
                <x-dashboard.card title="Total Return" value="{{ count($returns) }}" icon="fa-solid fa-rotate-left" />
                <x-dashboard.card title="Total Activities" value="{{ count($activities) }}"
                    icon="fa-solid fa-chart-line" />
            @endif
        </div>
        <div
            class="grid grid-cols-1 {{ auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin' ? 'xl:grid-cols-5 gap-4' : '' }}">
            <div class="col-span-5 xl:col-span-3">
                <div class="bg-white h-full shadow rounded-lg">
                    <div class="border-b border-gray-300 px-5 py-4">
                        <h4 class="font-poppins text-slate-950 font-semibold text-lg">Recent Activities</h4>
                    </div>

                    <div class="relative overflow-x-auto">
                        <table class="text-left w-full whitespace-nowrap">
                            <thead class="text-gray-700">
                                <tr>
                                    <th scope="col" class="border-b bg-gray-100 px-6 py-3 font-poppins">Name</th>
                                    <th scope="col" class="border-b bg-gray-100 px-6 py-3 font-poppins">Item</th>
                                    <th scope="col" class="border-b bg-gray-100 px-6 py-3 font-poppins">Quantity</th>
                                    <th scope="col" class="border-b bg-gray-100 px-6 py-3 font-poppins">Date</th>
                                    <th scope="col" class="border-b bg-gray-100 px-6 py-3 font-poppins">Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($topFiveByDate as $top)
                                    <tr>
                                        <td
                                            class="border-b border-gray-300 font-medium py-3 px-6 text-left pr-20 2xl:pr-0">
                                            @if (auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')
                                                <div
                                                    class="flex items-center whitespace-nowrap space-x-2 mr-12 lg:mr-0">
                                                    <img class="size-10 rounded-full object-cover object-center"
                                                        src="{{ optional($top->user)->avatar == null ? asset('images/avatar.jpeg') : Storage::url('photo-users/' . optional($top->user)->avatar) }}"
                                                        alt={{ optional($top->user)->name }}>
                                                    <div class="text-sm font-normal text-slate-500">
                                                        <div
                                                            class="text-base font-semibold text-slate-900 font-gelasio">
                                                            {{ optional($top->user)->name }}
                                                        </div>
                                                        <div class="text-sm font-normal text-slate-500 font-gelasio">
                                                            {{ optional($top->user)->email }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div
                                                    class="flex items-center whitespace-nowrap space-x-2 mr-12 lg:mr-0">
                                                    <img class="size-10 rounded-full object-cover object-center"
                                                        src="{{ auth()->user()->avatar == null ? asset('images/avatar.jpeg') : Storage::url('photo-users/' . auth()->user()->avatar) }}"
                                                        alt={{ auth()->user()->name }}>
                                                    <div class="text-sm font-normal text-slate-500">
                                                        <div
                                                            class="text-base font-semibold text-slate-900 font-gelasio">
                                                            {{ auth()->user()->name }}
                                                        </div>
                                                        <div class="text-sm font-normal text-slate-500 font-gelasio">
                                                            {{ auth()->user()->email }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td
                                            class="border-b border-gray-300 font-medium py-3 px-6 text-left pr-20 2xl:pr-0">
                                            <div class="flex items-center whitespace-nowrap space-x-2 mr-12 lg:mr-0">
                                                <img class="size-12 rounded-sm object-cover object-center"
                                                    src="{{ optional($top->item)->image == null ? asset('images/no-image.jpeg') : Storage::url('photo-items/' . optional($top->item)->image) }}"
                                                    alt="Avatar">
                                                <div class="text-sm font-normal text-slate-500">
                                                    <div class="text-base font-semibold text-slate-900 font-gelasio">
                                                        {{ optional($top->item)->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td
                                            class="border-b border-gray-300 font-medium py-3 px-6 text-left font-gelasio">
                                            {{ $top->quantity }}
                                        </td>

                                        <td
                                            class="border-b border-gray-300 font-medium py-3 px-6 text-left font-gelasio">
                                            {{ $top->created_at->format('d-m-Y') }}
                                        </td>

                                        <td class="border-b border-gray-300 py-3 px-6 pe-6 text-left">
                                            <div
                                                class="{{ $top->type == 'loan' ? 'bg-cyan-500 text-white' : 'bg-green-500 text-white' }} rounded-xl flex justify-center items-center px-4 py-2 max-w-max uppercase font-gelasio">
                                                {{ $top->type }}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 font-gelasio">No data found.</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if (auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')
                <div class="col-span-5 xl:col-span-2 w-full bg-white rounded-lg shadow">
                    <div class="border-b border-gray-300 px-5 py-4">
                        <h4 class="font-poppins text-slate-950 font-semibold text-lg">Top Loan Products
                        </h4>
                    </div>
                    <div class="px-5 py-4">
                        @forelse ($topFiveLoaners as $top)
                            <div class="flex justify-between items-center gap-4 mb-4">
                                <div class="flex items-center gap-4">
                                    <p class="text-4xl font-gelasio text-slate-300">{{ $loop->iteration }}</p>
                                    <div class="flex gap-2">
                                        <img src="{{ $top->avatar == null ? asset('images/avatar.jpeg') : Storage::url('photo-users/' . $top->avatar) }}"
                                            alt="{{ $top->name }}"
                                            class="size-12 rounded-full object-cover object-center">
                                        <div class="flex flex-col">
                                            <p class="text-slate-950 font-gelasio">{{ $top->name }}</p>
                                            <p class="text-slate-500 font-gelasio">{{ $top->email }}</p>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-white font-gelasio text-xl bg-primary px-2 py-2 rounded-lg">
                                    {{ $top->total_quantity }}</p>
                            </div>
                        @empty
                            <p class="text-center text-slate-500 font-gelasio">No data found.</p>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-dashboard.layout>

</html>
