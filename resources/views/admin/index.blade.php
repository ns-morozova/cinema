{{-- тестовый массив --}}
<x-app-layout>
    <x-admin.hall-management :halls="$halls" />
    <x-admin.hall-configuration :halls="$halls" />
    <x-admin.price-configuration :halls="$halls" />
    <x-admin.session-grid :halls="$halls" :movies="$movies" :movieSessions="$movieSessions" />
    <x-admin.opening-sales :halls="$halls" />
</x-app-layout>