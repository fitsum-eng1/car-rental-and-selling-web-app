@extends('layouts.app')

@section('title', 'Buy a Car - Car Rental & Sales System')

@section('content')
<div class="bg-white">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 to-green-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl md:text-4xl font-bold text-center animate__animated animate__fadeInUp">
                @if(app()->getLocale() === 'am')
                    መኪና ይግዙ
                @else
                    Buy a Car
                @endif
            </h1>
            <p class="text-xl text-green-100 text-center mt-4 animate__animated animate__fadeInUp animate__delay-1s">
                @if(app()->getLocale() === 'am')
                    ምርጥ ተሽከርካሪዎችን በተመጣጣኝ ዋጋ ይግዙ
                @else
                    Find your perfect vehicle at the best price
                @endif
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filters -->
        <div class="bg-gray-50 rounded-lg p-6 mb-8 animate-slide-in-down">
            <form method="GET" action="{{ route('vehicles.sales') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                <!-- Make Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        @if(app()->getLocale() === 'am')
                            ብራንድ
                        @else
                            Make
                        @endif
                    </label>
                    <select name="make" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
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
                    <select name="category" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
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

                <!-- Year Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        @if(app()->getLocale() === 'am')
                            ከ ዓመት
                        @else
                            Year From
                        @endif
                    </label>
                    <select name="year_from" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        <option value="">
                            @if(app()->getLocale() === 'am')
                                ማንኛውም
                            @else
                                Any
                            @endif
                        </option>
                        @foreach($years as $year)
                            <option value="{{ $year }}" {{ request('year_from') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        @if(app()->getLocale() === 'am')
                            እስከ ዓመት
                        @else
                            Year To
                        @endif
                    </label>
                    <select name="year_to" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        <option value="">
                            @if(app()->getLocale() === 'am')
                                ማንኛውም
                            @else
                                Any
                            @endif
                        </option>
                        @foreach($years as $year)
                            <option value="{{ $year }}" {{ request('year_to') == $year ? 'selected' : '' }}>
                                {{ $year }}
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
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
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
                           placeholder="100000" min="0"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>
            </form>

            <div class="mt-4 flex gap-4">
                <button type="submit" form="filter-form" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition duration-300 animate-ripple">
                    @if(app()->getLocale() === 'am')
                        ፈልግ
                    @else
                        Search
                    @endif
                </button>
                <button type="button" onclick="clearFilters()" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition duration-300 animate-button-hover">
                    @if(app()->getLocale() === 'am')
                        አጽዳ
                    @else
                        Clear Filters
                    @endif
                </button>
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
                <select onchange="updateSort(this.value)" class="rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
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
                    <option value="year-desc" {{ request('sort') === 'year' && request('order') === 'desc' ? 'selected' : '' }}>
                        @if(app()->getLocale() === 'am')
                            ዓመት: አዲስ ወደ ድሮ
                        @else
                            Year: Newest to Oldest
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
                                <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                                    @if(app()->getLocale() === 'am')
                                        ለሽያጭ
                                    @else
                                        For Sale
                                    @endif
                                </span>
                            </div>

                            <!-- Condition Badge -->
                            <div class="absolute top-2 left-2">
                                <span class="bg-blue-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                                    {{ ucfirst($vehicle->condition) }}
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $vehicle->year }} • {{ number_format($vehicle->mileage) }} km
                                </div>
                                
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
                                    {{ ucfirst($vehicle->fuel_type) }} • {{ $vehicle->color }}
                                </div>

                                <!-- Features -->
                                @if($vehicle->features && count($vehicle->features) > 0)
                                    <div class="flex flex-wrap gap-1 mt-2">
                                        @foreach(array_slice($vehicle->features, 0, 3) as $feature)
                                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs">
                                                {{ $feature }}
                                            </span>
                                        @endforeach
                                        @if(count($vehicle->features) > 3)
                                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs">
                                                +{{ count($vehicle->features) - 3 }} more
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Pricing -->
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-2xl font-bold text-green-600">${{ number_format($vehicle->sale_price) }}</span>
                                    <div class="text-sm text-gray-500">
                                        @if(app()->getLocale() === 'am')
                                            ታክስ ጨምሮ
                                        @else
                                            Tax included
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <a href="{{ route('vehicles.show', $vehicle) }}" 
                                       class="block bg-gray-100 text-gray-700 px-4 py-2 rounded text-center hover:bg-gray-200 transition duration-300 text-sm">
                                        @if(app()->getLocale() === 'am')
                                            ዝርዝር
                                        @else
                                            View Details
                                        @endif
                                    </a>
                                    @auth
                                        <a href="{{ route('checkout.stage1', $vehicle) }}" 
                                           class="w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-300 text-sm text-center block">
                                            @if(app()->getLocale() === 'am')
                                                ይግዙ
                                            @else
                                                Buy Now
                                            @endif
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" 
                                           class="block bg-green-600 text-white px-4 py-2 rounded text-center hover:bg-green-700 transition duration-300 text-sm">
                                            @if(app()->getLocale() === 'am')
                                                ይግዙ
                                            @else
                                                Buy Now
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
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    <button onclick="clearFilters()" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition duration-300">
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
    window.location.href = '{{ route("vehicles.sales") }}';
}

// Add form ID to the form for the search button
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[method="GET"]');
    if (form) {
        form.id = 'filter-form';
    }
});
</script>
@endsection