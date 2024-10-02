@extends('layouts.ct')

@section('content')
    <section class="p-6">
        <div class="bg-white p-6 rounded-lg shadow-md" style="background-color: #c1d3ef">
            <!-- Title and Average Rating -->
            <div class="flex justify-between text-black items-center mb-4">
                <h1 class="text-3xl text-black font-bold">{{ $item->title }}</h1>
                <p>
                    Average Rating:
                    @if ($item->reviews->count())
                        {{ round($item->reviews->avg('rating'), 1) }} Stars
                    @else
                        Not Rated Yet
                    @endif
                </p>
                @auth
                <a href="{{ route('book-event') }}" class="px-4 py-2 bg-blue-500 text-white rounded" style="background-color: darkblue;">Book Now</a>
                @else
                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-500 text-black rounded" >Login to Book</a>
                @endauth
            </div>

            <!-- Like Button -->
            <div class="mb-4">
                @auth
                    <form action="{{ route('items.like', $item->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">
                            @if($item->likes->where('user_id', Auth::id())->count())
                                Unlike
                            @else
                                Like
                            @endif
                        </button>
                    </form>
                @else
                    <p class="text-black">Please <a href="{{ route('login') }}" style="color: #4280bd">log in</a> to like this item.</p>
                @endauth
                <p>{{ $item->likes->count() }} Likes</p>
            </div>

            <!-- Location -->
            <p class="text-lg text-gray-600 mb-4"><strong>Location:</strong> {{ $item->location }}</p>

            <!-- Categories -->
            <div class="flex flex-wrap gap-2 mb-4">
                @foreach ($item->categories as $category)
                    <span class="inline-block px-3 py-1 text-sm font-semibold border rounded-full cursor-default"
                          style="border-color: #333; color: #333;">
                        {{ $category->name }}
                    </span>
                @endforeach
            </div>

            <!-- Link -->
            @if($item->link)
                <p class="text-lg text-blue-500 mb-4">
                    <strong>Link:</strong>
                    <a href="{{ $item->link }}" target="_blank">{{ $item->link }}</a>
                </p>
            @endif

            <!-- add date here -->
            <p class="text-lg text-gray-600 mb-4"><strong>Date:</strong> {{ $item->date }}</p>

            <!-- Large Description -->
            <div class="mb-6">
                <h2 class="text-xl text-black font-bold mb-2">Description</h2>
                <p class="text-gray-700">{{ $item->large_description }}</p>
            </div>

            <!-- Gallery Images -->
            <div class="grid grid-cols-4 gap-6">
                @if($item->gallery_image_1)
                    <div class="flex justify-center items-center bg-white p-4 rounded-lg shadow-md">
                        <img src="{{ asset('storage/' . $item->gallery_image_1) }}" alt="Gallery Image 1" class="h-64 object-cover rounded">
                    </div>
                @endif

                @if($item->gallery_image_2)
                    <div class="flex justify-center items-center bg-white p-4 rounded-lg shadow-md">
                        <img src="{{ asset('storage/' . $item->gallery_image_2) }}" alt="Gallery Image 2" class="h-64 object-cover rounded">
                    </div>
                @endif

                @if($item->gallery_image_3)
                    <div class="flex justify-center items-center bg-white p-4 rounded-lg shadow-md">
                        <img src="{{ asset('storage/' . $item->gallery_image_3) }}" alt="Gallery Image 3" class="h-64 object-cover rounded">
                    </div>
                @endif

                @if($item->gallery_image_4)
                    <div class="flex justify-center items-center bg-white p-4 rounded-lg shadow-md">
                        <img src="{{ asset('storage/' . $item->gallery_image_4) }}" alt="Gallery Image 4" class="h-64 object-cover rounded">
                    </div>
                @endif
            </div>

            <!-- Reviews & Ratings Section -->
            <section class="p-6 mt-8">
                <h2 class="text-3xl text-black font-bold mb-6">Reviews & Ratings</h2>

                <!-- Review Submission Form -->
                @auth
                    <form action="{{ route('reviews.store', $item->id) }}" method="POST">
                        @csrf
                        <!-- Rating Dropdown -->
                        <label for="rating" class="block text-black text-lg mb-2">Your Rating:</label>
                        <div class="rating flex items-center space-x-2">
                            <input type="radio" id="star1" name="rating" value="1" class="hidden" />
                            <label for="star1" class="text-2xl cursor-pointer" title="1 star">★</label>

                            <input type="radio" id="star2" name="rating" value="2" class="hidden" />
                            <label for="star2" class="text-2xl cursor-pointer" title="2 stars">★</label>

                            <input type="radio" id="star3" name="rating" value="3" class="hidden" />
                            <label for="star3" class="text-2xl cursor-pointer" title="3 stars">★</label>

                            <input type="radio" id="star4" name="rating" value="4" class="hidden" />
                            <label for="star4" class="text-2xl cursor-pointer" title="4 stars">★</label>

                            <input type="radio" id="star5" name="rating" value="5" class="hidden" />
                            <label for="star5" class="text-2xl cursor-pointer" title="5 stars">★</label>
                        </div>

                        <!-- Optional CSS for styling the star selection -->
                        <style>
                            .rating input:checked ~ label {
                                color: gray;
                            }

                            .rating label {
                                color: gold;
                            }

                            .rating input:focus ~ label {
                                outline: 2px solid blue;
                            }
                        </style>




                        <!-- Review Text Area (Optional) -->
                        <label for="review" class="block text-lg mb-2">Your Review (Optional):</label>
                        <textarea name="review" id="review" rows="4" class="block w-full text-black border rounded mb-4"></textarea>

                        <!-- Submit Button -->
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded" style="background-color: #020243;">Submit Review</button>
                    </form>
                @else
                    <p class="text-black">Please <a href="{{ route('login') }}" style="color: #4280bd" >log in</a> to submit a review.</p>
                @endauth
            </section>

            <!-- Display Existing Reviews -->
            <section class="p-6 mt-8">
                <h3 class="text-2xl text-black font-bold mb-4">User Reviews</h3>

                @forelse($item->reviews as $review)
                    <div class="mb-6 text-black p-4 border rounded-lg">
                        <div class="flex justify-between items-center">
                            <p class="text-sm text-gray-600">
                                {{ $review->user->username }} - Rated: {{ $review->rating }} Stars
                            </p>

                            @if (auth()->id() === $review->user_id)
                                <form action="{{ route('reviews.destroy', [$item->id, $review->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                        @if ($review->review)
                            <p class="mt-2">{{ $review->review }}</p>
                        @else
                            <p class="mt-2 text-gray-500">No written review provided.</p>
                        @endif
                    </div>
                @empty
                    <p>No reviews yet. Be the first to review!</p>
                @endforelse
            </section>

        </div>
    </section>
@endsection
