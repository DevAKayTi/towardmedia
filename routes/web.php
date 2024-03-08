<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\DateRangeController;
use App\Http\Controllers\Frontend\PageController as FrontendPageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\VolumeController;
use App\Http\Controllers\BulletinController;
use App\Http\Controllers\SubscriberController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [FrontendPageController::class, 'welcome'])->name('welcome');
Route::get('/articles', [FrontendPageController::class, 'articles'])->name('articles');
Route::get('/about-us', [FrontendPageController::class, 'aboutUs'])->name('about-us');
Route::get('/subscribe', [FrontendPageController::class, 'subscribe'])->name('subscribe');
Route::get('/privacy-policy', [FrontendPageController::class, 'privacyPolicy'])->name('privacy-policy');
// Route::get('/news', [FrontendPageController::class, 'news'])->name('news');
Route::get('/bulletins', [FrontendPageController::class, 'bulletins'])->name('bulletins');
Route::get('/podcasts', [FrontendPageController::class, 'podcasts'])->name('podcasts');
Route::get('/volumes', [FrontendPageController::class, 'volumes'])->name('volumes');
Route::get('/volume/{id}', [FrontendPageController::class, 'volumeDetail'])->name('frontend.volumes.show');
Route::get('/bulletin/{id}', [FrontendPageController::class, 'bulletinDetail'])->name('frontend.bulletins.show');

Route::get('/p/{post:slug}', [FrontendPageController::class, 'show'])->name('frontend.blog.show');

Route::get('/blog/{tag:name}', [FrontendPageController::class, 'groupByTag'])->name('frontend.blog.groupByTag');
Route::get('/c/{category:slug}', [FrontendPageController::class, 'groupByCategory'])->name('frontend.blog.groupByCategory');

Route::post('/blog/increaseViewCount/{post_id}', [FrontendPageController::class, 'increaseViewCount']);
Route::post('/subscriber',[SubscriberController::class, 'createSubscriber'])->name('subscribe.create');
Route::get('/verify/{token}',[SubscriberController::class,'verifyMail'])->name('subscribe.verify');

Route::middleware(['auth', 'prevent-back-history', 'check-user-status'])->prefix('admin')->group(function () {
    // dashboard
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    // blogs
    Route::get('/blogs/unpublished', [PostController::class, 'getUnpublishedPosts'])->name('blogs.unpublished');
    Route::get('/blogs/published', [PostController::class, 'getPublishedPosts'])->name('blogs.published');
    Route::resource('/blogs', PostController::class);

    // password reset 
    Route::post('/admin/passwordChange', [PageController::class, 'passwordChange'])->name('auth.user.passwordChange');

    // activities
    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
    Route::get('/activities/{id}', [ActivityController::class, 'show'])->name('activities.detail');

    // authors
    Route::resource('/authors', AuthorController::class);
    Route::get('/authors/{id}/posts', [AuthorController::class, 'showPosts'])->name('authors.posts');
    Route::get('/authors/{id}/activities', [AuthorController::class, 'showActivities'])->name('authors.activities');
    Route::get('/authors/passwordReset/{authorId}', [AuthorController::class, 'showPasswordResetForm'])->name('authors.passwordReset');
    Route::post('/authors/passwordReset/{authorId}', [AuthorController::class, 'passwordReset'])->name('authors.passwordReset.post');
    Route::post('/authors/changeStatus', [AuthorController::class, 'changeStatus'])->name('changeStatus');
    // ajax ssd
    Route::post('imageUpload', [PostController::class, 'imageUpload'])->name('imageUpload');
    Route::post('storeTag', [PageController::class, 'storeTagWithAjax'])->name('storeTag');

    // Volume
    Route::resource('volumes', VolumeController::class);
    Route::get('/volumes/{id}/articles', [VolumeController::class, 'articles'])->name('volumes.articles');

    //Bulletins
    Route::resource('bulletins', BulletinController::class);
    Route::get('/bulletins/{id}/articles', [BulletinController::class, 'articles'])->name('bulletins.articles');

    // profile
    Route::get('/profile', [PageController::class, 'profile'])->name('profile');
    Route::post('/updateProfile/{id}', [PageController::class, 'updateProfile'])->name('updateProfile');
    Route::get('/profile/{id}/posts', [PageController::class, 'posts'])->name('authUser.posts');

    Route::post('createVolume', [PageController::class, 'createDynamicVolumeWithAjax'])->name('createVolume');
    Route::post('createBulletin', [PageController::class, 'createDynamicBulletinWithAjax'])->name('createBulletin');
});

Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('login');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('logout');

Auth::routes(['login' => false, 'register' => false, 'reset' => false, 'confirm' => false]);
