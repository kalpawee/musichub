<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-blue-950">
        <div class="w-full max-w-md p-8 bg-white rounded-[32px] shadow-md">
            <div class="flex justify-center">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-20 w-20">
                </a>
            </div>
            <h2 class="text-2xl font-bold text-center text-gray-900">Admin Sign In</h2>
            <form method="POST" action="{{ route('host.login') }}">
                @csrf

                <div class="space-y-4">
                    @if ($errors->any())
                        <div class="bg-red-500 text-white p-3 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <input id="email" name="email" type="email" placeholder="Email Address" required class="w-full px-3 py-2 border border-gray-300 rounded-[32px] focus:outline-none focus:ring-2 focus:ring-orange-400">
                    </div>
                    <div>
                        <input id="password" name="password" type="password" placeholder="Password" required class="w-full px-3 py-2 border border-gray-300 rounded-[32px] focus:outline-none focus:ring-2 focus:ring-orange-400">
                    </div>
                    <div>
                        <button type="submit" class="w-full px-4 py-2 font-semibold text-white rounded-[32px]" style="background-color: #054560;">Sign In</button>

                    </div>
                    <div class="mt-2 text-center">
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">User Sign In</a>
                    </div>
                </div>
            </form>



        </div>
    </div>
</x-guest-layout>
