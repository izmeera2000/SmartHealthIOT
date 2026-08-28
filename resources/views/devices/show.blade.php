<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between">

            <h2 class="font-semibold text-xl text-gray-800">
                {{ $device->device_name ?? $device->device_uid }}
            </h2>

            <a
                href="{{ route('devices.readings', $device) }}"
                class="text-blue-600 text-white"
            >
                View All Readings
            </a>

        </div>

    </x-slot>


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            @if(session('success'))

                <div class="mb-6 p-4 bg-green-100 text-green-800 rounded">

                    {{ session('success') }}

                </div>

            @endif


            <!-- Device Information -->

            <div class="bg-white p-6 rounded-lg shadow mb-6">

                <h3 class="text-lg font-bold mb-4">
                    Device Information
                </h3>

                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <strong>UID:</strong>
                        {{ $device->device_uid }}
                    </div>

                    <div>
                        <strong>MAC:</strong>
                        {{ $device->mac_address }}
                    </div>

                    <div>
                        <strong>Firmware:</strong>
                        {{ $device->firmware_version ?? '-' }}
                    </div>

                    <div>
                        <strong>Status:</strong>
                        {{ ucfirst($device->status) }}
                    </div>

                    <div>
                        <strong>Last Seen:</strong>
                        {{ $device->last_seen_at?->diffForHumans() ?? 'Never' }}
                    </div>

                </div>

            </div>


            <!-- Latest Reading -->

            <div class="bg-white p-6 rounded-lg shadow mb-6">

                <h3 class="text-lg font-bold mb-4">
                    Latest Reading
                </h3>


                @if($latestReading)

                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">

                        <div class="p-4 bg-gray-100 rounded">
                            <div class="text-gray-500">
                                Heart Rate
                            </div>

                            <div class="text-2xl font-bold">
                                {{ $latestReading->heart_rate ?? '--' }}
                                BPM
                            </div>
                        </div>


                        <div class="p-4 bg-gray-100 rounded">

                            <div class="text-gray-500">
                                SpO₂
                            </div>

                            <div class="text-2xl font-bold">
                                {{ $latestReading->spo2 ?? '--' }}%
                            </div>

                        </div>


                        <div class="p-4 bg-gray-100 rounded">

                            <div class="text-gray-500">
                                Body Temp
                            </div>

                            <div class="text-2xl font-bold">
                                {{ $latestReading->body_temperature ?? '--' }}
                                °C
                            </div>

                        </div>


                        <div class="p-4 bg-gray-100 rounded">

                            <div class="text-gray-500">
                                Ambient
                            </div>

                            <div class="text-2xl font-bold">
                                {{ $latestReading->ambient_temperature ?? '--' }}
                                °C
                            </div>

                        </div>


                        <div class="p-4 bg-gray-100 rounded">

                            <div class="text-gray-500">
                                Battery
                            </div>

                            <div class="text-2xl font-bold">
                                {{ $latestReading->battery_level ?? '--' }}%
                            </div>

                        </div>

                    </div>


                    <p class="text-sm text-gray-500 mt-4">

                        Recorded:
                        {{ $latestReading->recorded_at?->format('d M Y H:i:s') }}

                    </p>

                @else

                    <p class="text-gray-500">
                        No sensor readings yet.
                    </p>

                @endif

            </div>


            <!-- TEST READING -->

            <div class="bg-white p-6 rounded-lg shadow">

                <h3 class="text-lg font-bold mb-4">
                    Add Test Sensor Reading
                </h3>

                <p class="text-sm text-gray-500 mb-4">
                    Use this form to simulate an ESP32 reading.
                </p>


                <form
                    method="POST"
                    action="{{ route('devices.readings.store', $device) }}"
                >

                    @csrf


                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">


                        <div>

                            <label>
                                Heart Rate
                            </label>

                            <input
                                type="number"
                                name="heart_rate"
                                value="78"
                                class="w-full border-gray-300 rounded"
                            >

                        </div>


                        <div>

                            <label>
                                SpO₂
                            </label>

                            <input
                                type="number"
                                name="spo2"
                                value="97"
                                class="w-full border-gray-300 rounded"
                            >

                        </div>


                        <div>

                            <label>
                                Body Temperature
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="body_temperature"
                                value="36.7"
                                class="w-full border-gray-300 rounded"
                            >

                        </div>


                        <div>

                            <label>
                                Ambient Temperature
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="ambient_temperature"
                                value="29.5"
                                class="w-full border-gray-300 rounded"
                            >

                        </div>


                        <div>

                            <label>
                                Battery
                            </label>

                            <input
                                type="number"
                                name="battery_level"
                                value="87"
                                class="w-full border-gray-300 rounded"
                            >

                        </div>

                    </div>


                    <button
                        type="submit"
                        class="mt-5 px-5 py-2 bg-green-600  rounded"
                    >
                        Add Test Reading
                    </button>

                </form>

            </div>


        </div>

    </div>

</x-app-layout>