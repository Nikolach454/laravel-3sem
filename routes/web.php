<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;

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

Route::get('/signin', [AuthController::class, 'create'])->name('signin');

Route::post('/signin', [AuthController::class, 'registration'])->name('registration');

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
