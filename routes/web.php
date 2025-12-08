<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * Главная страница (список статей)
 */
Route::get('/', [MainController::class, 'index'])->name('home');

/**
 * Страница галереи (детальный просмотр статьи)
 */
Route::get('/gallery/{index}', [MainController::class, 'gallery'])->name('gallery');

/**
 * Маршруты аутентификации
 */
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/**
 * CRUD маршруты для работы с новостями
 * index - список всех статей (доступен всем)
 * show - просмотр одной статьи (доступен всем)
 * create, store, edit, update, destroy - требуют авторизации
 */
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

Route::middleware('auth')->group(function () {
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
});

Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show')->middleware('track.article.views');

Route::middleware('auth')->group(function () {
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');

    Route::post('/articles/{article}/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{comment}/edit', [App\Http\Controllers\CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [App\Http\Controllers\CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');

    Route::get('/comments/moderation', [App\Http\Controllers\CommentController::class, 'moderation'])->name('comments.moderation');
    Route::patch('/comments/{comment}/approve', [App\Http\Controllers\CommentController::class, 'approve'])->name('comments.approve');
    Route::delete('/comments/{comment}/reject', [App\Http\Controllers\CommentController::class, 'reject'])->name('comments.reject');

    Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});

/**
 * Страница "О нас"
 */
Route::get('/about', function () {
    return view('about');
})->name('about');

/**
 * Страница "Контакты"
 * Динамическая страница с передачей данных через массив
 * Демонстрирует работу с передачей данных в представление через метод view()
 */
Route::get('/contacts', function () {
    // Массив с контактными данными
    $contacts = [
        [
            'type' => 'address',
            'title' => 'Адрес',
            'value' => 'г. Москва, ул. Примерная, д. 123, офис 456',
            'description' => 'Посетите наш офис в рабочее время'
        ],
        [
            'type' => 'phone',
            'title' => 'Телефон',
            'value' => '+7 (999) 123-45-67',
            'description' => 'Звоните в рабочее время'
        ],
        [
            'type' => 'email',
            'title' => 'Email',
            'value' => 'info@example.com',
            'description' => 'Ответим в течение 24 часов'
        ],
        [
            'type' => 'other',
            'title' => 'Техподдержка',
            'value' => 'support@example.com',
            'description' => 'По техническим вопросам'
        ]
    ];

    // Массив с социальными сетями
    $socialMedia = [
        [
            'name' => 'ВКонтакте',
            'url' => 'https://vk.com',
            'color' => 'primary'
        ],
        [
            'name' => 'Telegram',
            'url' => 'https://telegram.org',
            'color' => 'info'
        ],
        [
            'name' => 'YouTube',
            'url' => 'https://youtube.com',
            'color' => 'danger'
        ]
    ];

    // Режим работы
    $workingHours = [
        'Понедельник' => '9:00 - 18:00',
        'Вторник' => '9:00 - 18:00',
        'Среда' => '9:00 - 18:00',
        'Четверг' => '9:00 - 18:00',
        'Пятница' => '9:00 - 17:00',
        'Суббота' => 'Выходной',
        'Воскресенье' => 'Выходной'
    ];

    // Передача всех данных в представление через метод view()
    return view('contacts', [
        'contacts' => $contacts,
        'socialMedia' => $socialMedia,
        'workingHours' => $workingHours
    ]);
})->name('contacts');
