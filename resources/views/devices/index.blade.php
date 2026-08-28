<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                ESP32 Devices
            </h2>

            <a
                href="{{ route('devices.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded"
            >
                + Register ESP32
            </a>
        </div>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif


            <div class="bg-white shadow-sm rounded-lg overflow-hidden">

                <table class="w-full">

                    <thead class="bg-gray-100">

                        <tr>
                            <th class="p-4 text-left">
                                Device
                            </th>

                            <th class="p-4 text-left">
                                MAC
                            </th>

                            <th class="p-4 text-left">
                                Status
                            </th>

                            <th class="p-4 text-left">
                                Last Seen
                            </th>

                            <th class="p-4 text-left">
                                Action
                            </th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($devices as $device)

                            <tr class="border-t">

                                <td class="p-4">

                                    <strong>
                                        {{ $device->device_name ?? 'Unnamed Device' }}
                                    </strong>

                                    <div class="text-sm text-gray-500">
                                        {{ $device->device_uid }}
                                    </div>

                                </td>

                                <td class="p-4">
                                    {{ $device->mac_address }}
                                </td>

                                <td class="p-4">

                                    @if($device->status === 'active')

                                        <span class="text-green-600">
                                            ● Active
                                        </span>

                                    @else

                                        <span class="text-red-600">
                                            ● Inactive
                                        </span>

                                    @endif

                                </td>

                                <td class="p-4">
                                    {{ $device->last_seen_at?->diffForHumans() ?? 'Never' }}
                                </td>

                                <td class="p-4">

                                    <a
                                        href="{{ route('devices.show', $device) }}"
                                        class="text-blue-600"
                                    >
                                        View
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="p-8 text-center text-gray-500"
                                >
                                    No ESP32 devices registered.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>