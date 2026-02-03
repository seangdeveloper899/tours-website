<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Amazing tours with licensed guides - Book your adventure today')">
    <meta name="keywords" content="tours, travel, adventure, guided tours, vacation">
    <title>@yield('title', 'Tours Website - Amazing Tours with Licensed Guides')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
        
        body { font-family: 'Poppins', sans-serif; }
        html { scroll-behavior: smooth; }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out; }
        .float-animation { animation: float 3s ease-in-out infinite; }
        
        .gradient-text {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #10b981; border-radius: 5px; }
        ::-webkit-scrollbar-thumb:hover { background: #059669; }
        
        [x-cloak] { display: none !important; }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50" x-data="{ mobileMenuOpen: false, scrolled: false, showScrollTop: false }" 
      x-init="window.addEventListener('scroll', () => { scrolled = window.pageYOffset > 50; showScrollTop = window.pageYOffset > 300; })">
    
    <div class="bg-gradient-to-r from-green-600 to-emerald-700 text-white py-2">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-between items-center text-sm">
                <div class="flex items-center gap-4">
                    <a href="tel:+85567567890" class="hover:text-yellow-300 transition">
                        <i class="fas fa-phone"></i> +855 67 567 890
                    </a>
                    <a href="mailto:info@tours-website.com" class="hover:text-yellow-300 transition hidden md:inline">
                        <i class="fas fa-envelope"></i> info@tours-website.com
                    </a>
                </div>
                <div class="flex items-center gap-3">
                    <span class="hidden md:inline">Follow us:</span>
                    <a href="#" class="hover:text-yellow-300 transition"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="hover:text-yellow-300 transition"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="hover:text-yellow-300 transition"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </div>

    <nav class="sticky top-0 z-50 bg-white shadow-md transition-all duration-300" :class="{ 'shadow-lg': scrolled }">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-600 to-emerald-700 rounded-lg flex items-center justify-center transform group-hover:rotate-6 transition">
                        <i class="fas fa-map-marked-alt text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold gradient-text">Tours Website</h1>
                        <p class="text-xs text-gray-500">Amazing Adventures</p>
                    </div>
                </a>

                <div class="hidden lg:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-green-600 font-medium transition {{ request()->routeIs('home') ? 'text-green-600' : '' }}">Home</a>
                    <a href="{{ route('tours.index') }}" class="text-gray-700 hover:text-green-600 font-medium transition {{ request()->routeIs('tours.*') ? 'text-green-600' : '' }}">Tours</a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-green-600 font-medium transition {{ request()->routeIs('contact') ? 'text-green-600' : '' }}">Contact</a>
                    
                    @auth
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-green-600 font-medium transition {{ request()->routeIs('admin.*') && !request()->routeIs('admin.login') ? 'text-green-600' : '' }}">
                                <i class="fas fa-cog"></i> Admin
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-green-600 font-medium transition {{ request()->routeIs('dashboard') ? 'text-green-600' : '' }}">
                                <i class="fas fa-user"></i> Dashboard
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-red-600 font-medium transition">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-green-600 font-medium transition {{ request()->routeIs('login') ? 'text-green-600' : '' }}">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-green-600 to-emerald-700 text-white px-6 py-2 rounded-full font-semibold hover:shadow-lg transform hover:scale-105 transition">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                    @endauth
                    
                    <a href="{{ route('tours.index') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-2 rounded-full font-semibold hover:shadow-lg transform hover:scale-105 transition">
                        <i class="fas fa-search"></i> Book Now
                    </a>
                </div>

                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden text-gray-700">
                    <i class="fas fa-bars text-2xl" x-show="!mobileMenuOpen"></i>
                    <i class="fas fa-times text-2xl" x-show="mobileMenuOpen" x-cloak></i>
                </button>
            </div>

            <div x-show="mobileMenuOpen" x-transition class="lg:hidden pb-4" x-cloak>
                <div class="flex flex-col gap-3">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:bg-gray-100 px-4 py-2 rounded"><i class="fas fa-home w-6"></i> Home</a>
                    <a href="{{ route('tours.index') }}" class="text-gray-700 hover:bg-gray-100 px-4 py-2 rounded"><i class="fas fa-map-marked-alt w-6"></i> Tours</a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:bg-gray-100 px-4 py-2 rounded"><i class="fas fa-envelope w-6"></i> Contact</a>
                    @auth
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:bg-gray-100 px-4 py-2 rounded"><i class="fas fa-cog w-6"></i> Admin</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:bg-gray-100 px-4 py-2 rounded"><i class="fas fa-user w-6"></i> Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left text-gray-700 hover:bg-gray-100 px-4 py-2 rounded"><i class="fas fa-sign-out-alt w-6"></i> Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:bg-gray-100 px-4 py-2 rounded"><i class="fas fa-sign-in-alt w-6"></i> Login</a>
                        <a href="{{ route('register') }}" class="text-gray-700 hover:bg-gray-100 px-4 py-2 rounded"><i class="fas fa-user-plus w-6"></i> Register</a>
                    @endauth
                    <a href="{{ route('tours.index') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-2 rounded-lg font-semibold text-center">Book Now</a>
                </div>
            </div>
        </div>
    </nav>

    @if(session('success'))
    <div class="container mx-auto px-4 mt-4" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md flex justify-between animate-fadeInUp">
            <div class="flex items-center gap-3">
                <i class="fas fa-check-circle text-2xl"></i>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
            <button @click="show = false"><i class="fas fa-times"></i></button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="container mx-auto px-4 mt-4" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md flex justify-between animate-fadeInUp">
            <div class="flex items-center gap-3">
                <i class="fas fa-exclamation-circle text-2xl"></i>
                <p class="font-medium">{{ session('error') }}</p>
            </div>
            <button @click="show = false"><i class="fas fa-times"></i></button>
        </div>
    </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-white mt-20">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4 gradient-text">Tours Website</h3>
                    <p class="text-gray-400 mb-4">Discover amazing tours with licensed guides.</p>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-green-600 transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-green-600 transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-green-600 transition"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-green-400 transition">Home</a></li>
                        <li><a href="{{ route('tours.index') }}" class="text-gray-400 hover:text-green-400 transition">All Tours</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-green-400 transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Categories</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('tours.index', ['category' => 'angkor-tours']) }}" class="text-gray-400 hover:text-green-400 transition">Angkor Tours</a></li>
                        <li><a href="{{ route('tours.index', ['category' => 'boat-tours']) }}" class="text-gray-400 hover:text-green-400 transition">Boat Tours</a></li>
                        <li><a href="{{ route('tours.index', ['category' => 'jungle-tours']) }}" class="text-gray-400 hover:text-green-400 transition">Jungle Tours</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Contact</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><i class="fas fa-map-marker-alt text-green-500"></i> 123 Main St, Siemrap city</li>
                        <li><i class="fas fa-phone text-green-500"></i> +855 67 567 890</li>
                        <li><i class="fas fa-envelope text-green-500"></i> info@tours-website.com</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Tours Website. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })" x-show="showScrollTop" x-transition
            class="fixed bottom-8 right-8 w-12 h-12 bg-gradient-to-r from-green-600 to-emerald-700 text-white rounded-full shadow-lg hover:shadow-xl transform hover:scale-110 transition z-50" x-cloak>
        <i class="fas fa-arrow-up"></i>
    </button>

    <a href="https://wa.me/1234567890" target="_blank" class="fixed bottom-24 right-8 w-14 h-14 bg-green-500 text-white rounded-full shadow-lg flex items-center justify-center float-animation z-50">
        <i class="fab fa-whatsapp text-3xl"></i>
    </a>

    @stack('scripts')
</body>
</html>
