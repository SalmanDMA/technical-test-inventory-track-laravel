<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<x-head title="Dashboard Activities" />

<x-dashboard.layout>
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-slate-200 lg:mt-1.5">
        <div class="mb-1 w-full">
            <div class="mb-4">
                <h1 class="text-xl sm:text-2xl font-semibold text-slate-900 font-poppins">All Activities</h1>
            </div>
            <div class="flex flex-wrap sm:flex-nowrap">
                <div class="sm:divide-x sm:divide-slate-100 mb-3 sm:mb-0 w-full sm:w-64 xl:w-96">
                    <form class="lg:pr-3" action="{{ route('dashboard.activities') }}" method="GET">
                        <label for="activity-search" class="sr-only">Search</label>
                        <div class="mt-1 relative w-full">
                            <input type="text" name="search" id="activity-search"
                                class="bg-slate-50 border border-slate-300 text-slate-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 font-gelasio"
                                placeholder="Search activity by name here...">
                        </div>
                    </form>
                </div>
                <div class="sm:ml-auto w-full sm:max-w-[130px]">
                    <form action="{{ route('dashboard.activities.export') }}" method="GET">
                        <button type="submit"
                            class="w-full text-slate-900 bg-white border border-slate-300 hover:bg-slate-100 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center justify-center rounded-lg text-sm px-3 py-2 text-center h-full font-gelasio">
                            <i class="fa-solid fa-file-arrow-down -ml-1 mr-2 text-xl"></i>
                            Export
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="align-middle inline-block min-w-full">
                <div class="shadow overflow-auto">
                    <table class="table-auto min-w-full divide-y divide-slate-200 w-full">
                        <thead class="bg-slate-100">
                            <tr>
                                <th scope="col"
                                    class="p-4 text-left text-xs font-medium text-slate-500 uppercase font-poppins">
                                    No
                                </th>
                                <th scope="col"
                                    class="p-4 text-left text-xs font-medium text-slate-500 uppercase font-poppins">
                                    User Name
                                </th>
                                <th scope="col"
                                    class="p-4 text-left text-xs font-medium text-slate-500 uppercase font-poppins">
                                    Item Name
                                </th>
                                <th scope="col"
                                    class="p-4 text-left text-xs font-medium text-slate-500 uppercase font-poppins">
                                    Quantity
                                </th>
                                <th scope="col"
                                    class="p-4 text-left text-xs font-medium text-slate-500 uppercase font-poppins">
                                    Date
                                </th>
                                <th scope="col"
                                    class="p-4 text-left text-xs font-medium text-slate-500 uppercase font-poppins">
                                    Type
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @forelse ($activities as $activity)
                                <tr class="hover:bg-slate-100">
                                    <td class="p-4 whitespace-nowrap text-base font-bold text-slate-300">
                                        {{ $loop->iteration + $activities->firstItem() - 1 }}</td>
                                    <td class="p-4 flex items-center whitespace-nowrap space-x-2 mr-12 lg:mr-0">
                                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')
                                            <div class="flex items-center space-x-2">
                                                <img class="size-10 rounded-full object-cover object-center"
                                                    src="{{ optional($activity->user)->avatar == null ? asset('images/avatar.jpeg') : Storage::url('photo-users/' . optional($activity->user)->avatar) }}"
                                                    alt="Avatar">
                                                <div class="pr-4 lg:pr-0">
                                                    <p
                                                        class="text-base font-normal text-slate-900 pr-4 lg:pr-8 2xl:pr-0 font-gelasio">
                                                        {{ optional($activity->user)->name }}
                                                    </p>
                                                    <p
                                                        class="text-base font-normal text-slate-900 pr-4 lg:pr-8 2xl:pr-0 font-gelasio">
                                                        {{ optional($activity->user)->email }}
                                                    </p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex items-center space-x-2">
                                                <img class="size-10 rounded-full object-cover object-center"
                                                    src="{{ auth()->user()->avatar == null ? asset('images/avatar.jpeg') : Storage::url('photo-users/' . auth()->user()->avatar) }}"
                                                    alt="Avatar">
                                                <div class="pr-4 lg:pr-0">
                                                    <p
                                                        class="text-base font-normal text-slate-900 pr-4 lg:pr-8 2xl:pr-0 font-gelasio">
                                                        {{ auth()->user()->name }}
                                                    </p>
                                                    <p
                                                        class="text-base font-normal text-slate-900 pr-4 lg:pr-8 2xl:pr-0 font-gelasio">
                                                        {{ auth()->user()->email }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    </td>

                                    <td class="p-4 whitespace-nowrap mr-6 lg:mr-0">
                                        <div class="flex items-center space-x-2">
                                            <img class="size-10 rounded-full object-cover object-center"
                                                src="{{ optional($activity->item)->image == null ? asset('images/avatar.jpeg') : Storage::url('photo-items/' . optional($activity->item)->image) }}"
                                                alt="Avatar">
                                            <div class="text-sm font-normal text-slate-500">
                                                <div class="pr-4 lg:pr-0">
                                                    <p
                                                        class="text-base font-normal text-slate-900 pr-4 lg:pr-8 2xl:pr-0 font-gelasio">
                                                        {{ optional($activity->item)->name }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td
                                        class="p-4 whitespace-nowrap text-sm font-medium text-center xl:text-start font-gelasio">
                                        {{ $activity->quantity }}
                                    </td>

                                    <td class="p-4 whitespace-nowrap text-sm font-normal text-slate-900 font-gelasio">
                                        {{ $activity->created_at->format('d-m-Y') }}
                                    </td>

                                    <td class="p-4 whitespace-nowrap text-sm font-normal">
                                        <div
                                            class="{{ $activity->type == 'loan' ? 'bg-cyan-500 text-white' : 'bg-green-500 text-white' }} rounded-xl flex justify-center items-center px-2 py-1 xl:px-4 xl:py-2 max-w-max uppercase font-gelasio">
                                            {{ $activity->type }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 font-gelasio">No data found.</td>
                                </tr>
                            @endforelse
                        </tbody>

                        @if ($activities->hasPages())
                            <tfoot>
                                <tr>
                                    <td colspan="6" class="py-4">
                                        <div class="flex justify-between">
                                            {{ $activities->links('pagination::tailwind') }}
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        @endif

                    </table>
                </div>
            </div>
        </div>

    </div>

</x-dashboard.layout>

</html>
