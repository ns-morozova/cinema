{{-- тестовый массив --}}
<x-app-layout>
    <x-hall-management :halls="$halls" />
    <x-hall-configuration :halls="$halls" />
    <x-price-configuration :halls="$halls" />
    <x-session-grid :halls="$halls" />
    <x-opening-sales/>
</x-app-layout>