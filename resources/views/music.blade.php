@extends('layouts.ct')

@section('content')
    <!-- Hero Section -->
    <section class="banner relative h-[60vh] bg-cover bg-center" style="background-image: url('{{ asset('images/music-01.png') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative z-10 flex flex-col justify-center items-start h-full text-white px-12">
            <h1 class="text-2xl md:text-2xl lg:text-2xl font-bold">MUSIC</h1>

        </div>
    </section>


    <!-- Locations Filter Section -->
    <section class="p-6">
        <div class="bg-white p-6 rounded-lg shadow-md" style="background-color: #a1c1e6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Select A City</h2>
            <!-- Locations Filter -->
            <div id="locations" class="flex flex-wrap gap-2 mb-4">
                <a href="{{ url()->current() }}" class="location-button inline-block px-3 py-1 text-sm font-semibold border rounded-full cursor-pointer {{ $selectedLocation === 'all' ? 'selected' : '' }}"
                   style="border-color: #333; color: {{ $selectedLocation === 'all' ? '#fff' : '#333' }}; background-color: {{ $selectedLocation === 'all' ? '#333' : 'transparent' }};">
                    All
                </a>
                @foreach ($locations as $location)
                    <a href="{{ url()->current() }}?location={{ $location->location }}" class="location-button inline-block px-3 py-1 text-sm font-semibold border rounded-full cursor-pointer {{ $selectedLocation === $location->location ? 'selected' : '' }}"
                       style="border-color: #333; color: {{ $selectedLocation === $location->location ? '#fff' : '#333' }}; background-color: {{ $selectedLocation === $location->location ? '#333' : 'transparent' }};">
                        {{ $location->location }}
                    </a>
                @endforeach
            </div>

            <!-- Items Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="events-grid">
                @foreach ($items as $item)
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <img src="{{ asset($item->thumbnail_image) }}" alt="{{ $item->title }}" class="w-full h-32 object-cover mb-4 rounded">
                        <h3 class="text-lg font-bold mb-2" style="color: #0c0606">{{ $item->title }}</h3>
                        <p class="text-gray-700 text-sm mb-2">{{ $item->small_description }}</p>
                        <p class="text-sm text-gray-500 mb-2">Location: {{ $item->location }}</p>
                        <p class="text-sm text-gray-500 mb-2">Category: {{ $item->categories->pluck('name')->join(', ') }}</p>
                    </div>
                @endforeach
            </div>


        </div>
    </section>


@endsection

@push('scripts')
    <script>
        let offset = 8;  // Default offset to load more items
        let selectedLocation = 'all';  // Default selected location

        document.addEventListener('DOMContentLoaded', function () {
            const locationButtons = document.querySelectorAll('.location-button');


            // Handle Location Filtering
            locationButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Update button appearance
                    locationButtons.forEach(btn => {
                        btn.classList.remove('selected');
                        btn.style.backgroundColor = '';
                        btn.style.color = '#333';
                    });

                    this.classList.add('selected');
                    this.style.backgroundColor = '#333';
                    this.style.color = '#fff';

                    selectedLocation = this.getAttribute('data-location-id');
                    offset = 0;  // Reset the offset when changing the location
                    loadItems(selectedLocation, offset, true);  // Load new filtered items
                });
            });



            // Function to Load Items
            function loadItems(locationId, offset, reset = false) {
                fetch(`/filter-items-by-location?location_id=${locationId}&offset=${offset}`)
                    .then(response => response.json())
                    .then(data => {
                        const grid = document.getElementById('events-grid');

                        if (reset) {
                            grid.innerHTML = '';  // Clear existing items when filtering by a new location
                        }

                        data.forEach(item => {
                            grid.innerHTML += `
                            <div class="bg-white p-4 rounded-lg shadow-md">
                                <img src="/${item.thumbnail_image}" alt="${item.title}" class="w-full h-32 object-cover mb-4 rounded">
                                <h3 class="text-lg font-bold mb-2">${item.title}</h3>
                                <p class="text-gray-700 text-sm mb-2">${item.small_description}</p>
                                <p class="text-sm text-gray-500 mb-2">Location: ${item.location}</p>
                                <p class="text-sm text-gray-500 mb-2">Category: ${item.categories.map(category => category.name).join(', ')}</p>
                            </div>
                        `;
                        });

                        offset += 8;  // Increment the offset for the next "View More" action
                    })
                    .catch(error => console.error('Error fetching items:', error));
            }

            // Initial load
            loadItems(selectedLocation, offset, true);
        });
    </script>
@endpush
