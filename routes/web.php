<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\StadiumController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\ReservationController as ReservationBackendController;
use App\Http\Controllers\Frontend\ReservationController as ReservationFrontendController;
use App\Http\Controllers\Backend\SchoolController;
use App\Http\Controllers\Backend\CourseController;
use App\Http\Controllers\Backend\YoungStudentController;
use App\Http\Controllers\Backend\AdultStudentController;
use App\Http\Controllers\Backend\SubscriptionController;
use App\Http\Controllers\Backend\MoneyClosureController;
use App\Http\Controllers\Backend\AlbumController;
use App\Http\Controllers\Backend\VideoController;
use App\Http\Controllers\Backend\ArticleController as ArticleBackendController;
use App\Http\Controllers\Frontend\ArticleController as ArticleFrontendController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\ConceptController;
use App\Http\Controllers\Backend\PaymentMethodController;
use App\Http\Controllers\Backend\MovementController;
use App\Http\Controllers\Backend\ProductCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\AttendanceController;
use App\Http\Controllers\Frontend\MyAccountController;
use App\Http\Controllers\Backend\StadiumPriceController;

Auth::routes();
Route::get('login', function () {
    return to_route('admin.login');
})->name('login');

Route::get('/', [HomeController::class, 'index'])->name('frontend.home');
Route::get('/calendario-reservas/{date?}/{stadium_id?}', [ReservationFrontendController::class, 'reservationsCalendar'])->name('frontend.reservations_calendar');
Route::post('/guardar-reserva', [ReservationFrontendController::class, 'saveSession'])->name('frontend.reservations_save');
Route::get('/reserva-vista-previa', [ReservationFrontendController::class, 'preview'])->name('frontend.reservations_preview');
Route::post('/reservar', [ReservationFrontendController::class, 'store'])->name('frontend.reservations_store');
Route::get('/noticias', [ArticleFrontendController::class, 'index'])->name('frontend.articles.index');
Route::get('/noticias/{slug}', [ArticleFrontendController::class, 'show'])->name('frontend.articles.show');
Route::middleware(['auth', 'check-customer'])->group(function () {
    Route::prefix('mi-cuenta')->group(function () {
        Route::get('/', [MyAccountController::class, 'index'])->name('frontend.my_account.index');
        Route::post('/', [MyAccountController::class, 'update'])->name('frontend.my_account.store');
        Route::get('mis-reservas', [MyAccountController::class, 'reservations'])->name('frontend.my_account.reservations');
    });
});

Route::group(['middleware' => ['guest']], function () {
    Route::get('entrar', [HomeController::class, 'loginView'])->name('frontend.login.view');
    Route::get('entrar-administrador', [AdminController::class, 'loginView'])->name('admin.login');
});

Route::middleware(['auth', 'check-user', 'check-permission'])->group(function () {
    Route::prefix('admin')->group(function () {
        // Admin dashboard
        Route::get('/', [AdminController::class, 'index'])->name('admin.home');
        Route::post('/generate-birthdate-pdf', [AdminController::class, 'generateBirthdatePdf'])->name('admin.generate_birthdate_pdf');

        // Change password
        Route::get('change-password', [AdminController::class, 'changePasswordView'])->name('change_password_view');
        Route::post('change-password', [AdminController::class, 'changePasswordDb'])->name('change_password_save');

        // Customers
        Route::prefix('customers')->group(function () {
            Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
            Route::get('/create', [CustomerController::class, 'create'])->name('customers.create');
            Route::post('/', [CustomerController::class, 'store'])->name('customers.store');
            Route::get('/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
            Route::put('/{id}', [CustomerController::class, 'update'])->name('customers.update');
            Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
        });

        // Reservations
        Route::prefix('reservations')->group(function () {
            Route::get('/', [ReservationBackendController::class, 'index'])->name('reservations.index');
            Route::post('/{id}/change-state', [ReservationBackendController::class, 'changeState'])->name('reservations.change_state');
            Route::get('/{id}/detail', [ReservationBackendController::class, 'detail'])->name('reservations.detail');
            Route::delete('/{id}', [ReservationBackendController::class, 'destroy'])->name('reservations.destroy');
            Route::get('/create/{date?}/{stadium_id?}', [ReservationBackendController::class, 'create'])->name('reservations.create');
            Route::post('/', [ReservationBackendController::class, 'store'])->name('reservations.store');
            Route::post('/search-customer', [ReservationBackendController::class, 'searchCustomer'])->name('reservations.search_customer');
            Route::get('/create-fixed', [ReservationBackendController::class, 'createFixed'])->name('reservations.create_fixed');
            Route::post('/store-fixed', [ReservationBackendController::class, 'storeFixed'])->name('reservations.store_fixed');
        });

        // Reservations by day
        Route::get('/reservations-by-day/{date?}/{stadium_id?}', [ReservationBackendController::class, 'reservationsByDay'])->name('reservations_by_day.index');
        Route::get('/reservations-by-day/pdf/{date}/{stadium_id}', [ReservationBackendController::class, 'reservationsByDayPdf'])->name('reservations_by_day.pdf');

        // Pending reservations
        Route::get('/pending-reservations', [ReservationBackendController::class, 'pendingReservations'])->name('pending_reservations.index');

        // Schools
        Route::prefix('schools')->group(function () {
            Route::get('/', [SchoolController::class, 'index'])->name('schools.index');
            Route::get('/create', [SchoolController::class, 'create'])->name('schools.create');
            Route::post('/', [SchoolController::class, 'store'])->name('schools.store');
            Route::get('/{id}/edit', [SchoolController::class, 'edit'])->name('schools.edit');
            Route::put('/{id}', [SchoolController::class, 'update'])->name('schools.update');
            Route::delete('/{id}', [SchoolController::class, 'destroy'])->name('schools.destroy');
        });

        // Courses
        Route::prefix('courses')->group(function () {
            Route::get('/', [CourseController::class, 'index'])->name('courses.index');
            Route::get('/create', [CourseController::class, 'create'])->name('courses.create');
            Route::post('/', [CourseController::class, 'store'])->name('courses.store');
            Route::get('/{id}/edit', [CourseController::class, 'edit'])->name('courses.edit');
            Route::put('/{id}', [CourseController::class, 'update'])->name('courses.update');
            Route::get('/{id}', [CourseController::class, 'show'])->name('courses.show');
            Route::delete('/{id}', [CourseController::class, 'destroy'])->name('courses.destroy');
        });

        // Young students
        Route::prefix('young-students')->group(function () {
            Route::get('/', [YoungStudentController::class, 'index'])->name('young_students.index');
            Route::get('/create', [YoungStudentController::class, 'create'])->name('young_students.create');
            Route::post('/', [YoungStudentController::class, 'store'])->name('young_students.store');
            Route::get('/{id}/edit', [YoungStudentController::class, 'edit'])->name('young_students.edit');
            Route::put('/{id}', [YoungStudentController::class, 'update'])->name('young_students.update');
            Route::get('/{id}', [YoungStudentController::class, 'show'])->name('young_students.show');
            Route::delete('/{id}', [YoungStudentController::class, 'destroy'])->name('young_students.destroy');
            Route::get('/edit/proxy/{proxy_id}', [YoungStudentController::class, 'editProxy'])->name('young_students.edit.proxy');
            Route::post('/update/proxy/{proxy_id}', [YoungStudentController::class, 'updateProxy'])->name('young_students.update.proxy');
            Route::post('/date-of-birth-pdf', [YoungStudentController::class, 'dateOfBirthPdf'])->name('young_students.date_of_birth_pdf');
            Route::delete('delete/{id}', [YoungStudentController::class, 'delete'])->name('young_students.delete');
        });

        // Adult students
        Route::prefix('adult-students')->group(function () {
            Route::get('/', [AdultStudentController::class, 'index'])->name('adult_students.index');
            Route::get('/create', [AdultStudentController::class, 'create'])->name('adult_students.create');
            Route::post('/', [AdultStudentController::class, 'store'])->name('adult_students.store');
            Route::get('/{id}/edit', [AdultStudentController::class, 'edit'])->name('adult_students.edit');
            Route::put('/{id}', [AdultStudentController::class, 'update'])->name('adult_students.update');
            Route::get('/{id}', [AdultStudentController::class, 'show'])->name('adult_students.show');
            Route::delete('/{id}', [AdultStudentController::class, 'destroy'])->name('adult_students.destroy');
            Route::delete('delete/{id}', [AdultStudentController::class, 'delete'])->name('adult_students.delete');
        });

        // Subscriptions
        Route::prefix('subscriptions')->group(function () {
            Route::get('/', [SubscriptionController::class, 'index'])->name('subscriptions.index');
            Route::get('/create/{student_id?}', [SubscriptionController::class, 'create'])->name('subscriptions.create');
            Route::post('/', [SubscriptionController::class, 'store'])->name('subscriptions.store');
            Route::get('/{id}/edit', [SubscriptionController::class, 'edit'])->name('subscriptions.edit');
            Route::put('/{id}', [SubscriptionController::class, 'update'])->name('subscriptions.update');
            Route::get('/{id}', [SubscriptionController::class, 'show'])->name('subscriptions.show');
            Route::delete('/{id}', [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy');
            Route::get('/get-course/{id}', [SubscriptionController::class, 'getCourseData'])->name('subscriptions.get_course');
            Route::post('/pay', [SubscriptionController::class, 'pay'])->name('subscriptions.pay');
        });

        // Money Closures
        Route::prefix('money-closures')->group(function () {
            Route::get('/', [MoneyClosureController::class, 'index'])->name('money_closures.index');
            Route::get('/create', [MoneyClosureController::class, 'create'])->name('money_closures.create');
            Route::post('/', [MoneyClosureController::class, 'store'])->name('money_closures.store');
            Route::get('/{id}/edit', [MoneyClosureController::class, 'edit'])->name('money_closures.edit');
            Route::put('/{id}', [MoneyClosureController::class, 'update'])->name('money_closures.update');
            Route::get('/{id}', [MoneyClosureController::class, 'show'])->name('money_closures.show');
            Route::delete('/{id}', [MoneyClosureController::class, 'destroy'])->name('money_closures.destroy');
            Route::get('/get-real-total/{date}/{stadium_id}', [MoneyClosureController::class, 'getRealTotal'])->name('money_closures.get_real_total');
        });

        // Articles
        Route::prefix('articles')->group(function () {
            Route::get('/', [ArticleBackendController::class, 'index'])->name('articles.index');
            Route::get('/create', [ArticleBackendController::class, 'create'])->name('articles.create');
            Route::post('/', [ArticleBackendController::class, 'store'])->name('articles.store');
            Route::get('/{id}/edit', [ArticleBackendController::class, 'edit'])->name('articles.edit');
            Route::put('/{id}', [ArticleBackendController::class, 'update'])->name('articles.update');
            Route::get('/{id}', [ArticleBackendController::class, 'show'])->name('articles.show');
            Route::delete('/{id}', [ArticleBackendController::class, 'destroy'])->name('articles.destroy');
        });

        // Users
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('users.index');
            Route::get('/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/', [UserController::class, 'store'])->name('users.store');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
            Route::get('/{id}', [UserController::class, 'show'])->name('users.show');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        });

        // Stadiums
        Route::prefix('stadiums')->group(function () {
            Route::get('/', [StadiumController::class, 'index'])->name('stadiums.index');
            Route::get('/create', [StadiumController::class, 'create'])->name('stadiums.create');
            Route::post('/', [StadiumController::class, 'store'])->name('stadiums.store');
            Route::get('/{id}/edit', [StadiumController::class, 'edit'])->name('stadiums.edit');
            Route::put('/{id}', [StadiumController::class, 'update'])->name('stadiums.update');
            Route::get('/{id}', [StadiumController::class, 'show'])->name('stadiums.show');
            Route::delete('/{id}', [StadiumController::class, 'destroy'])->name('stadiums.destroy');
        });

        // Stadium prices
        Route::prefix('stadium_prices')->group(function () {
            Route::get('/{id}/create', [StadiumPriceController::class, 'create'])->name('stadium_prices.create');
            Route::post('/{id}', [StadiumPriceController::class, 'store'])->name('stadium_prices.store');
        });

        // Albums
        Route::prefix('albums')->group(function () {
            Route::get('/', [AlbumController::class, 'index'])->name('albums.index');
            Route::get('/create', [AlbumController::class, 'create'])->name('albums.create');
            Route::post('/', [AlbumController::class, 'store'])->name('albums.store');
            Route::get('/{id}/edit', [AlbumController::class, 'edit'])->name('albums.edit');
            Route::put('/{id}', [AlbumController::class, 'update'])->name('albums.update');
            Route::get('/{id}', [AlbumController::class, 'show'])->name('albums.show');
            Route::delete('/{id}', [AlbumController::class, 'destroy'])->name('albums.destroy');
            Route::post('/{id}/add-photos', [AlbumController::class, 'addPhotos'])->name('albums.add_photos');
            Route::delete('/delete-photo/{id}', [AlbumController::class, 'deletePhoto'])->name('albums.delete_photo');
        });

        // Videos
        Route::prefix('videos')->group(function () {
            Route::get('/', [VideoController::class, 'index'])->name('videos.index');
            Route::get('/create', [VideoController::class, 'create'])->name('videos.create');
            Route::post('/', [VideoController::class, 'store'])->name('videos.store');
            Route::get('/{id}/edit', [VideoController::class, 'edit'])->name('videos.edit');
            Route::put('/{id}', [VideoController::class, 'update'])->name('videos.update');
            Route::get('/{id}', [VideoController::class, 'show'])->name('videos.show');
            Route::delete('/{id}', [VideoController::class, 'destroy'])->name('videos.destroy');
        });

        // Subscription payments
        Route::prefix('subscriptions-payments')->group(function () {
            Route::get('/', [SubscriptionController::class, 'payments'])->name('subscriptions_payments.index');
            Route::get('/get-balance/{month}/{year}/{class}', [SubscriptionController::class, 'getBalance'])->name('subscriptions_payments.get_balance');
        });

        // Roles
        Route::prefix('roles')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('roles.index');
            Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
            Route::put('/{id}', [RoleController::class, 'update'])->name('roles.update');
        });

        // Movements
        Route::prefix('movements')->group(function () {
            Route::get('/', [MovementController::class, 'index'])->name('movements.index');
            Route::get('/create', [MovementController::class, 'create'])->name('movements.create');
            Route::post('/', [MovementController::class, 'store'])->name('movements.store');
            Route::get('/{id}/edit', [MovementController::class, 'edit'])->name('movements.edit');
            Route::put('/{id}', [MovementController::class, 'update'])->name('movements.update');
            Route::get('/{id}', [MovementController::class, 'show'])->name('movements.show');
            Route::delete('/{id}', [MovementController::class, 'destroy'])->name('movements.destroy');
        });

        // Concepts
        Route::prefix('concepts')->group(function () {
            Route::get('/', [ConceptController::class, 'index'])->name('concepts.index');
            Route::get('/create', [ConceptController::class, 'create'])->name('concepts.create');
            Route::post('/', [ConceptController::class, 'store'])->name('concepts.store');
            Route::get('/{id}/edit', [ConceptController::class, 'edit'])->name('concepts.edit');
            Route::put('/{id}', [ConceptController::class, 'update'])->name('concepts.update');
            Route::delete('/{id}', [ConceptController::class, 'destroy'])->name('concepts.destroy');
        });

        // Payment methods
        Route::prefix('payment-methods')->group(function () {
            Route::get('/', [PaymentMethodController::class, 'index'])->name('payment_methods.index');
            Route::get('/create', [PaymentMethodController::class, 'create'])->name('payment_methods.create');
            Route::post('/', [PaymentMethodController::class, 'store'])->name('payment_methods.store');
            Route::get('/{id}/edit', [PaymentMethodController::class, 'edit'])->name('payment_methods.edit');
            Route::put('/{id}', [PaymentMethodController::class, 'update'])->name('payment_methods.update');
            Route::get('/{id}', [PaymentMethodController::class, 'show'])->name('payment_methods.show');
            Route::delete('/{id}', [PaymentMethodController::class, 'destroy'])->name('payment_methods.destroy');
        });

        // Product categories
        Route::prefix('product-categories')->group(function () {
            Route::get('/', [ProductCategoryController::class, 'index'])->name('product_categories.index');
            Route::get('/create', [ProductCategoryController::class, 'create'])->name('product_categories.create');
            Route::post('/', [ProductCategoryController::class, 'store'])->name('product_categories.store');
            Route::get('/{id}/edit', [ProductCategoryController::class, 'edit'])->name('product_categories.edit');
            Route::put('/{id}', [ProductCategoryController::class, 'update'])->name('product_categories.update');
            Route::delete('/{id}', [ProductCategoryController::class, 'destroy'])->name('product_categories.destroy');
        });

        // Products
        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('products.index');
            Route::get('/create', [ProductController::class, 'create'])->name('products.create');
            Route::post('/', [ProductController::class, 'store'])->name('products.store');
            Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
            Route::put('/{id}', [ProductController::class, 'update'])->name('products.update');
            Route::get('/{id}', [ProductController::class, 'show'])->name('products.show');
            Route::delete('/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        });

        // Products
        Route::prefix('attendance')->group(function () {
            Route::get('/check-view', [AttendanceController::class, 'checkView'])->name('attendance.check_view');
            Route::post('/check-save', [AttendanceController::class, 'checkSave'])->name('attendance.check_save');
        });
    });
});
