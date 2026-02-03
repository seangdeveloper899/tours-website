@extends('layouts.app')

@section('title', 'Manage Bookings')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-bold text-gray-800">
                <i class="fas fa-calendar-check"></i> Customer Bookings
            </h1>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Bookings Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-blue-50 rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-600 text-sm font-medium">Total Bookings</p>
                        <p class="text-3xl font-bold text-blue-900">{{ $bookings->total() }}</p>
                    </div>
                    <div class="text-4xl text-blue-500">
                        <i class="fas fa-list"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-yellow-50 rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-600 text-sm font-medium">Pending</p>
                        <p class="text-3xl font-bold text-yellow-900">{{ $bookings->where('status', 'pending')->count() }}</p>
                    </div>
                    <div class="text-4xl text-yellow-500">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-green-50 rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-600 text-sm font-medium">Confirmed</p>
                        <p class="text-3xl font-bold text-green-900">{{ $bookings->where('status', 'confirmed')->count() }}</p>
                    </div>
                    <div class="text-4xl text-green-500">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-purple-50 rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-600 text-sm font-medium">Completed</p>
                        <p class="text-3xl font-bold text-purple-900">{{ $bookings->where('status', 'completed')->count() }}</p>
                    </div>
                    <div class="text-4xl text-purple-500">
                        <i class="fas fa-flag-checkered"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bookings Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tour</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Participants</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guide</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $booking->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $booking->customer_name }}</div>
                                            <div class="text-sm text-gray-500">{{ $booking->customer_email }}</div>
                                            <div class="text-sm text-gray-500">{{ $booking->customer_phone }}</div>
                                        </div>
                                        @if($booking->user)
                                            <div class="ml-2" title="Registered User">
                                                <i class="fas fa-user-check text-green-500"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $booking->tour->title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $booking->booking_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                    {{ $booking->number_of_participants }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    ${{ number_format($booking->total_price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($booking->status === 'pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i> Pending
                                        </span>
                                    @elseif($booking->status === 'confirmed')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i> Confirmed
                                        </span>
                                    @elseif($booking->status === 'cancelled')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i> Cancelled
                                        </span>
                                    @elseif($booking->status === 'completed')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            <i class="fas fa-flag-checkered mr-1"></i> Completed
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($booking->payment_status === 'unpaid')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            <i class="fas fa-times mr-1"></i> Unpaid
                                        </span>
                                    @elseif($booking->payment_status === 'partial')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-adjust mr-1"></i> Partial
                                        </span>
                                    @elseif($booking->payment_status === 'paid')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i> Paid
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($booking->guide)
                                        <div class="text-sm text-gray-900">{{ $booking->guide->name }}</div>
                                    @else
                                        <span class="text-gray-400">Not assigned</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}" 
                                           class="text-blue-600 hover:text-blue-900" 
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.bookings.edit', $booking->id) }}" 
                                           class="text-indigo-600 hover:text-indigo-900" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this booking?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900" 
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-6 py-4 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-2"></i>
                                    <p>No bookings found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($bookings->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
