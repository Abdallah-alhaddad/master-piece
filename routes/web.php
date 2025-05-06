<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorAuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\DoctorsPageController;
use App\Http\Controllers\HomeController;
use App\Models\Subscription;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ChatbotController;


// Public Routes
// Route::get('/', function () {
//     return view('public.welcome');
// })->name('home');


Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/contact', function () {
    return view('public.contact');
})->name('contact');

Route::get('/about', function () {
    return view('public.about');
})->name('about');

// Route::get('/doctor', function () {
//     return view('public.doctor');
// })->name('doctor');


Route::get('/doctors', [DoctorsPageController::class, 'index'])->name('doctors');

Route::get('/doctors/{id}', [DoctorsPageController::class, 'show'])->name('doctor');




/**
 * Admin Routes
 */
// Guest (unauthenticated) admin routes
Route::middleware('guest:admin')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
});

// Authenticated admin routes
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Resource controllers
    Route::resource('admins', AdminController::class);
    Route::resource('specializations', SpecializationController::class);
    Route::resource('users', UserController::class);

    // Doctor routes with additional custom routes
    Route::resource('doctors', DoctorController::class);
    Route::put('/doctors/{doctor}/update-status', [DoctorController::class, 'updateStatus'])
        ->name('admin.doctors.update-status');

    Route::get('/chart', [AdminController::class, 'chart'])->name('admin.chart');
    Route::resource('appointments', AppointmentController::class);
    Route::resource('patients', PatientController::class);
    Route::resource('subscriptions', SubscriptionController::class);
});
/**
 * Doctor Routes
 */

// Authenticated doctor routes
Route::prefix('doctor')->middleware('doctor')->group(function () {
    Route::get('/dashboard', [DoctorAuthController::class, 'show'])->name('doctor.dashboard');
    Route::put('/appointments/{appointmentId}/update', [AppointmentController::class , 'update'])->name('doctor.appointments.update');
    Route::post('/logout', [DoctorAuthController::class, 'logout'])->name('doctor.logout');
    Route::get('/{doctor}/edit', [DoctorController::class, 'edit'])->name('doctors.edit');
    Route::put('/{doctor}', [DoctorController::class, 'update'])->name('doctors.updateDoctor');
    Route::put('/{doctor}/password', [DoctorController::class, 'updatePassword'])->name('doctors.updatePassword');
    Route::post('/appointments', [AppointmentController::class, 'doctorStore'])
    ->name('doctor.appointments.store');
});
Route::post('/subscription/process', [SubscriptionController::class, 'processSubscription'])->name('doctor.subscription.process');



// Guest (unauthenticated) doctor routes
Route::middleware('guest:doctor')->group(function () {
    Route::get('/doctor/register', [DoctorAuthController::class, 'create'])->name('register.doctor');
    Route::post('/doctor/register', [DoctorAuthController::class, 'store'])->name('register.doctor.store');
    Route::get('/doctor/login', [DoctorAuthController::class, 'showLogin'])->name('doctor.login');
    Route::post('/doctor/login', [DoctorAuthController::class, 'login'])->name('doctor.login.submit');
});

/**
 * User Routes
 */
Route::middleware('auth')->group(function () {
    // Route::view('/profile', 'public.profile')->name('profile');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
});

// Authentication routes
require __DIR__.'/auth.php';

// Test email route
Route::get('/test-email', function() {
    try {
        Mail::raw('This is a test email from Heal Point', function($message) {
            $message->to('abdallahalhaddad34@gmail.com')
                    ->subject('Test Email from Heal Point');
        });
        return 'Test email sent successfully!';
    } catch (\Exception $e) {
        return 'Error sending email: ' . $e->getMessage();
    }
});

Route::put('/doctors/{doctor}/update-status', [DoctorController::class, 'updateStatus'])
    ->name('doctors.update-status')
    ->middleware(['auth', 'admin']);

Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store')->middleware('auth');
Route::get('/appointments/{appointment}/rate', [RatingController::class, 'showRatingForm'])->name('appointments.rate')->middleware('auth');

Route::post('/chatbot/recommend', [ChatbotController::class, 'recommend'])->name('chatbot.recommend');

// Test route for chatbot
Route::get('/test-chatbot', function() {
    return response()->json([
        'status' => 'success',
        'message' => 'Chatbot API is working!',
        'test_data' => [
            'symptoms' => 'headache fever',
            'specializations' => ['General Practitioner', 'Neurologist']
        ]
    ]);
});
