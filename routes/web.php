<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\{
    AuthController,
    ClientProfileController,
    SocialAuthController,
    PackageController,
    DeliveryController,
    StripePaymentController,
    FindDriverRequestController,
    DriverOfferController,
    DriverController,
    AdminExportController,
    AdminPerformanceController,
    ReviewController,
    ClientMapController,
    AddressController,
    AdminMapController,
    AdminChatController

};
use App\Http\Controllers\AdminClientChatController;
use App\Http\Controllers\AdminClientController;
use App\Http\Controllers\AdminDeliveryController;
use App\Http\Controllers\AdminEmailController;
use App\Http\Controllers\AdminProfileController;

Route::get('/', function () {
    return view('WelcomeGuest');
})->name('welcomePage');

Route::middleware(['web'])->group(function () {
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'registerClient'])->name('register-submit');

    Route::get('register/Driver', [AuthController::class, 'showRegisterDriverForm'])->name('registerDriver');
    Route::post('register/Driver', [AuthController::class, 'registerDriver'])->name('registerDriver.submit');

    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');

    Route::get('/verify-otp', [AuthController::class, 'showOTPForm'])->name('otp.form');
    Route::post('/verify-otp', [AuthController::class, 'verifyOTP'])->name('verify.otp');

    Route::get('/Social/verify-otp', [SocialAuthController::class, 'showOTPForm'])->name('otp.formSocial');
    Route::post('/Social/verify-otp', [SocialAuthController::class, 'verifyOTP'])->name('verify.otpSocial');

    Route::get('/set-password', [SocialAuthController::class, 'showSetPasswordForm'])->name('password.set.form');
    Route::post('/set-password', [SocialAuthController::class, 'submitSetPassword'])->name('password.set.submit');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
// Authenticated User Info
Route::middleware('auth:sanctum')->get('/user', fn(Request $request) => $request->user());

// Package Routes
Route::resource('packages', PackageController::class);

// In routes/web.php

Route::get('/deliveries/user', [DeliveryController::class, 'userDeliveries'])->name('user.deliveries'); // User sees their own deliveries
Route::get('/deliveries/driver', [DeliveryController::class, 'driverDeliveries'])->name('driver.deliveries'); // Driver can see their deliveries and update status
Route::post('/deliveries/update-status/{deliveryId}', [DeliveryController::class, 'updateStatus'])->name('driver.updateStatus'); // Driver updates delivery status
Route::get('/deliveries/admin', [DeliveryController::class, 'adminDeliveries'])->name('admin.deliveries'); // Admin can see all deliveries

// Find Driver Requests (User Side)
Route::get('/requests', [FindDriverRequestController::class, 'index'])->name('requests.index');
Route::get('/requests/create/{package_id}', [FindDriverRequestController::class, 'create'])->name('requests.create');
Route::post('/requests', [FindDriverRequestController::class, 'store'])->name('requests.store');
Route::get('/requests/{id}/offers', [FindDriverRequestController::class, 'showOffers'])->name('requests.offers');

Route::get('/driver/requests/{driver_id}', [DriverOfferController::class, 'showAvailableRequestsForDriver'])->name('drivers.requests');

// Driver Side
Route::get('/driver/requests', [DriverOfferController::class, 'availableRequests'])->name('driver.requests');
Route::get('/driver/requests/{id}/offer', [DriverOfferController::class, 'makeOffer'])->name('offers.make');
Route::post('/driver/offers', [DriverOfferController::class, 'store'])->name('offers.store');
Route::post('/accept-offer/{offer}', [FindDriverRequestController::class, 'acceptOffer'])->name('acceptOffer');


Route::get('/stripe', [StripePaymentController::class, 'stripe'])->name('stripe');
Route::post('/stripe', [StripePaymentController::class, 'stripePost'])->name('stripe.post');
// Show the payment form for a specific delivery
Route::get('/pay/delivery/{delivery_id}', [StripePaymentController::class, 'stripe'])->name('pay.delivery');

// Handle the Stripe payment submission
Route::post('/pay/delivery/{delivery_id}', [StripePaymentController::class, 'stripePost'])->name('pay.delivery.post');
Route::resource('deliveries', DeliveryController::class);


Route::post('/driver/delivery/{deliveryId}/update-status', [DeliveryController::class, 'updateStatus'])
    ->name('driver.updateStatus');
Route::get('/driver/deliveries', [DeliveryController::class, 'driverDeliveries'])->name('driver.deliveries');

Route::get('/pay/delivery/{delivery_id}', [StripePaymentController::class, 'stripe'])->name('pay.delivery');
Route::post('/pay/delivery/{delivery_id}', [StripePaymentController::class, 'stripePost'])->name('pay.delivery.post');

// Deliveries user route (for redirect)
Route::get('/deliveries/user', [DeliveryController::class, 'userDeliveries'])->name('deliveries.user');


//Route::get('/driver/requests/{id}/offer', [DriverOfferController::class, 'makeOffer'])->name('offers.make');
//Route::get('/driver/requests/{driver_id}', [DriverOfferController::class, 'showAvailableRequestsForDriver'])->name('drivers.requests');
//Route::post('/driver/requests/{id}/offer', [DriverOfferController::class, 'storeOffer'])->name('offers.store');
// Show all available delivery requests for the logged-in driver
Route::get('/driver/requests', [DriverOfferController::class, 'showAvailableRequestsForDriver'])
    ->name('driver.requests');

// Submit an offer for a delivery request
Route::post('/driver/offers/create', [DriverOfferController::class, 'createOffer'])
    ->name('driver.offers.create');

// List all offers by the logged-in driver
Route::get('/driver/offers', [DriverOfferController::class, 'listOffers'])
    ->name('driver.offers.list');
Route::get('/driver/requests/{id}/offer', [DriverOfferController::class, 'makeOffer'])->name('offers.make');
Route::post('/accept-offer/{offer}', [FindDriverRequestController::class, 'acceptOffer'])->name('acceptOffer');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');

    // Driver Management
    Route::get('/drivers/pending', [DriverController::class, 'pending'])->name('admin.drivers.pending');
    Route::post('/drivers/{driver}/approve', [DriverController::class, 'approve'])->name('admin.drivers.approve');
    Route::post('/drivers/{driver}/reject', [DriverController::class, 'reject'])->name('admin.drivers.reject');

    // Exports
    Route::get('/drivers/export/excel', [AdminExportController::class, 'exportExcel'])->name('admin.drivers.export.excel');
    Route::get('/drivers/export/pdf', [AdminExportController::class, 'exportPDF'])->name('admin.drivers.export.pdf');

    // Performance
    Route::get('/driver-performance', [AdminPerformanceController::class, 'index'])->name('admin.performance.index');
    Route::get('/driver-performance/{driver}', [AdminPerformanceController::class, 'show'])->name('admin.performance.show');
    Route::get('/driver-performance/{driver}/pdf', [AdminPerformanceController::class, 'exportPDF'])->name('admin.performance.export.pdf');
});

Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('client-dashboard', function () {
        return View('layouts.app');
    })->name('client-dashboard');
    Route::get('/client/profile/{id}', [ClientProfileController::class, 'show'])->name('client.profile');
    Route::post('/client/{id}/upload-profile-image', [ClientProfileController::class, 'uploadProfileImage'])->name('client.uploadProfileImage');

    Route::get('/deliveries/{id}/review', [ReviewController::class, 'showReview'])->name('reviews.show');
    Route::post('/deliveries/{id}/review', [ReviewController::class, 'store'])->name('reviews.store');

});

Route::get('/auth/google/redirect', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);


Route::get('/auth/github', [SocialAuthController::class, 'redirectToGithub'])->name('auth.github');
Route::get('/auth/callback/github', [SocialAuthController::class, 'handleGithubCallback'])->name('github.callback');













Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('admin-dashboard', function () {
        return View('layouts.app');
    })->name('admin-dashboard');
    // Admin Driver Approval Routes
    Route::get('/admin/drivers/pending', [DriverController::class, 'pending'])->name('admin.drivers.pending');
    Route::post('/admin/drivers/{id}/approve', [DriverController::class, 'approve'])->name('admin.drivers.approve');
    Route::post('/admin/drivers/{id}/reject', [DriverController::class, 'reject'])->name('admin.drivers.reject');
    Route::get('/admin/drivers/export/excel', [AdminExportController::class, 'exportExcel'])->name('admin.drivers.export.excel');
    Route::get('/admin/drivers/export/pdf', [AdminExportController::class, 'exportPDF'])->name('admin.drivers.export.pdf');

    //Admin Driver Monitoring
    Route::get('/admin/driver-performance', [AdminPerformanceController::class, 'index'])->name('admin.driver.performance');
    //search route above this route---> /admin/driver-performance/{driver}
    Route::get('/admin/driver-performance/search', [AdminPerformanceController::class, 'search'])->name('admin.driver.performance.search');
    Route::get('/admin/driver-performance/{driver}', [AdminPerformanceController::class, 'show'])->name('admin.driver.performance.show');
    Route::patch('/admin/drivers/{id}/deactivate', [AdminPerformanceController::class, 'deactivate'])->name('admin.drivers.deactivate');


    Route::get('/admin/driver-performance/{driver}/pdf', [AdminPerformanceController::class, 'exportPDF'])->name('admin.driver.performance.pdf');
//admin map
Route::get('/admin/drivers/map', [AdminMapController::class, 'index'])->name('admin.drivers.map');
//admin chat with driver
Route::get('/admin/chat/{driverId}', [App\Http\Controllers\AdminChatController::class, 'chatWithDriver'])->name('admin.chat.withDriver');
Route::get('/admin/chat', [AdminChatController::class, 'index'])->name('admin.chat.index');
Route::post('/admin/chat/send', [AdminChatController::class, 'sendMessage'])->name('admin.chat.send');

Route::get('/admin/chat/driver-messages/{driverId}', [AdminChatController::class, 'fetchDriverMessages'])->name('admin.chat.fetchDriverMessages');


//Admin with clients
    Route::get('/admin/clients', [AdminClientController::class, 'index'])->name('admin.clients.index');
    Route::get('/admin/clients/export-loyalty-pdf', [AdminExportController::class, 'exportClientLoyaltyPDF'])->name('admin.clients.exportLoyaltyPDF');

//search by name
    Route::get('/admin/clients/search', [AdminClientController::class, 'searchByName'])->name('admin.clients.search');

//Admin client Detail
    Route::get('/admin/clients/{client}', [AdminClientController::class, 'show'])->name('admin.clients.show');

//Admin show deliveries
    Route::get('/admin/deliveries', [AdminDeliveryController::class, 'index'])->name('admin.deliveries.index');
    Route::get('/admin/delivery/{delivery}', [AdminDeliveryController::class, 'show'])->name('admin.delivery.show');
//Admin Email
    Route::get('/admin/email/{email?}', [AdminEmailController::class, 'index'])->name('admin.email.index');
    Route::post('/admin/email/send', [AdminEmailController::class, 'send'])->name('admin.email.send');

    // Step 5: Create route for AJAX fetch of emails
    Route::get('/admin/email-emails', function (Request $request) {
        $type = $request->query('type');

        $emails = match($type) {
            'client' => \App\Models\Client::pluck('email')->toArray(),
            'driver' => \App\Models\Driver::pluck('email')->toArray(),
            default => array_merge(
                \App\Models\Client::pluck('email')->toArray(),
                \App\Models\Driver::pluck('email')->toArray()
            ),
        };

        return response()->json($emails);
    })->name('admin.email.fetch');
//admin chat with client
    Route::get('/admin/chat/clients/{clientId}', [AdminClientChatController::class, 'chatWithClient'])->name('admin.chat.withClient');
    Route::patch('/admin/clients/{client}/loyalty', [AdminClientController::class, 'updateLoyalty'])->name('admin.clients.updateLoyalty');

    /*//Client Map
        Route::get('/admin/clients/{client}/map', function (Client $client) {
            $address = $client->getAddress()->first();
            if ($address && $address->coordinates) {
                [$lat, $lng] = explode(',', $address->coordinates);
                $client->latitude = trim($lat);
                $client->longitude = trim($lng);
            }
            return view('admin.map', ['clients' => [$client], 'showClients' => true]);
        })->name('admin.clients.map.single');
        Route::get('/admin/map', [AdminMapController::class, 'index'])->name('admin.map.index');*/

    Route::get('/admin/chat/clients', [AdminClientChatController::class, 'index'])->name('admin.chat.clients');
//to see json messages
Route::get('/admin/chat/clients/{clientId}', [AdminClientChatController::class, 'chatWithClient'])->name('admin.chat.withClient');
Route::post('/admin/chat/clients/send/{clientId}', [AdminClientChatController::class, 'sendMessage'])->name('admin.chat.clients.send');

    Broadcast::channel('chat.client.{clientId}', function ($user, $clientId) {
        // Allow always for now (no auth), or you can protect it
        return true;
    });

    //Admin profile
    Route::get('/admin/profile/edit', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::patch('/admin/profile/update', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::get('/admin/profile', [AdminProfileController::class, 'show'])->name('admin.profile.show');
    Route::post('/admin/profile/upload-photo', [AdminProfileController::class, 'uploadPhoto'])
        ->name('admin.profile.uploadPhoto');});



























Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('client-dashboard', function () {
        return View('layouts.app');
    })->name('client-dashboard');
    Route::get('/client/profile/{id}', [ClientProfileController::class, 'show'])->name('client.profile');
    Route::post('/client/{id}/upload-profile-image', [ClientProfileController::class, 'uploadProfileImage'])->name('client.uploadProfileImage');

    Route::get('/deliveries/{id}/review', [ReviewController::class, 'showReview'])->name('reviews.show');
    Route::post('/deliveries/{id}/review', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/client-map/{clientId}', [ClientMapController::class, 'index']);
    Route::get('/available-drivers/{regionId}/{scheduledTime}', [ClientMapController::class, 'showAvailableDriversForRegionAndTime'])->name('available.drivers');
});

Route::middleware(['auth', 'role:driver'])->group(function () {
    Route::get('driver-dashboard', function () {
        return View('layouts.app');
    })->name('driver-dashboard');
    Route::resource('drivers', DriverController::class);
    Route::get('/reviews/{id}', [ReviewController::class, 'showDriverReviews'])->name('driver.reviews');
});
Route::get('/client-map/{clientId}', [ClientMapController::class, 'index']);
Route::get('/available-drivers/{regionId}/{scheduledTime}', [ClientMapController::class, 'showAvailableDriversForRegionAndTime'])->name('available.drivers');
Route::resource('addresses', AddressController::class);


Route::get('availability', [DriverController::class, 'availabilityPage'])
      ->name('driver.availability');
 Route::get('regions',     [DriverController::class, 'regionsPage'])
      ->name('driver.regions');
 Route::get('shifts',      [DriverController::class, 'shiftsPage'])
      ->name('driver.shifts');

 // --- Form submissions (PUT) ---
 Route::put('availability', [DriverController::class, 'updateAvailability'])
      ->name('driver.update.availability');
 Route::put('regions',       [DriverController::class, 'updateRegion'])
      ->name('driver.update.regions');
 Route::put('shifts',       [DriverController::class, 'updateShifts'])
      ->name('driver.update.shifts');