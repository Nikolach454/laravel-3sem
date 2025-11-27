# Домашнее задание 4: Аутентификация с Laravel Sanctum

## Описание задачи
Реализована полная система аутентификации пользователей с использованием Laravel Sanctum, включая регистрацию, авторизацию, выход из системы и защиту маршрутов.

---

## Выполненные задачи

### 1. Настройка Laravel Sanctum

Laravel Sanctum уже был установлен в проекте по умолчанию. Проверка наличия:

**Файл:** `app/Models/User.php`

```php
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // ...
}
```

Trait `HasApiTokens` позволяет создавать и управлять токенами для пользователей.

---

### 2. Создание Request классов для валидации

#### RegisterRequest

**Команда:**
```bash
php artisan make:request RegisterRequest
```

**Файл:** `app/Http/Requests/RegisterRequest.php`

```php
public function rules(): array
{
    return [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ];
}

public function messages(): array
{
    return [
        'name.required' => 'Имя обязательно для заполнения',
        'name.max' => 'Имя не должно превышать 255 символов',
        'email.required' => 'Email обязателен для заполнения',
        'email.email' => 'Введите корректный email адрес',
        'email.unique' => 'Пользователь с таким email уже зарегистрирован',
        'password.required' => 'Пароль обязателен для заполнения',
        'password.min' => 'Пароль должен содержать не менее 8 символов',
        'password.confirmed' => 'Пароли не совпадают',
    ];
}
```

**Правила валидации регистрации:**
- `name`: обязательное поле, строка, максимум 255 символов
- `email`: обязательное поле, должен быть валидный email, уникальный в таблице users
- `password`: обязательное поле, минимум 8 символов, должен совпадать с password_confirmation

---

#### LoginRequest

**Команда:**
```bash
php artisan make:request LoginRequest
```

**Файл:** `app/Http/Requests/LoginRequest.php`

```php
public function rules(): array
{
    return [
        'email' => 'required|string|email',
        'password' => 'required|string',
    ];
}

public function messages(): array
{
    return [
        'email.required' => 'Email обязателен для заполнения',
        'email.email' => 'Введите корректный email адрес',
        'password.required' => 'Пароль обязателен для заполнения',
    ];
}
```

**Правила валидации авторизации:**
- `email`: обязательное поле, должен быть валидный email
- `password`: обязательное поле, строка

---

### 3. Реализация методов аутентификации в AuthController

**Файл:** `app/Http/Controllers/AuthController.php`

#### Регистрация пользователя

```php
public function showRegisterForm()
{
    return view('auth.register');
}

public function register(RegisterRequest $request)
{
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return redirect()->route('login')->with('success', 'Регистрация прошла успешно! Войдите в систему.');
}
```

**Процесс регистрации:**
1. Валидация данных через RegisterRequest
2. Создание нового пользователя с хешированным паролем (Hash::make)
3. Редирект на страницу авторизации с success-сообщением

---

#### Авторизация пользователя

```php
public function showLoginForm()
{
    return view('auth.login');
}

public function login(LoginRequest $request)
{
    if (Auth::attempt($request->only('email', 'password'))) {
        $request->session()->regenerate();

        $user = Auth::user();
        $user->createToken('auth_token')->plainTextToken;

        return redirect()->intended('/')->with('success', 'Добро пожаловать!');
    }

    return back()->withErrors([
        'email' => 'Неверный email или пароль.',
    ])->onlyInput('email');
}
```

**Процесс авторизации:**
1. Валидация данных через LoginRequest
2. Попытка аутентификации через Auth::attempt()
3. При успехе:
   - Регенерация session ID для безопасности
   - Создание Sanctum токена для пользователя
   - Редирект на главную страницу
4. При неудаче: возврат на страницу входа с ошибкой

---

#### Выход из системы

```php
public function logout(Request $request)
{
    $user = Auth::user();

    if ($user) {
        $user->tokens()->delete();
    }

    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/')->with('success', 'Вы успешно вышли из системы.');
}
```

**Процесс выхода:**
1. Удаление всех токенов пользователя (`tokens()->delete()`)
2. Выход из системы через Auth::logout()
3. Инвалидация текущей сессии
4. Регенерация CSRF токена для безопасности
5. Редирект на главную страницу

---

### 4. Создание Blade-шаблонов

#### Шаблон регистрации

**Файл:** `resources/views/auth/register.blade.php`

```blade
<form action="{{ route('register') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Имя</label>
        <input type="text"
               class="form-control @error('name') is-invalid @enderror"
               name="name"
               value="{{ old('name') }}"
               required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email"
               class="form-control @error('email') is-invalid @enderror"
               name="email"
               value="{{ old('email') }}"
               required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input type="password"
               class="form-control @error('password') is-invalid @enderror"
               name="password"
               required>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
        <input type="password"
               class="form-control"
               name="password_confirmation"
               required>
    </div>

    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>

    <p class="text-center mt-3">
        Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a>
    </p>
</form>
```

**Особенности:**
- Поля для имени, email, пароля и подтверждения пароля
- Отображение ошибок валидации под каждым полем
- Сохранение введенных данных через old()
- Ссылка на страницу входа
- CSRF-защита

---

#### Шаблон авторизации

**Файл:** `resources/views/auth/login.blade.php`

```blade
<form action="{{ route('login') }}" method="POST">
    @csrf

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email"
               class="form-control @error('email') is-invalid @enderror"
               name="email"
               value="{{ old('email') }}"
               required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input type="password"
               class="form-control @error('password') is-invalid @enderror"
               name="password"
               required>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Войти</button>

    <p class="text-center mt-3">
        Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a>
    </p>
</form>
```

**Особенности:**
- Поля для email и пароля
- Отображение success-сообщения после регистрации
- Отображение ошибок валидации
- Ссылка на страницу регистрации
- CSRF-защита

---

### 5. Настройка маршрутов с защитой

**Файл:** `routes/web.php`

#### Маршруты для гостей (guest middleware)

```php
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
```

**Middleware 'guest':** Доступ только для неавторизованных пользователей. Авторизованные будут перенаправлены.

---

#### Маршрут выхода (требует авторизации)

```php
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth:sanctum');
```

---

#### Защищенные маршруты статей и комментариев

```php
// Доступно всем
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

// Требует авторизации
Route::middleware('auth:sanctum')->group(function () {
    // CRUD статей
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');

    // CRUD комментариев
    Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});
```

**Структура защиты:**
- Просмотр списка статей и отдельных статей - **доступно всем**
- Создание, редактирование и удаление статей - **только для авторизованных**
- Все операции с комментариями - **только для авторизованных**

**Middleware 'auth:sanctum':** Проверяет наличие валидного токена или сессии. Неавторизованных пользователей перенаправляет на страницу входа.

---

### 6. Обновление навигации

**Файл:** `resources/views/layouts/app.blade.php`

```blade
<ul class="navbar-nav ms-auto">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">Главная</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('articles.index') }}">Новости</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('about') }}">О нас</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('contacts') }}">Контакты</a>
    </li>

    @auth
        <li class="nav-item">
            <span class="nav-link">Привет, {{ Auth::user()->name }}</span>
        </li>
        <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link nav-link">Выход</button>
            </form>
        </li>
    @else
        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Вход</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
        </li>
    @endauth
</ul>
```

**Динамическая навигация:**
- Директива `@auth` проверяет авторизован ли пользователь
- Для авторизованных: приветствие с именем и кнопка выхода
- Для гостей: ссылки на вход и регистрацию

---

**Отображение success-сообщений:**

```blade
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
```

Добавлено в основной layout для отображения уведомлений после операций.

---

## Технологии и концепции

### 1. Laravel Sanctum
- **Назначение:** Легковесная система аутентификации для SPA и простых API
- **Токены:** Создание и управление API токенами для пользователей
- **Middleware:** `auth:sanctum` для защиты маршрутов
- **Trait HasApiTokens:** Добавляет методы для работы с токенами

### 2. Хеширование паролей
- `Hash::make($password)` - хеширует пароль перед сохранением
- Алгоритм bcrypt по умолчанию
- Пароли никогда не хранятся в открытом виде

### 3. Form Request Validation
- Отдельные классы для валидации (RegisterRequest, LoginRequest)
- Кастомные сообщения об ошибках на русском языке
- Автоматическая валидация перед выполнением методов контроллера

### 4. Session Management
- `$request->session()->regenerate()` - регенерирует session ID после входа
- `$request->session()->invalidate()` - инвалидирует сессию при выходе
- `$request->session()->regenerateToken()` - обновляет CSRF токен

### 5. CSRF Protection
- Директива `@csrf` в каждой форме
- Автоматическая проверка токенов Laravel
- Регенерация токенов при выходе для безопасности

### 6. Middleware
- **guest** - доступ только для неавторизованных
- **auth:sanctum** - доступ только для авторизованных
- Группировка маршрутов с общим middleware

### 7. Blade Directives
- `@auth` / `@guest` - условное отображение контента
- `@error` - отображение ошибок валидации
- `old()` - восстановление введенных данных после ошибки
- `session()` - доступ к данным сессии

---

## Безопасность

Реализованные меры безопасности:

1. **Хеширование паролей** - пароли хранятся в зашифрованном виде
2. **CSRF защита** - все формы защищены от CSRF-атак
3. **Регенерация сессий** - session ID обновляется после входа/выхода
4. **Валидация данных** - все входящие данные проходят валидацию
5. **Middleware защита** - неавторизованные пользователи не могут получить доступ к защищенным маршрутам
6. **Удаление токенов** - все токены удаляются при выходе

---

## Запуск и тестирование

```bash
# Убедитесь, что база данных настроена
php artisan migrate

# Добавьте тестовые данные (опционально)
php artisan db:seed

# Запустите сервер
php artisan serve
```

### Тестирование функционала:

1. **Регистрация:**
   - Перейдите на `/register`
   - Заполните форму регистрации
   - Проверьте редирект на страницу входа
   - Проверьте появление success-сообщения

2. **Авторизация:**
   - Перейдите на `/login`
   - Введите email и пароль
   - Проверьте редирект на главную страницу
   - Проверьте отображение имени в навигации

3. **Защищенные маршруты:**
   - Без авторизации попробуйте создать статью
   - Проверьте редирект на страницу входа
   - После авторизации проверьте доступ к созданию статей

4. **Выход:**
   - Нажмите кнопку "Выход"
   - Проверьте редирект на главную
   - Проверьте изменение навигации (появились ссылки Вход/Регистрация)

---

## Выводы

В результате выполнения задания:
- ✅ Реализована полная система аутентификации с Laravel Sanctum
- ✅ Созданы формы регистрации и авторизации с валидацией
- ✅ Настроены Request классы с кастомными сообщениями об ошибках
- ✅ Реализован безопасный выход с удалением токенов и инвалидацией сессии
- ✅ Защищены маршруты с помощью middleware auth:sanctum
- ✅ Обновлена навигация с динамическим отображением для гостей и авторизованных пользователей
- ✅ Реализованы все меры безопасности (CSRF, хеширование, регенерация сессий)
- ✅ Добавлены success-уведомления для лучшего UX

Система аутентификации полностью функциональна, безопасна и готова к использованию!
