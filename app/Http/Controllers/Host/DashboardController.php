<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Models\Item;    // Import the Item model (Attractions)
use App\Models\Event;   // Import the Event model
use App\Models\Review;   // Import the Review model
use App\Models\User;   // Import the User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class DashboardController extends Controller
{
    public function index()
    {
        // Fetch the items  for the logged-in host
        $items = Item::where('host_id', auth()->id())->get();


        // Pass both items and events to the dashboard view
        return view('host.dashboard', compact('items'));  // This will reference the Blade view for the host dashboard
    }

    public function updateProfile(Request $request)
    {
        $host = auth()->guard('host')->user(); // Retrieve the logged-in host

        // Check which form was submitted based on the input names
        if ($request->has('profile_picture')) {
            // Validate and update profile picture
            $request->validate([
                'profile_picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($request->hasFile('profile_picture')) {
                $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');
                $host->profile_picture = $imagePath;
            }
        }

        if ($request->has('website_url')) {
            // Validate and update website URL
            $request->validate([
                'website_url' => 'nullable|url',
            ]);
            $host->website_url = $request->input('website_url');
        }

        if ($request->has('instagram_url') || $request->has('facebook_url')) {
            // Validate and update social media links
            $request->validate([
                'instagram_url' => 'nullable|url',
                'facebook_url' => 'nullable|url',
            ]);

            $host->instagram_url = $request->input('instagram_url');
            $host->facebook_url = $request->input('facebook_url');
        }

        if ($request->has('bio')) {
            // Validate and update bio
            $request->validate([
                'bio' => 'nullable|string|max:250',
            ]);
            $host->bio = $request->input('bio');
        }

        // Save updated host profile
        $host->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function statboard()
    {
        // Get the ID of the currently logged-in host
        $hostId = Auth::id();

        // Fetch total counts
        $totalAttractions = Item::where('host_id', auth()->id())->count();

        $totalReviews = 0; // Placeholder until reviews are implemented



        $totalReviews = Review::whereHas('item', function($query) use ($hostId) {
            $query->where('host_id', $hostId);
        })->count();

        // Fetch the average rating for all items
        $averageRating = Review::whereHas('item', function($query) use ($hostId) {
            $query->where('host_id', $hostId);
        })->avg('rating');

        // Fetch a breakdown of the number of reviews per rating (1 to 5 stars)
        $ratingBreakdown = Review::whereHas('item', function($query) use ($hostId) {
            $query->where('host_id', $hostId);
        })->select('rating', DB::raw('count(*) as count'))
            ->groupBy('rating')
            ->get();


        //fetch upcoming events for the calendar
        $upcomingItems = Item::where('host_id', $hostId)
            ->where('date', '>=', now())
            ->get(['title', 'date as start'])
            ->toArray();

        //calculate total likes
        $totalLikes = Item::where('host_id', $hostId)
            ->withCount('likes')
            ->get()
            ->sum('likes_count');
        // Fetch likes data for each item
        $likeData = Item::where('host_id', $hostId)
            ->withCount('likes')
            ->get(['title', 'likes_count']);

        // Fetch user count
        $totalUsers = User::count();

        // Fetch review data grouped by user
        $reviewData = Review::whereHas('item', function($query) use ($hostId) {
            $query->where('host_id', $hostId);
        })->select('user_id', DB::raw('count(*) as review_count'))
            ->groupBy('user_id')
            ->with('user:id,name')
            ->get();



        return view('host.statboard', compact('totalAttractions', 'totalReviews', 'averageRating', 'ratingBreakdown', 'upcomingItems','totalLikes','likeData','totalUsers','reviewData'));


    }

    // Method to display reviews
    public function reviews()
    {
        // Get the host user ID
        $hostId = Auth::id();

        // Fetch reviews for items the host created
        $reviews = Review::whereHas('item', function($query) use ($hostId) {
            $query->where('host_id', $hostId);
        })->with('item')->get();

        // get username from userid


        return view('host.reviews', compact('reviews'));
    }

}

