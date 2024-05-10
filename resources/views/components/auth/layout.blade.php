<x-layout-main>
    <main class="bg-slate-100 min-h-screen w-full flex justify-center items-center max-w-[1920px] mx-auto">
        <div class="flex flex-col gap-6 justify-center items-center mx-4 sm:mx-8 w-full max-w-xl">
            <h1 class="text-slate-950 text-3xl font-bold font-poppins">{{ $title }}</h1>
            <div class="bg-white rounded-xl w-full shadow-xl">
                {{ $slot }}
            </div>
        </div>
    </main>
</x-layout-main>
