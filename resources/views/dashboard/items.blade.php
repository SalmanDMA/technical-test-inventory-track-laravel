<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<x-head title="Dashboard Items" />

<x-dashboard.layout>
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-slate-200 lg:mt-1.5">
        <div class="mb-1 w-full">
            <div class="mb-4">
                <h1 class="text-xl sm:text-2xl font-semibold text-slate-900 font-poppins">
                    {{ auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin' ? 'Management items' : 'List items for loan' }}
                </h1>
            </div>
            <div class="flex flex-wrap sm:flex-nowrap">
                <div class="sm:divide-x sm:divide-slate-100 mb-3 sm:mb-0 w-full sm:w-64 xl:w-96">
                    <form class="lg:pr-3" action="{{ route('dashboard.items') }}" method="GET">
                        <label for="items-search" class="sr-only">Search</label>
                        <div class="mt-1 relative w-full">
                            <input type="text" name="search" id="items-search"
                                class="bg-slate-50 border border-slate-300 text-slate-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 font-gelasio"
                                placeholder="Search items by name here...">
                        </div>
                    </form>
                </div>
                @if (auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')
                    <div class="grid grid-cols-2 gap-2 sm:ml-auto w-full sm:max-w-[270px]">
                        <a href="{{ route('dashboard.items.add') }}"
                            class="w-full text-white bg-primary hover:bg-primary/90 focus:ring-4 focus:ring-primary/50 font-medium inline-flex items-center justify-center rounded-lg text-sm px-3 py-2 text-center sm:w-auto">
                            <i class="fa-solid fa-plus -ml-1 mr-2 text-lg font-gelasio"></i>
                            Add Item
                        </a>
                        <form action="{{ route('dashboard.items.export') }}" method="GET">
                            <button type="submit"
                                class="w-full text-slate-900 bg-white border border-slate-300 hover:bg-slate-100 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center justify-center rounded-lg text-sm px-3 py-2 text-center h-full">
                                <i class="fa-solid fa-file-arrow-down -ml-1 mr-2 text-xl font-gelasio"></i>
                                Export
                            </button>
                        </form>
                    </div>
                @endif
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
                                    Availability
                                </th>
                                <th scope="col"
                                    class="p-4 text-left text-xs font-medium text-slate-500 uppercase font-poppins">
                                    Quantity
                                </th>
                                @if (auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')
                                    <th scope="col"
                                        class="p-4 text-left text-xs font-medium text-slate-500 uppercase font-poppins">
                                        Action
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @forelse ($items as $item)
                                <tr class="hover:bg-slate-100">
                                    <td class="p-4 whitespace-nowrap text-base font-bold text-slate-300 font-gelasio">
                                        {{ $loop->iteration + $items->firstItem() - 1 }}</td>
                                    <td class="p-4 flex items-center whitespace-nowrap space-x-4 mr-12 lg:mr-0">
                                        <img class="size-12 rounded-sm object-cover object-center"
                                            src="{{ $item->image == null ? asset('images/no-image.jpeg') : Storage::url('photo-items/' . $item->image) }}"
                                            alt="{{ $item->name }}">
                                        <div class="text-sm font-normal text-slate-500">
                                            <div class="text-base font-semibold text-slate-900 font-gelasio">
                                                {{ $item->name }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-sm font-medium">
                                        <div
                                            class="{{ $item->availability == 'available' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }} rounded-xl flex justify-center items-center px-4 py-2 max-w-max font-gelasio">
                                            {{ $item->availability }}
                                        </div>
                                    </td>

                                    <td class="p-4 whitespace-nowrap text-base font-normal text-slate-900 font-gelasio">
                                        {{ $item->quantity }}
                                    </td>
                                    @if (auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')
                                        <td class="p-4 whitespace-nowrap space-x-2">
                                            <a href="{{ route('dashboard.items.update', ['id' => $item->id]) }}"
                                                class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                <i class="fa-solid fa-pen-to-square text-lg"></i>
                                            </a>
                                            <button type="button" data-id="{{ $item->id }}"
                                                class="buttonDelete text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                <i class="fa-solid fa-trash-can text-lg"></i>
                                            </button>
                                        </td>
                                    @endif

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin' ? '5' : '4' }}}"
                                        class="text-center py-4 font-gelasio">No items found.</td>
                                </tr>
                            @endforelse
                        </tbody>

                        @if ($items->hasPages())
                            <tfoot>
                                <tr>
                                    <td colspan="6" class="py-4">
                                        <div class="flex justify-between">
                                            {{ $items->links('pagination::tailwind') }}
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        @endif

                    </table>
                </div>
            </div>
        </div>

        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')
            <x-overlay />
            <x-modal title="Delete Item">
                <h3 class="font-gelasio font-medium text-lg">Are you sure you want to delete this item?</h3>
                <form id="itemForm">
                    <div class="flex justify-end space-x-2 mt-4">
                        <button type="button" id="buttonCloseModal"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center font-gelasio">
                            Cancel
                        </button>
                        <button type="submit"
                            class="text-white bg-primary hover:bg-primary/90 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center font-gelasio">
                            Delete
                        </button>
                    </div>
                </form>
            </x-modal>
        @endif


    </div>

    <script>
        $(document).ready(function() {
            $('.buttonDelete').on('click', function() {
                const id = $(this).data('id');
                toggleModal();

                $('#itemForm').on('submit', function(e) {
                    e.preventDefault();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: 'DELETE',
                        url: "{{ route('dashboard.items.delete', ['id' => ':id']) }}"
                            .replace(
                                ':id', id),
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                setTimeout(() => {
                                    window.location.href =
                                        "{{ route('dashboard.items') }}";
                                }, 1000);
                            }
                        },
                        error: function(xhr, status, error) {
                            if (xhr.status === 422) {
                                toastr.error(xhr.responseJSON.message[0]);
                            }
                            console.error(xhr.responseText);
                        }
                    });
                })
            })

            $('#overlay').on('click', function() {
                closeModal();
            });

            $('#iconCloseModal').on('click', function() {
                closeModal();
            });

            $('#buttonCloseModal').on('click', function() {
                closeModal();
            });

            function toggleModal() {
                $('#modal').toggleClass('open');
                $('#overlay').toggleClass('open');
            }

            function closeModal() {
                $('#modal').removeClass('open');
                $('#overlay').removeClass('open');
            }
        });
    </script>

</x-dashboard.layout>

</html>
