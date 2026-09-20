@extends('layouts.app')

@section('title', $pageTitle)

@section('content')

<section class="section">

 
{{-- Devices --}}
<div class="swiper deviceSwiper">
    <div class="swiper-wrapper">

        @forelse ($devices as $device)

            @php
                $latest = $device->latestSensorReading;
                $isActive = $device->status === 'active';
            @endphp

            <div class="swiper-slide">

                <div class="card h-100">

                    <div class="card-body">

                        {{-- Device Header --}}
                        <div class="d-flex justify-content-between align-items-start mb-3">

                            <div>
                                <h5 class="card-title mb-1">
                                    {{ $device->device_name ?? 'Unnamed Device' }}
                                </h5>

                                <small class="text-muted">
                                    {{ $device->device_uid }}
                                </small>
                            </div>

                            <span class="badge {{ $isActive ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($device->status) }}
                            </span>

                        </div>


                        {{-- Device Information --}}
                        <div class="mb-3">

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Heart Rate</span>

                                <strong>
                                    {{ $latest?->heart_rate ?? '--' }}
                                    <small>BPM</small>
                                </strong>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Temperature</span>

                                <strong>
                                    {{ $latest?->body_temperature ?? '--' }}
                                    <small>°C</small>
                                </strong>
                            </div>

                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Battery</span>

                                <strong>
                                    {{ $latest?->battery_level ?? '--' }}%
                                </strong>
                            </div>

                        </div>


                        {{-- Last Seen --}}
                        <div class="border-top pt-3">

                            <small class="text-muted">
                                Last seen
                            </small>

                            <div>
                                {{ $device->last_seen_at?->diffForHumans() ?? 'Never' }}
                            </div>

                        </div>


                        {{-- View Device --}}
                        <div class="mt-3">

                            <a href="{{ route('patient.devices.readings', $device) }}"
                               class="btn btn-primary w-100">
                                View Device
                            </a>

                        </div>

                    </div>

                </div>

       
       
       
            </div>

        @empty

            <div class="swiper-slide">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-cpu fs-1 text-muted"></i>

                        <h5 class="mt-3">
                            No Devices
                        </h5>

                        <p class="text-muted mb-0">
                            No devices are currently assigned to you.
                        </p>
                    </div>
                </div>
            </div>

        @endforelse

    </div>

    {{-- Scrollbar --}}
    <div class="swiper-scrollbar"></div>

</div>
 

</section>

@endsection


@push('scripts')

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        new Swiper('.deviceSwiper', {

            slidesPerView: 1,
            spaceBetween: 20,

            breakpoints: {

                // Mobile
                576: {
                    slidesPerView: 1.2,
                    spaceBetween: 20
                },

                // Tablet
                768: {
                    slidesPerView: 2,
                    spaceBetween: 24
                },

                // Desktop
                1200: {
                    slidesPerView: 3,
                    spaceBetween: 24
                }

            },

            scrollbar: {
                el: '.deviceSwiper .swiper-scrollbar',
                draggable: true
            },

            grabCursor: true

        });

    });
</script>
@endpush


 