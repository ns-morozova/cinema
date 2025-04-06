{{-- тестовый массив --}}
<x-app-layout>
    <main class="conf-steps">
        <x-hall-management :halls="$halls" />
        <x-hall-configuration :halls="$halls" />
        <x-price-configuration :halls="$halls" />
        <x-session-grid :halls="$halls" />
        <x-opening-sales/>
    </main>
</x-app-layout>