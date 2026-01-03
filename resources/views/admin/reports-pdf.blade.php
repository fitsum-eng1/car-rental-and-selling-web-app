<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental & Sales Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
            line-height: 1.6;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #2563eb;
            margin: 0;
            font-size: 28px;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
        }
        
        .section {
            margin-bottom: 30px;
        }
        
        .section h2 {
            color: #1f2937;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            background-color: #f9fafb;
        }
        
        .stat-card h3 {
            margin: 0 0 15px 0;
            color: #374151;
            font-size: 16px;
        }
        
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #6b7280;
            font-size: 14px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            border: 1px solid #e5e7eb;
            padding: 12px;
            text-align: left;
        }
        
        th {
            background-color: #f3f4f6;
            font-weight: bold;
            color: #374151;
        }
        
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .revenue-section {
            background-color: #ecfdf5;
            border: 1px solid #d1fae5;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .revenue-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 10px;
            background-color: white;
            border-radius: 4px;
        }
        
        .revenue-total {
            font-weight: bold;
            font-size: 18px;
            border-top: 2px solid #10b981;
            padding-top: 10px;
            margin-top: 10px;
        }
        
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .metric-item {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 15px;
            text-align: center;
        }
        
        .metric-value {
            font-size: 20px;
            font-weight: bold;
            color: #2563eb;
        }
        
        .metric-label {
            color: #64748b;
            font-size: 12px;
            margin-top: 5px;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 12px;
        }
        
        @media print {
            body {
                margin: 0;
            }
            
            .section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Car Rental & Sales Report</h1>
        <p><strong>Report Period:</strong> {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}</p>
        <p><strong>Generated:</strong> {{ now()->format('M d, Y \a\t g:i A') }}</p>
        <p><strong>Period Type:</strong> {{ ucfirst(str_replace('_', ' ', $dateRange)) }}</p>
    </div>

    <!-- Summary Statistics -->
    <div class="section">
        <h2>Summary Statistics</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Bookings</h3>
                <div class="stat-value">{{ number_format($reports['bookings']['total']) }}</div>
                <div class="stat-label">Total Bookings</div>
                <div style="margin-top: 10px;">
                    <div>Completed: {{ number_format($reports['bookings']['completed']) }}</div>
                    <div>Revenue: ${{ number_format($reports['bookings']['revenue'], 2) }}</div>
                </div>
            </div>
            
            <div class="stat-card">
                <h3>Purchases</h3>
                <div class="stat-value">{{ number_format($reports['purchases']['total']) }}</div>
                <div class="stat-label">Total Purchases</div>
                <div style="margin-top: 10px;">
                    <div>Completed: {{ number_format($reports['purchases']['completed']) }}</div>
                    <div>Revenue: ${{ number_format($reports['purchases']['revenue'], 2) }}</div>
                </div>
            </div>
            
            <div class="stat-card">
                <h3>Users</h3>
                <div class="stat-value">{{ number_format($reports['users']['new_registrations']) }}</div>
                <div class="stat-label">New Registrations</div>
                <div style="margin-top: 10px;">
                    <div>Active Users: {{ number_format($reports['users']['active_users']) }}</div>
                </div>
            </div>
            
            <div class="stat-card">
                <h3>Vehicles</h3>
                <div class="stat-value">{{ number_format($reports['vehicles']['total']) }}</div>
                <div class="stat-label">Total Vehicles</div>
                <div style="margin-top: 10px;">
                    <div>For Rent: {{ number_format($reports['vehicles']['available_for_rent']) }}</div>
                    <div>For Sale: {{ number_format($reports['vehicles']['available_for_sale']) }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Breakdown -->
    <div class="section">
        <h2>Revenue Breakdown</h2>
        <div class="revenue-section">
            <div class="revenue-item">
                <span>Rental Revenue ({{ $reports['bookings']['completed'] }} completed bookings)</span>
                <span><strong>${{ number_format($reports['bookings']['revenue'], 2) }}</strong></span>
            </div>
            <div class="revenue-item">
                <span>Sales Revenue ({{ $reports['purchases']['completed'] }} completed purchases)</span>
                <span><strong>${{ number_format($reports['purchases']['revenue'], 2) }}</strong></span>
            </div>
            <div class="revenue-item revenue-total">
                <span>Total Revenue</span>
                <span><strong>${{ number_format($reports['bookings']['revenue'] + $reports['purchases']['revenue'], 2) }}</strong></span>
            </div>
        </div>
    </div>

    <!-- Popular Vehicles -->
    @if($popularRentals->count() > 0)
    <div class="section">
        <h2>Most Popular Rental Vehicles</h2>
        <table>
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Vehicle</th>
                    <th>Make & Model</th>
                    <th>Year</th>
                    <th>Daily Rate</th>
                    <th>Bookings</th>
                </tr>
            </thead>
            <tbody>
                @foreach($popularRentals as $index => $vehicle)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $vehicle->full_name }}</td>
                    <td>{{ $vehicle->make }} {{ $vehicle->model }}</td>
                    <td>{{ $vehicle->year }}</td>
                    <td>${{ number_format($vehicle->daily_rate, 2) }}</td>
                    <td>{{ $vehicle->bookings_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Key Performance Metrics -->
    <div class="section">
        <h2>Key Performance Metrics</h2>
        <div class="metrics-grid">
            <div class="metric-item">
                <div class="metric-value">
                    {{ $reports['bookings']['total'] > 0 ? number_format(($reports['bookings']['completed'] / $reports['bookings']['total']) * 100, 1) : 0 }}%
                </div>
                <div class="metric-label">Booking Completion Rate</div>
            </div>
            
            <div class="metric-item">
                <div class="metric-value">
                    {{ $reports['purchases']['total'] > 0 ? number_format(($reports['purchases']['completed'] / $reports['purchases']['total']) * 100, 1) : 0 }}%
                </div>
                <div class="metric-label">Purchase Completion Rate</div>
            </div>
            
            <div class="metric-item">
                <div class="metric-value">
                    ${{ $reports['bookings']['completed'] > 0 ? number_format($reports['bookings']['revenue'] / $reports['bookings']['completed'], 2) : '0.00' }}
                </div>
                <div class="metric-label">Average Booking Value</div>
            </div>
            
            <div class="metric-item">
                <div class="metric-value">
                    ${{ $reports['purchases']['completed'] > 0 ? number_format($reports['purchases']['revenue'] / $reports['purchases']['completed'], 2) : '0.00' }}
                </div>
                <div class="metric-label">Average Purchase Value</div>
            </div>
        </div>
    </div>

    <!-- Summary Table -->
    <div class="section">
        <h2>Detailed Summary</h2>
        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Metric</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr><td rowspan="3">Bookings</td><td>Total Bookings</td><td>{{ number_format($reports['bookings']['total']) }}</td></tr>
                <tr><td>Completed Bookings</td><td>{{ number_format($reports['bookings']['completed']) }}</td></tr>
                <tr><td>Booking Revenue</td><td>${{ number_format($reports['bookings']['revenue'], 2) }}</td></tr>
                
                <tr><td rowspan="3">Purchases</td><td>Total Purchases</td><td>{{ number_format($reports['purchases']['total']) }}</td></tr>
                <tr><td>Completed Purchases</td><td>{{ number_format($reports['purchases']['completed']) }}</td></tr>
                <tr><td>Sales Revenue</td><td>${{ number_format($reports['purchases']['revenue'], 2) }}</td></tr>
                
                <tr><td rowspan="2">Users</td><td>New Registrations</td><td>{{ number_format($reports['users']['new_registrations']) }}</td></tr>
                <tr><td>Active Users</td><td>{{ number_format($reports['users']['active_users']) }}</td></tr>
                
                <tr><td rowspan="3">Vehicles</td><td>Total Vehicles</td><td>{{ number_format($reports['vehicles']['total']) }}</td></tr>
                <tr><td>Available for Rent</td><td>{{ number_format($reports['vehicles']['available_for_rent']) }}</td></tr>
                <tr><td>Available for Sale</td><td>{{ number_format($reports['vehicles']['available_for_sale']) }}</td></tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>This report was generated automatically by the Car Rental & Sales Management System</p>
        <p>© {{ now()->year }} Car Rental & Sales System. All rights reserved.</p>
    </div>
</body>
</html>