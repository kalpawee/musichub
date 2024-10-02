@extends('layouts.ct')

@section('content')
    <!-- Hero Section -->
    <section class="banner relative h-[60vh] bg-cover bg-center" style="background-image: url('{{ asset('images/news.png') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative z-10 flex flex-col justify-center items-start h-full text-white px-12">
            <h1 class="text-2xl md:text-2xl lg:text-2xl font-bold">Up Coming Events And News </h1>

        </div>
    </section>

    <!-- Year and Month Filter Section -->
    <section class="p-6">
        <div class="bg-white text-black p-6 rounded-lg shadow-md" style="background-color: #e3b0b0">
            <!-- Year and Month Selection -->
            <div class="flex justify-center items-center mb-4">
                <button id="prev-year-btn" class="px-3 py-1 bg-gray-200 text-black font-semibold rounded-l-lg">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <span id="selected-year" class="px-6 py-2  text-black font-semibold">2024</span>
                <button id="next-year-btn" class="px-3 py-1 bg-gray-200 text-black font-semibold rounded-r-lg">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <div class="flex justify-center text-white gap-2 mb-6" id="month-buttons">
                <button class="month-button px-4 py-2 text-sm font-semibold border rounded-full cursor-pointer" data-month="1">Jan</button>
                <button class="month-button px-4 py-2 text-sm font-semibold border rounded-full cursor-pointer" data-month="2">Feb</button>
                <button class="month-button px-4 py-2 text-sm font-semibold border rounded-full cursor-pointer" data-month="3">Mar</button>
                <button class="month-button px-4 py-2 text-sm font-semibold border rounded-full cursor-pointer" data-month="4">Apr</button>
                <button class="month-button px-4 py-2 text-sm font-semibold border rounded-full cursor-pointer selected" data-month="5">May</button>
                <button class="month-button px-4 py-2 text-sm font-semibold border rounded-full cursor-pointer" data-month="6">Jun</button>
                <button class="month-button px-4 py-2 text-sm font-semibold border rounded-full cursor-pointer" data-month="7">Jul</button>
                <button class="month-button px-4 py-2 text-sm font-semibold border rounded-full cursor-pointer" data-month="8">Aug</button>
                <button class="month-button px-4 py-2 text-sm font-semibold border rounded-full cursor-pointer" data-month="9">Sep</button>
                <button class="month-button px-4 py-2 text-sm font-semibold border rounded-full cursor-pointer" data-month="10">Oct</button>
                <button class="month-button px-4 py-2 text-sm font-semibold border rounded-full cursor-pointer" data-month="11">Nov</button>
                <button class="month-button px-4 py-2 text-sm font-semibold border rounded-full cursor-pointer" data-month="12">Dec</button>
            </div>

            <!-- Events Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="events-grid">
                <!-- Items will be dynamically inserted here -->
            </div>
        </div>

    </section>


    <!-- News Section -->
    <section class="p-6">
        <div class="bg-white text-black p-6 rounded-lg shadow-md" style="background-color: #e3b0b0">
            <!-- News section header -->
            <h1 class="justify-center text-2xl font-bold mb-4 text-center">News</h1>

            <!-- Article 1 -->
            <div class="flex mb-4">
                <img src="{{ asset('images/logo-1.png') }}" alt="Concert Announcement" class="w-1/3 h-32 rounded-md mr-4">
                <div class="w-2/3">
                    <h2 class="text-xl font-semibold">Exciting Concert Coming Up!</h2>
                    <p class="text-gray-600">Join us for an unforgettable night of live music featuring top bands in the area! Get your tickets now.</p>
                </div>
            </div>

            <!-- Article 2 -->
            <div class="flex mb-4">
                <img src="{{ asset('images/logo-1.png') }}" alt="New Album Release" class="w-1/3 h-32 rounded-md mr-4">
                <div class="w-2/3">
                    <h2 class="text-xl font-semibold">New Album Release: The Soundtrack of Summer</h2>
                    <p class="text-gray-600">Check out the latest album from local artist Jane Doe, now available on all streaming platforms!</p>
                </div>
            </div>

            <!-- Article 3 -->
            <div class="flex mb-4">
                <img src="{{ asset('images/logo-1.png') }}" alt="Music Festival Announcement" class="w-1/3 h-32 rounded-md mr-4">
                <div class="w-2/3">
                    <h2 class="text-xl font-semibold">Annual Music Fiesta Festival Announced</h2>
                    <p class="text-gray-600">The Music Fiesta Hub is excited to announce this year’s festival, featuring food, fun, and fantastic performances!</p>
                </div>
            </div>

            <!-- Article 4 -->
            <div class="flex mb-4">
                <img src="{{ asset('images/logo-1.png') }}" alt="Band Interview" class="w-1/3 h-32 rounded-md mr-4">
                <div class="w-2/3">
                    <h2 class="text-xl font-semibold">Exclusive Interview with Local Band: The Soundwaves</h2>
                    <p class="text-gray-600">Read our exclusive interview with The Soundwaves as they discuss their musical journey and future plans!</p>
                </div>
            </div>

            <!-- Article 5 -->
            <div class="flex">
                <img src="{{ asset('images/logo-1.png') }}" alt="Music Workshops" class="w-1/3 h-32 rounded-md mr-4">
                <div class="w-2/3">
                    <h2 class="text-xl font-semibold">Upcoming Music Workshops</h2>
                    <p class="text-gray-600">Sign up for our music workshops and learn from industry professionals. Perfect for all skill levels!</p>
                </div>
            </div>
        </div>
    </section>



@endsection

@push('scripts')
    <script>
        let offset = 8;
        let selectedCategory = 'all';
        let selectedYear = 2024;
        let selectedMonth = 1;

        document.addEventListener('DOMContentLoaded', function () {
            const categoryButtons = document.querySelectorAll('.category-button');
            const monthButtons = document.querySelectorAll('.month-button');
            const viewMoreBtn = document.getElementById('view-more-btn');
            const yearSpan = document.getElementById('selected-year');
            const prevYearBtn = document.getElementById('prev-year-btn');
            const nextYearBtn = document.getElementById('next-year-btn');


            // Handle Month Selection
            monthButtons.forEach(button => {
                button.addEventListener('click', function () {
                    monthButtons.forEach(btn => {
                        btn.classList.remove('selected')
                        btn.style.backgroundColor = '';
                        btn.style.color = '#eaeff4';
                    });
                    this.classList.add('selected');
                    this.style.backgroundColor = '#d6b3b3';
                    this.style.color = '#fff';
                    selectedMonth = this.getAttribute('data-month');
                    offset = 0; // Reset offset
                    loadItemsByDate(selectedYear, selectedMonth, offset, true);
                });
            });

            // Handle Year Selection
            prevYearBtn.addEventListener('click', function () {
                selectedYear--;
                yearSpan.textContent = selectedYear;
                offset = 0;
                loadItemsByDate( selectedYear, selectedMonth, offset, true);
            });

            nextYearBtn.addEventListener('click', function () {
                selectedYear++;
                yearSpan.textContent = selectedYear;
                offset = 0;
                loadItemsByDate(selectedYear, selectedMonth, offset, true);
            });



            // Function to Load Items by Date
            function loadItemsByDate(year, month, offset, reset = false) {
                fetch(`/filter-items-by-date?year=${year}&month=${month}&offset=${offset}`)
                    .then(response => response.json())
                    .then(data => {
                        const grid = document.getElementById('events-grid');

                        if (reset) {
                            grid.innerHTML = '';  // Clear existing items when filtering
                        }

                        data.forEach(item => {
                            grid.innerHTML += `
                                <a href="/item/${item.id}" class="block">
                                    <div class="bg-white p-4 rounded-lg shadow-md">
                                        <img src="/${item.thumbnail_image}" alt="${item.title}" class="w-full h-32 object-cover mb-4 rounded">
                                        <h3 class="text-lg font-bold mb-2">${item.title}</h3>
                                        <p class="text-gray-700 text-sm mb-2">${item.small_description}</p>
                                        <p class="text-sm text-gray-500 mb-2">Location: ${item.location}</p>
                                        <p class="text-sm text-gray-500 mb-2">Category: ${item.categories.map(c => c.name).join(', ')}</p>
                                        <p class="text-sm text-gray-500 mb-2">Date: ${item.date}</p>
                                    </div>
                                </a>
                            `;
                        });

                        offset += 8;  // Increment the offset for "View More"
                    })
                    .catch(error => console.error('Error fetching items:', error));
            }


            // Initial load
            loadItemsByDate(selectedYear, selectedMonth, offset, true);

        });
    </script>
@endpush
