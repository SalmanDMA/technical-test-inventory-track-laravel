<div class="bg-white fixed left-1/2 transform -translate-x-1/2 -translate-y-1/2 sm:max-w-xl transition-all duration-300 ease-in-out z-[70] flex flex-col gap-4 p-8 rounded-xl w-[90%] sm:w-full"
    id="modal">
    <div class="flex justify-between items-center">
        <h3 class="font-poppins text-slate-950 font-semibold text-xl">{{ $title }}</h3>
        <i class="fa-solid fa-xmark text-xl text-slate-500 cursor-pointer" id="iconCloseModal"></i>
    </div>
    {{ $slot }}
</div>
