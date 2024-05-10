<x-layout-main>
    <div class="flex min-h-screen">
        <x-overlay />
        <x-dashboard.aside />
        <x-dashboard.nav />
        <main class="pb-4 pt-20 sm:pt-24 px-4 lg:pl-80 sm:pl-8 sm:pr-8 bg-slate-100 w-full">
            {{ $slot }}
        </main>
    </div>



    <script>
        $(document).ready(function() {
            $('#dropdownMenuButton').on('click', function() {
                $('#dropdownMenuItem').toggleClass('open');
                $('#dropdownMenuIcon').toggleClass('-rotate-180');
            });

            $('#sidebarToggle').on('click', function() {
                toggleSidebar();
            });


            $('#overlay').on('click', function() {
                closeSidebar();
            });


            window.addEventListener('resize', function() {
                if (window.innerWidth > 1024) {
                    closeSidebar();
                }
            });

            function toggleSidebar() {
                $('#sidebar').toggleClass('open');
                $('#overlay').toggleClass('open');
            }


            function closeSidebar() {
                $('#sidebar').removeClass('open');
                $('#overlay').removeClass('open');
            }
        });
    </script>
</x-layout-main>
