<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-blue-950 from-blue-900 via-blue-800 to-blue-950">
        <div class="w-full max-w-md p-8 bg-white rounded-2xl shadow-lg">
            <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-6">Select Categories</h2>
            <form method="POST" action="{{ route('categories.store') }}">
                @csrf
                <div class="space-y-4">
                    @foreach($categories as $category)
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" id="category_{{ $category->id }}" name="categories[]" value="{{ $category->id }}" class="rounded text-indigo-600 focus:ring-2 focus:ring-indigo-400">
                            <label for="category_{{ $category->id }}" class="text-gray-700 font-medium">{{ $category->name }}</label>
                        </div>
                    @endforeach
                    <div class="mt-6">
                        <button type="submit" class="w-full px-4 py-3 font-semibold text-white rounded-full bg-indigo-600 hover:bg-indigo-700 transition duration-200 ease-in-out shadow-md transform hover:scale-105">
                            Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

<style>
    /* Enhances overall look */
    body {
        font-family: 'Inter', sans-serif;
    }

    /* General styling for container */

