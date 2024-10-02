@extends('layouts.host')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Statboard</h1>
        <div class="grid grid-cols-2 gap-4 mb-8">
            <!-- Total Stats Section -->
            <div class="bg-white p-4 rounded-lg shadow mb-8">

                    <h2 class="text-lg font-semibold">Total Events</h2>
                    <p class="text-2xl">{{ $totalAttractions }}</p>

            </div>
            <!-- Total Users Section -->
            <div class="bg-white p-4 rounded-lg shadow mb-8">
                <h2 class="text-lg font-semibold">Total Users</h2>
                <p class="text-2xl">{{ $totalUsers }}</p>
            </div>
            <!-- Total Reviews Section -->
            <div class="bg-white p-4 rounded-lg shadow mb-8">
                <h2 class="text-lg font-semibold">Total Reviews</h2>
                <p class="text-2xl">{{ $totalReviews }}</p>
            </div>
            <!-- Average Rating Section -->
            <div class="bg-white p-4 rounded-lg shadow mb-8">
                <h2 class="text-lg font-semibold">Average Rating</h2>
                <p class="text-2xl">{{ $averageRating ? number_format($averageRating, 1) : 'Not Rated Yet' }} </p>
            </div>
        </div>

        <!-- Reviews Chart Section -->
        <div class="bg-white p-4 rounded-lg shadow mb-8">
            <h2 class="text-lg font-semibold">Reviews Chart</h2>
            <canvas id="reviewsChart" width="400" height="100"></canvas>
        </div>



        <!-- Likes Chart Section -->
        <div class="bg-white p-4 rounded-lg shadow mb-8">
            <h2 class="text-lg font-semibold">Likes Chart</h2>
            <canvas id="likesChart" width="400" height="100"></canvas>
        </div>


        <!-- Calendar Section -->
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="text-lg font-semibold">Upcoming Events</h2>
            <div id="calendar" style="max-width: 80%; margin: 0 auto; height: 500px;"></div>
        </div>

    </div>
@endsection

@push('styles')
    <style>
        /* Calendar Navigation Buttons (Prev, Next, Today) */
        .fc .fc-toolbar.fc-header-toolbar .fc-button {
            background-color: #144c83 !important;  /* Orange background for system */
            color: white !important;               /* White text */
            padding: 5px 10px !important;          /* Adjust padding */
            border: none !important;               /* No border */
        }

        .fc .fc-toolbar.fc-header-toolbar .fc-button:hover {
            background-color: #083e75 !important;  /* Lighter orange on hover */
        }

        /* Active Button */
        .fc .fc-toolbar.fc-header-toolbar .fc-button.fc-button-active {
            background-color: #1760a8 !important;  /* Lighter orange for active button */
        }

        /* Calendar View Buttons (Month, Week, Day) */
        .fc .fc-button-group .fc-button {
            background-color: #333 !important;     /* Dark background for view buttons */
            color: white !important;               /* White text */
            border: none !important;               /* Remove border */
        }

        .fc .fc-button-group .fc-button:hover {
            background-color: #102c49 !important;  /* Orange on hover for view buttons */
        }

        .fc .fc-button-group .fc-button.fc-button-active {
            background-color: #222288 !important;  /* Lighter orange for active view button */
        }

        /* Event Background */
        .fc .fc-event {
            background-color: #0d0d50 !important;  /* Orange for events */
            color: white !important;               /* White text */
            border: none !important;               /* No border */
        }
    </style>
@endpush

@push('scripts')
    <!-- FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>


    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Initialize Calendar -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let calendarEl = document.getElementById('calendar');
            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: @json($upcomingItems),
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                navLinks: true,
                editable: false,
                dayMaxEvents: true
            });
            calendar.render();

            // Initialize Chart.js
            let ctx = document.getElementById('likesChart').getContext('2d');
            let likesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($likeData->pluck('title')),
                    datasets: [{
                        label: 'Likes',
                        data: @json($likeData->pluck('likes_count')),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Initialize Reviews Chart
            let reviewsCtx = document.getElementById('reviewsChart').getContext('2d');
            let reviewsChart = new Chart(reviewsCtx, {
                type: 'bar',
                data: {
                    labels: @json($reviewData->pluck('user_id')),
                    datasets: [{
                        label: 'Reviews',
                        data: @json($reviewData->pluck('review_count')),
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

        });
    </script>
@endpush
