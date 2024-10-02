@extends('layouts.ct')

@section('content')
    <!-- Hero Section -->
    <section class="relative h-40 bg-cover bg-center" style="background-image: url('{{ asset('images/home-page.png') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative z-10 flex flex-col justify-center items-center h-full text-white">
            <h1 class="text-5xl font-bold">MUSIC FIESTA HUB</h1>
        </div>
    </section>

    <!-- Events Section -->
    <section class="p-6">
        <!-- Events Section -->
        <div class="bg-white p-6 rounded-lg shadow-md" style="background-color: #7f5783">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Events</h2>
            <!-- Categories Filter for Events -->
            <div class="mb-4">
                <div id="categories" class="flex flex-wrap gap-2">
                    <button type="button"
                            class="category-button inline-block px-3 py-1 text-sm font-semibold border rounded-full cursor-pointer selected"
                            data-category-id="all"
                            style="border-color: #333; color: #0c0606; background-color: #ffffff;">
                        All
                    </button>
                    @foreach ($categories as $category)
                        <button type="button"
                                class="category-button inline-block px-3 py-1 text-sm font-semibold border rounded-full cursor-pointer"
                                data-category-id="{{ $category->id }}"
                                style="border-color: #333; color: #ffffff;">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            </div>
            <!-- Events Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="attractions-grid">
                @foreach ($items as $item)
                    <a href="{{ route('item.details', $item->id) }}" class="block">
                        <div class="bg-white p-4 rounded-lg shadow-md">
                            @if ($item->thumbnail_image)
                                <img src="{{ asset($item->thumbnail_image) }}" alt="{{ $item->title }}" class="w-full h-32 object-cover mb-4 rounded">
                            @endif
                            <h3 class="text-lg font-bold mb-2" style="color: #0c0606">{{ $item->title }}</h3>
                            <p class="text-gray-700 text-sm mb-2">{{ Str::limit($item->small_description, 100) }}</p>
                            <p class="text-sm text-gray-500 mb-2">Location: {{ $item->location }}</p>
                            <p class="text-sm text-gray-500 mb-2">Category: {{ $item->categories->pluck('name')->join(', ') }}</p>
                                <p class="text-sm text-gray-500 mb-2">Date : {{ $item->date }}</p>
                        </div>
                    </a>
                @endforeach
            </div>


        </div>
    </section>





@endsection


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categoryButtons = document.querySelectorAll('.category-button');
        const eventCategoryButtons = document.querySelectorAll('.event-category-button');

        // Filter Items (Events)
        categoryButtons.forEach(button => {
            button.addEventListener('click', function () {
                categoryButtons.forEach(btn => {
                    btn.classList.remove('selected');
                    btn.style.backgroundColor = '';
                    btn.style.color = '#02152c';
                });

                this.classList.add('selected');
                this.style.backgroundColor = '#edf1f4';
                this.style.color = '#07090c';

                const categoryId = this.getAttribute('data-category-id');
                filterItems(categoryId);
            });
        });

        function filterItems(categoryId) {
            fetch(`/filter-items/${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    const grid = document.getElementById('attractions-grid');
                    grid.innerHTML = ''; // Clear current items

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
                })
                .catch(error => console.error('Error fetching items:', error));
        }




    });

</script>
