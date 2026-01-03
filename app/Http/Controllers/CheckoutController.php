<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Purchase;
use App\Models\Payment;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    /**
     * Stage 1: Vehicle Confirmation
     */
    public function stage1(Vehicle $vehicle)
    {
        if (!$vehicle->isAvailableForSale()) {
            return redirect()->route('vehicles.show', $vehicle)
                ->with('error', 'Vehicle is not available for purchase.');
        }

        // Clear any existing checkout session
        Session::forget('checkout');

        // Initialize checkout session
        Session::put('checkout', [
            'vehicle_id' => $vehicle->id,
            'stage' => 1,
            'started_at' => now(),
        ]);

        return view('checkout.stage1', compact('vehicle'));
    }

    /**
     * Show Stage 2: Buyer Information Form
     */
    public function showStage2()
    {
        $checkout = Session::get('checkout');
        if (!$checkout || !isset($checkout['vehicle_id'])) {
            return redirect()->route('vehicles.sales')->with('error', 'Invalid checkout session.');
        }

        $vehicle = Vehicle::findOrFail($checkout['vehicle_id']);
        
        // Ensure we're at least at stage 1
        if (!isset($checkout['stage']) || $checkout['stage'] < 1) {
            return redirect()->route('vehicles.sales')->with('error', 'Invalid checkout session.');
        }

        return view('checkout.stage2', compact('vehicle'));
    }

    /**
     * Process Stage 2: Buyer Information
     */
    public function processStage2(Request $request)
    {
        $checkout = Session::get('checkout');
        if (!$checkout || !isset($checkout['vehicle_id'])) {
            return redirect()->route('vehicles.sales')->with('error', 'Invalid checkout session.');
        }

        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'city' => 'required|string|max:100',
            'national_id' => 'nullable|string|max:50',
        ]);

        // Save buyer information to session
        Session::put('checkout.buyer_info', $request->only([
            'full_name', 'phone', 'email', 'city', 'national_id'
        ]));
        Session::put('checkout.stage', 3);

        return redirect()->route('checkout.stage3.show');
    }

    /**
     * Show Stage 3: Delivery & Pickup Options Form
     */
    public function showStage3()
    {
        $checkout = Session::get('checkout');
        if (!$checkout || !isset($checkout['vehicle_id']) || !isset($checkout['buyer_info'])) {
            return redirect()->route('vehicles.sales')->with('error', 'Invalid checkout session.');
        }

        $vehicle = Vehicle::findOrFail($checkout['vehicle_id']);
        
        return view('checkout.stage3', compact('vehicle'));
    }

    /**
     * Process Stage 3: Delivery & Pickup Options
     */
    public function processStage3(Request $request)
    {
        $checkout = Session::get('checkout');
        if (!$checkout || !isset($checkout['vehicle_id']) || !isset($checkout['buyer_info'])) {
            return redirect()->route('vehicles.sales')->with('error', 'Invalid checkout session.');
        }

        $request->validate([
            'delivery_option' => 'required|in:pickup,company_delivery,custom_delivery',
            'delivery_address' => 'required_if:delivery_option,custom_delivery|nullable|string|max:500',
            'preferred_date' => 'required|date|after:today',
            'contact_person' => 'nullable|string|max:255',
        ]);

        // Calculate delivery cost
        $deliveryCost = match($request->delivery_option) {
            'pickup' => 0,
            'company_delivery' => 500,
            'custom_delivery' => 1000,
        };

        // Save delivery information to session
        Session::put('checkout.delivery_info', array_merge(
            $request->only(['delivery_option', 'delivery_address', 'preferred_date', 'contact_person']),
            ['delivery_cost' => $deliveryCost]
        ));
        Session::put('checkout.stage', 4);

        return redirect()->route('checkout.stage4.show');
    }

    /**
     * Show Stage 4: Payment Method Selection
     */
    public function showStage4()
    {
        $checkout = Session::get('checkout');
        if (!$checkout || !isset($checkout['vehicle_id']) || !isset($checkout['buyer_info']) || !isset($checkout['delivery_info'])) {
            return redirect()->route('vehicles.sales')->with('error', 'Invalid checkout session.');
        }

        $vehicle = Vehicle::findOrFail($checkout['vehicle_id']);
        
        return view('checkout.stage4', compact('vehicle'));
    }

    /**
     * Process Stage 4: Payment Method Selection
     */
    public function processStage4(Request $request)
    {
        $checkout = Session::get('checkout');
        if (!$checkout || !isset($checkout['vehicle_id']) || !isset($checkout['buyer_info']) || !isset($checkout['delivery_info'])) {
            return redirect()->route('vehicles.sales')->with('error', 'Invalid checkout session.');
        }

        $request->validate([
            'payment_method' => 'required|in:cbe_mobile,abyssinia_mobile,telebirr,dashen_mobile,cbe_transfer,abyssinia_transfer,dashen_transfer',
        ]);

        Session::put('checkout.payment_method', $request->payment_method);
        Session::put('checkout.stage', 5);

        return redirect()->route('checkout.stage5.show');
    }

    /**
     * Show Stage 5: Payment Instructions & Completion
     */
    public function showStage5()
    {
        $checkout = Session::get('checkout');
        if (!$checkout || !isset($checkout['vehicle_id']) || !isset($checkout['buyer_info']) || !isset($checkout['delivery_info']) || !isset($checkout['payment_method'])) {
            return redirect()->route('vehicles.sales')->with('error', 'Invalid checkout session.');
        }

        $vehicle = Vehicle::findOrFail($checkout['vehicle_id']);
        
        return view('checkout.stage5', compact('vehicle'));
    }

    /**
     * Complete Purchase - Create the actual purchase and payment records
     */
    public function complete(Request $request)
    {
        $checkout = Session::get('checkout');
        if (!$checkout || !isset($checkout['vehicle_id']) || !isset($checkout['buyer_info']) || !isset($checkout['delivery_info']) || !isset($checkout['payment_method'])) {
            return redirect()->route('vehicles.sales')->with('error', 'Invalid checkout session.');
        }

        $request->validate([
            'transaction_reference' => 'required|string|max:255',
            'transaction_proof' => 'nullable|string|max:1000',
        ]);

        $vehicle = Vehicle::findOrFail($checkout['vehicle_id']);
        
        if (!$vehicle->isAvailableForSale()) {
            return back()->with('error', 'Vehicle is no longer available for purchase.');
        }

        DB::beginTransaction();
        try {
            // Calculate totals
            $salePrice = $vehicle->sale_price;
            $deliveryCost = $checkout['delivery_info']['delivery_cost'];
            $taxAmount = ($salePrice + $deliveryCost) * 0.15; // 15% tax
            $totalAmount = $salePrice + $deliveryCost + $taxAmount;

            // Create purchase
            $purchase = Purchase::create([
                'user_id' => auth()->id(),
                'vehicle_id' => $vehicle->id,
                'purchase_price' => $salePrice,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'notes' => json_encode([
                    'buyer_info' => $checkout['buyer_info'],
                    'delivery_info' => $checkout['delivery_info'],
                    'checkout_completed_at' => now(),
                ]),
            ]);

            // Get bank details based on payment method
            $bankDetails = $this->getBankDetails($checkout['payment_method']);

            // Create payment record
            $payment = Payment::create([
                'payable_type' => Purchase::class,
                'payable_id' => $purchase->id,
                'user_id' => auth()->id(),
                'amount' => $totalAmount,
                'payment_method' => $checkout['payment_method'],
                'bank_name' => $bankDetails['bank_name'],
                'account_number' => $bankDetails['account_number'],
                'payment_instructions' => "Transfer {$totalAmount} ETB to {$bankDetails['bank_name']} and use reference: " . $purchase->purchase_reference,
                'transaction_reference' => $request->transaction_reference,
                'transaction_proof' => $request->transaction_proof,
                'status' => 'submitted',
            ]);

            // Reserve the vehicle
            $vehicle->update(['status' => 'reserved']);

            AuditLog::log('purchase_completed_checkout', $purchase);

            // Email notifications disabled

            DB::commit();

            // Clear checkout session
            Session::forget('checkout');

            return redirect()->route('checkout.status', $purchase)
                ->with('success', 'Purchase completed successfully! A confirmation email has been sent to your email address. Your payment is being verified and you will receive another email once confirmed.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Failed to complete purchase. Please try again.');
        }
    }

    /**
     * Status Page - Show purchase status after completion
     */
    public function status(Purchase $purchase)
    {
        if ($purchase->user_id !== auth()->id()) {
            abort(403);
        }

        $purchase->load(['vehicle.images', 'payment']);

        return view('checkout.status', compact('purchase'));
    }

    /**
     * Cancel checkout and clear session
     */
    public function cancel()
    {
        Session::forget('checkout');
        return redirect()->route('vehicles.sales')->with('info', 'Checkout cancelled.');
    }

    /**
     * Get bank details based on payment method
     */
    private function getBankDetails($paymentMethod)
    {
        $bankDetails = [
            'cbe_mobile' => [
                'bank_name' => 'Commercial Bank of Ethiopia',
                'account_number' => '1000123456789',
                'account_holder' => 'Car Rental & Sales Ltd',
                'type' => 'mobile'
            ],
            'abyssinia_mobile' => [
                'bank_name' => 'Bank of Abyssinia',
                'account_number' => '2000987654321',
                'account_holder' => 'Car Rental & Sales Ltd',
                'type' => 'mobile'
            ],
            'telebirr' => [
                'bank_name' => 'Telebirr',
                'account_number' => '0911000000',
                'account_holder' => 'Car Rental & Sales Ltd',
                'type' => 'mobile'
            ],
            'dashen_mobile' => [
                'bank_name' => 'Dashen Bank',
                'account_number' => '3000456789123',
                'account_holder' => 'Car Rental & Sales Ltd',
                'type' => 'mobile'
            ],
            'cbe_transfer' => [
                'bank_name' => 'Commercial Bank of Ethiopia',
                'account_number' => '1000123456789',
                'account_holder' => 'Car Rental & Sales Ltd',
                'type' => 'transfer'
            ],
            'abyssinia_transfer' => [
                'bank_name' => 'Bank of Abyssinia',
                'account_number' => '2000987654321',
                'account_holder' => 'Car Rental & Sales Ltd',
                'type' => 'transfer'
            ],
            'dashen_transfer' => [
                'bank_name' => 'Dashen Bank',
                'account_number' => '3000456789123',
                'account_holder' => 'Car Rental & Sales Ltd',
                'type' => 'transfer'
            ]
        ];

        return $bankDetails[$paymentMethod] ?? $bankDetails['cbe_mobile'];
    }
}