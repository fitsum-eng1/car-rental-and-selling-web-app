@extends('layouts.app')

@section('title', 'Rent a Car - Car Rental & Sales System')

@section('content')
<div class="bg-white">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl md:text-4xl font-bold text-center animate__animated animate__fadeInUp">
                @if(app()->getLocale() === 'am')
                    መኪና ይከራዩ
                @else
                    Rent a Car
                @endif
            </h1>
            <p class="text-xl text-blue-100 text-center mt-4 animate__animated animate__fadeInUp animate__delay-1s">
                @if(app()->getLocale() === 'am')
                    ምርጥ ተሽከርካሪዎችን በተመጣጣኝ ዋጋ ይከራዩ
                @else
                    Choose from our premium fleet of vehicles
                @endif
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filters -->
        <div class="bg-gray-50 rounded-lg p-6 mb-8 animate-slide-in-down">
            <form method="GET" action="{{ route('vehicles.rentals') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Make Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        @if(app()->getLocale() === 'am')
                            ብራንድ
                        @else
                            Make
                        @endif
                    </label>
                    <select name="make" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">
                            @if(app()->getLocale() === 'am')
                                ሁሉም ብራንዶች
                            @else
                                All Makes
                            @endif
                        </option>
                        @foreach($makes as $make)
                            <option value="{{ $make }}" {{ request('make') === $make ? 'selected' : '' }}>
                                {{ $make }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Category Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        @if(app()->getLocale() === 'am')
                            ምድብ
                        @else
                            Category
                        @endif
                    </label>
                    <select name="category" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">
                            @if(app()->getLocale() === 'am')
                                ሁሉም ምድቦች
                            @else
                                All Categories
                            @endif
                        </option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                                {{ ucfirst($category) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Price Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        @if(app()->getLocale() === 'am')
                            ዝቅተኛ ዋጋ
                        @else
                            Min Price
                        @endif
                    </label>
                    <input type="number" name="min_price" value="{{ request('min_price') }}" 
                           placeholder="0" min="0"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        @if(app()->getLocale() === 'am')
                            ከፍተኛ ዋጋ
                        @else
                            Max Price
                        @endif
                    </label>
                    <input type="number" name="max_price" value="{{ request('max_price') }}" 
                           placeholder="1000" min="0"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Search Button -->
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300 animate-ripple">
                        @if(app()->getLocale() === 'am')
                            ፈልግ
                        @else
                            Search
                        @endif
                    </button>
                </div>
            </form>

            <!-- Date Filter -->
            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        @if(app()->getLocale() === 'am')
                            የመውሰጃ ቀን
                        @else
                            Pickup Date
                        @endif
                    </label>
                    <input type="date" name="pickup_date" value="{{ request('pickup_date') }}" 
                           min="{{ date('Y-m-d') }}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        @if(app()->getLocale() === 'am')
                            የመመለሻ ቀን
                        @else
                            Return Date
                        @endif
                    </label>
                    <input type="date" name="return_date" value="{{ request('return_date') }}" 
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div class="flex items-end">
                    <button type="button" onclick="clearFilters()" class="w-full bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-300">
                        @if(app()->getLocale() === 'am')
                            አጽዳ
                        @else
                            Clear Filters
                        @endif
                    </button>
                </div>
            </div>
        </div>

        <!-- Sort Options -->
        <div class="flex justify-between items-center mb-6">
            <p class="text-gray-600">
                @if(app()->getLocale() === 'am')
                    {{ $vehicles->total() }} ተሽከርካሪዎች ተገኝተዋል
                @else
                    {{ $vehicles->total() }} vehicles found
                @endif
            </p>
            <div class="flex items-center space-x-4">
                <label class="text-sm font-medium text-gray-700">
                    @if(app()->getLocale() === 'am')
                        ደርድር በ:
                    @else
                        Sort by:
                    @endif
                </label>
                <select onchange="updateSort(this.value)" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="created_at-desc" {{ request('sort') === 'created_at' && request('order') === 'desc' ? 'selected' : '' }}>
                        @if(app()->getLocale() === 'am')
                            አዲስ
                        @else
                            Newest
                        @endif
                    </option>
                    <option value="price-asc" {{ request('sort') === 'price' && request('order') === 'asc' ? 'selected' : '' }}>
                        @if(app()->getLocale() === 'am')
                            ዋጋ: ዝቅተኛ ወደ ከፍተኛ
                        @else
                            Price: Low to High
                        @endif
                    </option>
                    <option value="price-desc" {{ request('sort') === 'price' && request('order') === 'desc' ? 'selected' : '' }}>
                        @if(app()->getLocale() === 'am')
                            ዋጋ: ከፍተኛ ወደ ዝቅተኛ
                        @else
                            Price: High to Low
                        @endif
                    </option>
                </select>
            </div>
        </div>

        <!-- Vehicle Grid -->
        @if($vehicles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="vehicle-grid">
                @foreach($vehicles as $index => $vehicle)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300 animate-card-entrance" 
                         style="animation-delay: {{ $index * 100 }}ms"
                         data-aos="fade-up"
                         data-aos-delay="{{ $index * 100 }}">
                        <!-- Vehicle Image -->
                        <div class="h-48 bg-gray-200 relative overflow-hidden">
                            @if($vehicle->primary_image)
                                <img src="{{ asset('storage/' . $vehicle->primary_image) }}" 
                                     alt="{{ $vehicle->full_name }}" 
                                     class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Status Badge -->
                            <div class="absolute top-2 right-2">
                                <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-medium animate-pulse-subtle">
                                    @if(app()->getLocale() === 'am')
                                        ይገኛል
                                    @else
                                        Available
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Vehicle Info -->
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $vehicle->full_name }}</h3>
                            
                            <!-- Vehicle Details -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    {{ ucfirst($vehicle->category) }} • {{ ucfirst($vehicle->transmission) }}
                                </div>
                                
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                                    </svg>
                                    {{ ucfirst($vehicle->fuel_type) }}
                                </div>

                                <!-- Driving Options -->
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @if($vehicle->self_drive_available)
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">
                                            @if(app()->getLocale() === 'am')
                                                ራስዎ ይንዱ
                                            @else
                                                Self Drive
                                            @endif
                                        </span>
                                    @endif
                                    @if($vehicle->with_driver_available)
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">
                                            @if(app()->getLocale() === 'am')
                                                ከሹፌር ጋር
                                            @else
                                                With Driver
                                            @endif
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Pricing -->
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-2xl font-bold text-blue-600">${{ $vehicle->rental_price_per_day }}</span>
                                    <span class="text-gray-500 text-sm">/
                                        @if(app()->getLocale() === 'am')
                                            ቀን
                                        @else
                                            day
                                        @endif
                                    </span>
                                    @if($vehicle->with_driver_available && $vehicle->driver_cost_per_day)
                                        <div class="text-sm text-gray-600">
                                            +${{ $vehicle->driver_cost_per_day }}/day 
                                            @if(app()->getLocale() === 'am')
                                                ለሹፌር
                                            @else
                                                for driver
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="space-y-2">
                                    <a href="{{ route('vehicles.show', $vehicle) }}" 
                                       class="block bg-gray-100 text-gray-700 px-4 py-2 rounded text-center hover:bg-gray-200 transition duration-300 text-sm animate-button-hover">
                                        @if(app()->getLocale() === 'am')
                                            ዝርዝር
                                        @else
                                            View Details
                                        @endif
                                    </a>
                                    @auth
                                        <a href="{{ route('bookings.create', $vehicle) }}" 
                                           class="block bg-blue-600 text-white px-4 py-2 rounded text-center hover:bg-blue-700 transition duration-300 text-sm animate-ripple">
                                            @if(app()->getLocale() === 'am')
                                                ይከራዩ
                                            @else
                                                Rent Now
                                            @endif
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" 
                                           class="block bg-blue-600 text-white px-4 py-2 rounded text-center hover:bg-blue-700 transition duration-300 text-sm animate-ripple">
                                            @if(app()->getLocale() === 'am')
                                                ይከራዩ
                                            @else
                                                Rent Now
                                            @endif
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $vehicles->appends(request()->query())->links() }}
            </div>
        @else
            <!-- No Results -->
            <div class="text-center py-12 animate__animated animate__fadeIn">
                <svg class="mx-auto h-12 w-12 text-gray-400 animate-float" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">
                    @if(app()->getLocale() === 'am')
                        ምንም ተሽከርካሪ አልተገኘም
                    @else
                        No vehicles found
                    @endif
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if(app()->getLocale() === 'am')
                        የፍለጋ መስፈርቶችዎን ይለውጡ እና እንደገና ይሞክሩ።
                    @else
                        Try adjusting your search criteria and try again.
                    @endif
                </p>
                <div class="mt-6">
                    <button onclick="clearFilters()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300 animate-ripple">
                        @if(app()->getLocale() === 'am')
                            ሁሉንም ተሽከርካሪዎች አሳይ
                        @else
                            Show All Vehicles
                        @endif
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function updateSort(value) {
    const [sort, order] = value.split('-');
    const url = new URL(window.location);
    url.searchParams.set('sort', sort);
    url.searchParams.set('order', order);
    window.location.href = url.toString();
}

function clearFilters() {
    window.location.href = '{{ route("vehicles.rentals") }}';
}

// Update return date when pickup date changes
document.querySelector('input[name="pickup_date"]').addEventListener('change', function() {
    const pickupDate = new Date(this.value);
    const returnDateInput = document.querySelector('input[name="return_date"]');
    const minReturnDate = new Date(pickupDate);
    minReturnDate.setDate(minReturnDate.getDate() + 1);
    returnDateInput.min = minReturnDate.toISOString().split('T')[0];
    
    if (returnDateInput.value && new Date(returnDateInput.value) <= pickupDate) {
        returnDateInput.value = minReturnDate.toISOString().split('T')[0];
    }
});
</script>
@endsection