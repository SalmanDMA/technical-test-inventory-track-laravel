<a href="{{ $url }}"
    class="flex gap-4 items-center px-4 py-2 hover:bg-slate-500/20 rounded {{ $activeUrl ? 'bg-slate-500/20' : '' }}">
    <i class="{{ $icon }} text-lg text-slate-300"></i>
    <span class="font-gelasio text-slate-300 text-lg">{{ $title }}</span>
</a>
