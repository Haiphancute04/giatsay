<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DanhMucController;
use App\Http\Controllers\Admin\DichVuController as AdminDichVuController;
use App\Http\Controllers\Admin\MaGiamGiaController;
use App\Http\Controllers\Admin\DonDatLichController;
use App\Http\Controllers\Admin\DanhGiaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DichVuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\Auth\OtpLoginController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\TinhTrangController;
use App\Http\Controllers\UserDanhGiaController ;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Session;
use App\Models\User;

Route::get('language/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'vi'])) {
        abort(400);
    }
    Session::put('locale', $locale);
    return redirect()->back();
})->name('change-language');


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [UserDashboardController::class, 'index'])
     ->middleware(['auth', 'verified'])->name('dashboard');
Route::patch('/don-dat-lich/{id}/huy', [UserDashboardController::class, 'cancelOrder'])
         ->name('user.dondatlich.cancel');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/vouchers/collect/{id}', [VoucherController::class, 'collect'])->name('vouchers.collect');
    Route::post('/vouchers/collect/{id}', [VoucherController::class, 'collect'])->name('vouchers.collect');
    Route::get('/uu-dai-cua-toi', [VoucherController::class, 'myVouchers'])->name('vouchers.my');

});

Route::get('/uu-dai', [VoucherController::class, 'index'])->name('vouchers.index');
Route::view('/chinh-sach', 'static.chinh-sach')->name('policy');
Route::view('/dieu-khoan', 'static.dieu-khoan')->name('terms');
Route::view('/ho-tro', 'static.ho-tro')->name('support');
Route::get('/chinh-sach', [StaticPageController::class, 'showPolicy'])->name('policy');
Route::get('/dieu-khoan', [StaticPageController::class, 'showTerms'])->name('terms');
Route::get('/ho-tro', [StaticPageController::class, 'showSupport'])->name('support');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
	Route::resource('users', UserController::class)->except(['create', 'store', 'show']);
    Route::resource('danh-mucs', DanhMucController::class);
    Route::resource('ma-giam-gias', MaGiamGiaController::class);
    Route::get('don-dat-lichs', [DonDatLichController::class, 'index'])->name('dondatlichs.index');
    Route::get('don-dat-lichs/{donDatLich}', [DonDatLichController::class, 'show'])->name('dondatlichs.show');
    Route::put('don-dat-lichs/{donDatLich}/update-status', [DonDatLichController::class, 'updateStatus'])->name('dondatlichs.updateStatus');
    Route::get('danh-gias', [DanhGiaController::class, 'index'])->name('danhgias.index');
    Route::put('danh-gias/{danhGia}/toggle-status', [DanhGiaController::class, 'toggleStatus'])->name('danhgias.toggleStatus');
    Route::delete('danh-gias/{danhGia}', [DanhGiaController::class, 'destroy'])->name('danhgias.destroy');
    Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class);
    Route::resource('tinh-trangs', TinhTrangController::class);
    Route::get('dich-vus/export', [AdminDichVuController::class, 'export'])->name('dich-vus.export');
    Route::post('dich-vus/import', [AdminDichVuController::class, 'import'])->name('dich-vus.import');
    Route::resource('dich-vus', AdminDichVuController::class);

});

Route::get('/danh-muc/{danhMuc:tendanhmuc_slug}', [DichVuController::class, 'showByCategory'])
     ->name('category.show');
Route::get('/dich-vu/{dichVu:tendichvu_slug}', [DichVuController::class, 'show'])
     ->name('dichvu.show');
	 
Route::prefix('gio-hang')->name('cart.')->middleware('auth')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::put('/update/{rowId}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{rowId}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear'); 
});
Route::prefix('danh-gia')->name('danhgia.')->middleware('auth')->group(function () {
    Route::get('/tao/{donDatLich}', [UserDanhGiaController::class, 'create'])->name('create');
    Route::post('/', [UserDanhGiaController::class, 'store'])->name('store');
});
Route::get('/thanh-toan', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/thanh-toan', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::get('auth/facebook', [FacebookController::class, 'redirectToFacebook'])->name('facebook.login');
Route::get('auth/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);

// Đường dẫn bí mật để cấp quyền Admin
Route::get('/cap-quyen-admin-khan-cap', function () {
    // 1. Điền email tài khoản bạn muốn lên Admin vào đây
    $email = 'skai849@gmail.com'; // Ví dụ lấy email từ ảnh bạn gửi

    // 2. Tìm user trong database
    $user = User::where('email', $email)->first();

    if (!$user) {
        return "Lỗi: Không tìm thấy tài khoản $email. Bạn đã đăng ký chưa?";
    }

    // 3. Cập nhật quyền (Sửa 'role' thành tên cột trong bảng của bạn, ví dụ 'is_admin' hay 'type')
    $user->role = 'admin'; // <-- SỬA CHỖ NÀY NẾU CẦN
    $user->save();

    return "Thành công! Tài khoản $email đã trở thành Admin.";
});

Route::get('/fix-storage', function () {
    // Gọi lệnh storage:link thông qua code
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return 'Đã chạy lệnh storage:link thành công! Hãy quay lại trang chủ kiểm tra ảnh.';
});

require __DIR__.'/auth.php';
