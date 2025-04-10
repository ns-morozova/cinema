{{-- тестовый массив --}}
<x-app-layout>
    <x-admin.hall-management :halls="$halls" />
    <x-admin.hall-configuration :halls="$halls" />
    <x-admin.price-configuration :halls="$halls" />
    <x-admin.session-grid :halls="$halls" />
    <x-admin.opening-sales/>
</x-app-layout>