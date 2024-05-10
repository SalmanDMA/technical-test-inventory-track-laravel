<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<x-head title="Dashboard Return" />

<x-dashboard.layout>
    <div class="mx-auto max-w-screen-2xl">
        <div class="mb-6">
            <a href="{{ route('dashboard.return') }}" class="text-slate-400 hover:text-slate-500 mb-4 inline-block">
                <i class="fa-solid fa-arrow-left"></i>
                Back
            </a>
            <h2 class="text-3xl font-bold text-slate-950">
                Form Layout Add Return
            </h2>
        </div>

        <div class="flex flex-col gap-9">
            <div class="rounded-sm border border-slate-300 bg-white shadow-lg">
                <form class="py-4 px-6 flex flex-col gap-4" method="POST"
                    action="{{ route('dashboard.return.add.post.update') }}">
                    @csrf

                    <div>
                        <label for="item_id" class="mb-3 block text-sm font-medium text-slate-950 ">
                            Item<span class="text-red-500">*</span>
                        </label>
                        <div class="relative z-20 bg-transparent">
                            <select name="item_id" id="item_id"
                                class="relative z-20 appearance-none w-full rounded-lg border-[1.5px] border-primary bg-transparent px-5 py-3 font-normal text-slate-950 outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-slate-300">
                                <option value="" class="font-medium font-gelasio hover:bg-slate-300">
                                    Select Item
                                </option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}"
                                        class="font-medium font-gelasio hover:bg-slate-300">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="absolute right-4 top-1/2 z-30 -translate-y-1/2">
                                <i class="fa-solid fa-chevron-down text-xl text-slate-950"></i>
                            </span>
                        </div>
                    </div>

                    <x-input-field name="quantity" labelName="Quantity" placeholder="Enter your quantity here..."
                        type="number" requiredInput="true" />


                    <div class="mt-4">
                        <button type="submit"
                            class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90 text-white">
                            Add Return
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

</x-dashboard.layout>

</html>
