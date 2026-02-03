<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\Tour;
use App\Models\Category;
use App\Models\Guide;
use App\Models\Booking;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            if (Auth::user()->is_admin) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Welcome back, ' . Auth::user()->name . '!');
            } else {
                Auth::logout();
                return back()->with('error', 'Access denied. Admin privileges required.');
            }
        }

        return back()->with('error', 'Invalid email or password.')->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('success', 'You have been logged out successfully.');
    }

    public function dashboard()
    {
        $settings = SiteSetting::all()->groupBy('group');
        return view('admin.dashboard', compact('settings'));
    }

    public function editBanner()
    {
        $bannerSettings = SiteSetting::where('group', 'banner')->get()->keyBy('key');
        return view('admin.banner', compact('bannerSettings'));
    }

    public function updateBanner(Request $request)
    {
        $request->validate([
            'banner_1_title' => 'required|string|max:255',
            'banner_1_subtitle' => 'required|string|max:500',
            'banner_1_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'banner_2_title' => 'required|string|max:255',
            'banner_2_subtitle' => 'required|string|max:500',
            'banner_2_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'banner_3_title' => 'required|string|max:255',
            'banner_3_subtitle' => 'required|string|max:500',
            'banner_3_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        SiteSetting::set('banner_1_title', $request->banner_1_title, 'text', 'banner', 'Banner 1 Title');
        SiteSetting::set('banner_1_subtitle', $request->banner_1_subtitle, 'textarea', 'banner', 'Banner 1 Subtitle');
        
        if ($request->hasFile('banner_1_image')) {
            $path = $request->file('banner_1_image')->store('banners', 'public');
            SiteSetting::set('banner_1_image', $path, 'image', 'banner', 'Banner 1 Image');
        }

        SiteSetting::set('banner_2_title', $request->banner_2_title, 'text', 'banner', 'Banner 2 Title');
        SiteSetting::set('banner_2_subtitle', $request->banner_2_subtitle, 'textarea', 'banner', 'Banner 2 Subtitle');
        
        if ($request->hasFile('banner_2_image')) {
            $path = $request->file('banner_2_image')->store('banners', 'public');
            SiteSetting::set('banner_2_image', $path, 'image', 'banner', 'Banner 2 Image');
        }
        SiteSetting::set('banner_3_title', $request->banner_3_title, 'text', 'banner', 'Banner 3 Title');
        SiteSetting::set('banner_3_subtitle', $request->banner_3_subtitle, 'textarea', 'banner', 'Banner 3 Subtitle');
        
        if ($request->hasFile('banner_3_image')) {
            $path = $request->file('banner_3_image')->store('banners', 'public');
            SiteSetting::set('banner_3_image', $path, 'image', 'banner', 'Banner 3 Image');
        }

        return redirect()->route('admin.banner')->with('success', 'Banner settings updated successfully!');
    }

    public function editContent()
    {
        $contentSettings = SiteSetting::where('group', 'content')->get()->keyBy('key');
        return view('admin.content', compact('contentSettings'));
    }

    public function updateContent(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_tagline' => 'required|string|max:500',
            'about_title' => 'required|string|max:255',
            'about_description' => 'required|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:50',
            'contact_address' => 'required|string|max:255',
        ]);

        SiteSetting::set('site_name', $request->site_name, 'text', 'content', 'Site Name');
        SiteSetting::set('site_tagline', $request->site_tagline, 'text', 'content', 'Site Tagline');
        SiteSetting::set('about_title', $request->about_title, 'text', 'content', 'About Section Title');
        SiteSetting::set('about_description', $request->about_description, 'textarea', 'content', 'About Description');
        SiteSetting::set('contact_email', $request->contact_email, 'text', 'content', 'Contact Email');
        SiteSetting::set('contact_phone', $request->contact_phone, 'text', 'content', 'Contact Phone');
        SiteSetting::set('contact_address', $request->contact_address, 'text', 'content', 'Contact Address');

        return redirect()->route('admin.content')->with('success', 'Content settings updated successfully!');
    }

    public function editToursBanner()
    {
        $toursSettings = SiteSetting::where('group', 'tours')->get()->keyBy('key');
        return view('admin.tours-banner', compact('toursSettings'));
    }

    public function updateToursBanner(Request $request)
    {
        $request->validate([
            'tours_banner_title' => 'required|string|max:255',
            'tours_banner_subtitle' => 'required|string|max:500',
            'tours_banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        SiteSetting::set('tours_banner_title', $request->tours_banner_title, 'text', 'tours', 'Tours Page Banner Title');
        SiteSetting::set('tours_banner_subtitle', $request->tours_banner_subtitle, 'textarea', 'tours', 'Tours Page Banner Subtitle');
        
        if ($request->hasFile('tours_banner_image')) {
            $path = $request->file('tours_banner_image')->store('banners', 'public');
            SiteSetting::set('tours_banner_image', $path, 'image', 'tours', 'Tours Page Banner Background Image');
        }

        return redirect()->route('admin.tours.banner')->with('success', 'Tours banner updated successfully!');
    }

    public function settings()
    {
        $settings = SiteSetting::all()->groupBy('group');
        return view('admin.settings', compact('settings'));
    }

    public function updateSetting(Request $request, $id)
    {
        $setting = SiteSetting::findOrFail($id);
        
        $request->validate([
            'value' => 'required',
        ]);

        if ($setting->type === 'image' && $request->hasFile('value')) {
            $path = $request->file('value')->store('settings', 'public');
            $setting->value = $path;
        } else {
            $setting->value = $request->value;
        }
        
        $setting->save();

        return redirect()->back()->with('success', 'Setting updated successfully!');
    }

    public function tours()
    {
        $tours = Tour::with('category')->latest()->paginate(20);
        return view('admin.tours.index', compact('tours'));
    }

    public function createTour()
    {
        $categories = Category::all();
        return view('admin.tours.create', compact('categories'));
    }

    public function storeTour(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'max_people' => 'required|integer|min:1',
            'difficulty_level' => 'required|in:easy,moderate,challenging,difficult',
            'featured_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'itinerary' => 'nullable|string',
            'included_items' => 'nullable|string',
            'excluded_items' => 'nullable|string',
            'meeting_point' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'duration_days' => $request->duration_days,
            'max_people' => $request->max_people,
            'difficulty_level' => $request->difficulty_level,
            'itinerary' => $request->itinerary,
            'meeting_point' => $request->meeting_point,
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->filled('included_items')) {
            $data['included_items'] = array_filter(array_map('trim', explode("\n", $request->included_items)));
        }

        if ($request->filled('excluded_items')) {
            $data['excluded_items'] = array_filter(array_map('trim', explode("\n", $request->excluded_items)));
        }

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('tours', 'public');
        }

        Tour::create($data);

        return redirect()->route('admin.tours')->with('success', 'Tour created successfully!');
    }

    public function editTour($id)
    {
        $tour = Tour::findOrFail($id);
        $categories = Category::all();
        return view('admin.tours.edit', compact('tour', 'categories'));
    }

    public function updateTour(Request $request, $id)
    {
        $tour = Tour::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'max_people' => 'required|integer|min:1',
            'difficulty_level' => 'required|in:easy,moderate,challenging,difficult',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'itinerary' => 'nullable|string',
            'included_items' => 'nullable|string',
            'excluded_items' => 'nullable|string',
            'meeting_point' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'duration_days' => $request->duration_days,
            'max_people' => $request->max_people,
            'difficulty_level' => $request->difficulty_level,
            'itinerary' => $request->itinerary,
            'meeting_point' => $request->meeting_point,
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->filled('included_items')) {
            $data['included_items'] = array_filter(array_map('trim', explode("\n", $request->included_items)));
        }

        if ($request->filled('excluded_items')) {
            $data['excluded_items'] = array_filter(array_map('trim', explode("\n", $request->excluded_items)));
        }

        if ($request->hasFile('featured_image')) {
            if ($tour->featured_image) {
                Storage::disk('public')->delete($tour->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('tours', 'public');
        }

        $tour->update($data);

        return redirect()->route('admin.tours')->with('success', 'Tour updated successfully!');
    }

    public function destroyTour($id)
    {
        $tour = Tour::findOrFail($id);
        
        if ($tour->featured_image) {
            Storage::disk('public')->delete($tour->featured_image);
        }
        
        $tour->delete();

        return redirect()->route('admin.tours')->with('success', 'Tour deleted successfully!');
    }

    public function bookings()
    {
        $bookings = Booking::with(['tour', 'guide', 'user'])
            ->latest()
            ->paginate(20);
        
        return view('admin.bookings.index', compact('bookings'));
    }

    public function showBooking($id)
    {
        $booking = Booking::with(['tour', 'guide', 'user', 'transactions'])->findOrFail($id);
        $transactionHistory = $this->transactionService->getTransactionHistory($booking);
        
        return view('admin.bookings.show', compact('booking', 'transactionHistory'));
    }

    public function editBooking($id)
    {
        $booking = Booking::with(['tour', 'user'])->findOrFail($id);
        $guides = Guide::where('is_available', true)->get();
        return view('admin.bookings.edit', compact('booking', 'guides'));
    }

    public function updateBooking(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'payment_status' => 'required|in:unpaid,paid,refunded',
            'guide_id' => 'nullable|exists:guides,id',
        ]);

        $booking->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
            'guide_id' => $request->guide_id,
        ]);

        return redirect()->route('admin.bookings.show', $id)
            ->with('success', 'Booking updated successfully!');
    }

    public function updateBookingStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $booking->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Booking status updated successfully!');
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'payment_status' => 'required|in:unpaid,partial,paid',
        ]);

        $booking->update(['payment_status' => $request->payment_status]);

        return redirect()->back()->with('success', 'Payment status updated successfully!');
    }

    public function assignGuide(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'guide_id' => 'required|exists:guides,id',
        ]);

        $booking->update(['guide_id' => $request->guide_id]);

        return redirect()->back()->with('success', 'Guide assigned successfully!');
    }

    public function destroyBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.bookings')->with('success', 'Booking deleted successfully!');
    }

    public function processRefund(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . $booking->total_paid,
            'reason' => 'nullable|string|max:500',
        ]);

        $result = $this->transactionService->processRefund(
            $booking,
            $request->amount,
            $request->reason
        );

        if ($result['success']) {
            return redirect()->route('admin.bookings.show', $id)
                ->with('success', $result['message']);
        } else {
            return back()
                ->withErrors(['refund' => $result['message']])
                ->withInput();
        }
    }

    public function transactionHistory($id)
    {
        $booking = Booking::with(['tour', 'user', 'transactions'])->findOrFail($id);
        $transactionHistory = $this->transactionService->getTransactionHistory($booking);
        
        return view('admin.bookings.transactions', compact('booking', 'transactionHistory'));
    }
}
