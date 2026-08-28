<x-app-layout>

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800">
            Register ESP32
        </h2>

    </x-slot>


    <div class="py-12">

        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow-sm rounded-lg">

                <form
                    method="POST"
                    action="{{ route('devices.store') }}"
                >

                    @csrf


                    <div class="mb-4">

                        <label class="block font-medium">
                            Device UID
                        </label>

                        <input
                            type="text"
                            name="device_uid"
                            value="{{ old('device_uid') }}"
                            placeholder="ESP32-001"
                            class="w-full border-gray-300 rounded"
                            required
                        >

                        @error('device_uid')
                            <p class="text-red-600 text-sm">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    <div class="mb-4">

                        <label class="block font-medium">
                            MAC Address
                        </label>

                        <input
                            type="text"
                            name="mac_address"
                            value="{{ old('mac_address') }}"
                            placeholder="AA:BB:CC:DD:EE:FF"
                            class="w-full border-gray-300 rounded"
                            required
                        >

                        @error('mac_address')
                            <p class="text-red-600 text-sm">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    <div class="mb-4">

                        <label class="block font-medium">
                            Device Name
                        </label>

                        <input
                            type="text"
                            name="device_name"
                            value="{{ old('device_name') }}"
                            placeholder="Patient Monitor 01"
                            class="w-full border-gray-300 rounded"
                        >

                    </div>


                    <div class="mb-6">

                        <label class="block font-medium">
                            Firmware Version
                        </label>

                        <input
                            type="text"
                            name="firmware_version"
                            value="{{ old('firmware_version') }}"
                            placeholder="1.0.0"
                            class="w-full border-gray-300 rounded"
                        >

                    </div>


                    <button
                        type="submit"
                        class="px-5 py-2 bg-blue-600  rounded"
                    >
                        Register Device
                    </button>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>