<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between">

            <h2 class="font-semibold text-xl text-gray-800">
                Sensor Readings
            </h2>

            <a
                href="{{ route('devices.show', $device) }}"
                class=" text-white"
            >
                ← Back to Device
            </a>

        </div>

    </x-slot>


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg overflow-hidden">

                <table class="w-full">

                    <thead class="bg-gray-100">

                        <tr>

                            <th class="p-4 text-left">
                                Recorded
                            </th>

                            <th class="p-4 text-left">
                                HR
                            </th>

                            <th class="p-4 text-left">
                                SpO₂
                            </th>

                            <th class="p-4 text-left">
                                Body Temp
                            </th>

                            <th class="p-4 text-left">
                                Ambient
                            </th>

                            <th class="p-4 text-left">
                                Battery
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($readings as $reading)

                            <tr class="border-t">

                                <td class="p-4">
                                    {{ $reading->recorded_at?->format('d/m/Y H:i:s') }}
                                </td>

                                <td class="p-4">
                                    {{ $reading->heart_rate ?? '--' }} BPM
                                </td>

                                <td class="p-4">
                                    {{ $reading->spo2 ?? '--' }}%
                                </td>

                                <td class="p-4">
                                    {{ $reading->body_temperature ?? '--' }} °C
                                </td>

                                <td class="p-4">
                                    {{ $reading->ambient_temperature ?? '--' }} °C
                                </td>

                                <td class="p-4">
                                    {{ $reading->battery_level ?? '--' }}%
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="p-8 text-center text-gray-500"
                                >
                                    No readings available.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <div class="mt-4">

                {{ $readings->links() }}

            </div>

        </div>

    </div>

</x-app-layout>