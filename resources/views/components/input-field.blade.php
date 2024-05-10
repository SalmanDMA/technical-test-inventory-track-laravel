<div class="flex flex-col gap-2 w-full">
    <label for="{{ $name }}" class="text-sm font-medium text-slate-950 font-poppins">
        @if ($requiredInput)
            {{ $labelName }}<span class="text-red-500">*</span>
        @else
            {{ $labelName }}
        @endif
    </label>
    <input type="{{ $type }}" placeholder="{{ $placeholder }}" id="{{ $name }}" name="{{ $name }}"
        class="w-full rounded-lg border-[1.5px] border-primary bg-transparent px-5 py-3 font-normal text-slate-950 outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-slate-300 font-gelasio"
        value="{{ $value }}">

    @error($name)
        <p class="text-sm font-medium text-red-500 font-gelasio">{{ $message }}</p>
    @enderror
</div>
