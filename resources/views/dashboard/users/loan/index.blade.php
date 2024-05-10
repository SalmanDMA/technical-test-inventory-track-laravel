<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<x-head title="Dashboard Loan" />

<x-dashboard.layout>
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-slate-200 lg:mt-1.5">
        <div class="mb-1 w-full">
            <div class="mb-4">
                <h1 class="text-xl sm:text-2xl font-semibold text-slate-900">Loan list</h1>
            </div>
            <div class="flex flex-wrap sm:flex-nowrap">
                <div class="sm:divide-x sm:divide-slate-100 mb-3 sm:mb-0 w-full sm:w-64 xl:w-96">
                    <form class="lg:pr-3" action="{{ route('dashboard.loan') }}" method="GET">
                        <label for="loan-search" class="sr-only">Search</label>
                        <div class="mt-1 relative w-full">
                            <input type="text" name="search" id="loan-search"
                                class="bg-slate-50 border border-slate-300 text-slate-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                placeholder="Search loan by name here...">
                        </div>
                    </form>
                </div>
                <div class="grid grid-cols-2 gap-2 sm:ml-auto w-full sm:max-w-[270px]">
                    <a href="{{ route('dashboard.loan.add') }}"
                        class="w-full text-white bg-primary hover:bg-primary/90 focus:ring-4 focus:ring-primary/50 font-medium inline-flex items-center justify-center rounded-lg text-sm px-3 py-2 text-center sm:w-auto">
                        <i class="fa-solid fa-plus -ml-1 mr-2 text-lg"></i>
                        Add loan
                    </a>
                    <form action="{{ route('dashboard.loan.export') }}" method="GET">
                        <button type="submit"
                            class="w-full text-slate-900 bg-white border border-slate-300 hover:bg-slate-100 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center justify-center rounded-lg text-sm px-3 py-2 text-center h-full">
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
                <div class="shadow overflow-hidden">
                    <table class="table-fixed min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-100">
                            <tr>
                                <th scope="col"
                                    class="p-4 text-left text-xs font-medium text-slate-500 uppercase font-poppins">
                                    No
                                </th>
                                <th scope="col"
                                    class="p-4 text-left text-xs font-medium text-slate-500 uppercase font-poppins">
                                    Name Item
                                </th>
                                <th scope="col"
                                    class="p-4 text-left text-xs font-medium text-slate-500 uppercase font-poppins">
                                    Quantity
                                </th>
                                <th scope="col"
                                    class="p-4 text-left text-xs font-medium text-slate-500 uppercase font-poppins">
                                    Date
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @forelse ($activities as $activity)
                                <tr class="hover:bg-slate-100">
                                    <td class="p-4 whitespace-nowrap text-base font-bold text-slate-300">
                                        {{ $loop->iteration + $activities->firstItem() - 1 }}</td>
                                    <td class="p-4 flex items-center whitespace-nowrap space-x-2 mr-12 lg:mr-0">
                                        <img class="size-12 rounded-sm object-cover object-center"
                                            src="{{ optional($activity->item)->image == null ? asset('images/avatar.jpeg') : Storage::url('photo-items/' . optional($activity->item)->image) }}"
                                            alt="Avatar">
                                        <div class="text-sm font-normal text-slate-500">
                                            <div class="text-base font-semibold text-slate-900">
                                                {{ optional($activity->item)->name }}
                                            </div>
                                        </div>
                                    </td>

                                    <td class="p-4 whitespace-nowrap text-base font-normal text-slate-900">
                                        {{ $activity->quantity == null ? '-' : $activity->quantity }}
                                    </td>

                                    <td class="p-4 whitespace-nowrap text-base font-normal text-slate-900">
                                        <div class="flex items-center">
                                            {{ $activity->created_at == null ? '-' : $activity->created_at->format('d-m-Y') }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">No data found.</td>
                                </tr>
                            @endforelse
                        </tbody>

                        @if ($activities->hasPages())
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="py-4">
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
