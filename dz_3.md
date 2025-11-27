# Домашнее задание 3: Система комментариев к статьям

## Описание задачи
Реализован полный функционал для работы с комментариями к статьям, включая CRUD операции, валидацию данных и каскадное удаление.

---

## Выполненные задачи

### 1. Создание модели, миграции, контроллера и фабрики

**Команда:**
```bash
php artisan make:model Comment -mcrf
```

Созданы следующие файлы:
- `app/Models/Comment.php` - модель Comment
- `database/migrations/2025_11_27_172255_create_comments_table.php` - миграция
- `app/Http/Controllers/CommentController.php` - контроллер
- `database/factories/CommentFactory.php` - фабрика

---

### 2. Миграция таблицы comments

**Файл:** `database/migrations/2025_11_27_172255_create_comments_table.php`

```php
Schema::create('comments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('article_id')->constrained('articles')->onDelete('cascade');
    $table->string('author');
    $table->text('content');
    $table->timestamps();
});
```

**Структура таблицы:**
- `id` - первичный ключ
- `article_id` - внешний ключ на таблицу articles с каскадным удалением
- `author` - имя автора комментария
- `content` - текст комментария
- `timestamps` - created_at и updated_at

**Каскадное удаление:** При удалении статьи автоматически удаляются все связанные комментарии благодаря `onDelete('cascade')`.

---

### 3. Настройка отношений между моделями

#### Модель Comment (`app/Models/Comment.php`)

```php
class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'author',
        'content',
    ];

    // Отношение: комментарий принадлежит одной статье (Many-to-One)
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
```

#### Модель Article (`app/Models/Article.php`)

```php
class Article extends Model
{
    // ... существующий код

    // Отношение: у статьи может быть много комментариев (One-to-Many)
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
```

**Тип отношений:** One-to-Many (одна статья - много комментариев)

---

### 4. Фабрика для генерации комментариев

**Файл:** `database/factories/CommentFactory.php`

```php
public function definition(): array
{
    return [
        'article_id' => \App\Models\Article::factory(),
        'author' => fake()->name(),
        'content' => fake()->paragraph(),
    ];
}
```

Фабрика генерирует случайные данные:
- `author` - случайное имя
- `content` - случайный параграф текста
- `article_id` - автоматически создает связанную статью

---

### 5. Обновление сидера

**Файл:** `database/seeders/DatabaseSeeder.php`

```php
public function run(): void
{
    \App\Models\Article::factory(10)->create()->each(function ($article) {
        \App\Models\Comment::factory(rand(2, 5))->create([
            'article_id' => $article->id
        ]);
    });
}
```

Создается:
- 10 статей
- К каждой статье добавляется от 2 до 5 случайных комментариев

---

### 6. Валидация данных комментариев

**Файл:** `app/Http/Requests/CommentRequest.php`

```php
public function rules(): array
{
    return [
        'author' => 'required|string|max:255',
        'content' => 'required|string|min:3',
    ];
}

public function messages(): array
{
    return [
        'author.required' => 'Имя автора обязательно для заполнения',
        'author.max' => 'Имя автора не должно превышать 255 символов',
        'content.required' => 'Текст комментария обязателен для заполнения',
        'content.min' => 'Комментарий должен быть не менее 3 символов',
    ];
}
```

**Правила валидации:**
- `author`: обязательное поле, строка, максимум 255 символов
- `content`: обязательное поле, строка, минимум 3 символа

---

### 7. CRUD методы в CommentController

**Файл:** `app/Http/Controllers/CommentController.php`

#### Создание комментария (Create)
```php
public function store(CommentRequest $request, Article $article)
{
    $article->comments()->create($request->validated());
    return redirect()->route('articles.show', $article->id)
        ->with('success', 'Комментарий успешно добавлен!');
}
```

#### Обновление комментария (Update)
```php
public function update(CommentRequest $request, Comment $comment)
{
    $comment->update($request->validated());
    return redirect()->route('articles.show', $comment->article_id)
        ->with('success', 'Комментарий успешно обновлен!');
}
```

#### Удаление комментария (Delete)
```php
public function destroy(Comment $comment)
{
    $articleId = $comment->article_id;
    $comment->delete();
    return redirect()->route('articles.show', $articleId)
        ->with('success', 'Комментарий успешно удален!');
}
```

**Особенности:**
- Используется Route Model Binding для автоматической подгрузки моделей
- Валидация выполняется через CommentRequest
- После каждой операции происходит редирект обратно на страницу статьи
- Добавлены success-сообщения для пользователя

---

### 8. Маршруты для комментариев

**Файл:** `routes/web.php`

```php
// Создание комментария
Route::post('/articles/{article}/comments', [CommentController::class, 'store'])
    ->name('comments.store');

// Обновление комментария
Route::put('/comments/{comment}', [CommentController::class, 'update'])
    ->name('comments.update');

// Удаление комментария
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
    ->name('comments.destroy');
```

**Структура маршрутов:**
- `POST /articles/{article}/comments` - добавление комментария к статье
- `PUT /comments/{comment}` - обновление комментария
- `DELETE /comments/{comment}` - удаление комментария

---

### 9. Blade-шаблон для отображения комментариев

**Файл:** `resources/views/articles/show.blade.php`

Добавлен раздел с комментариями, который включает:

#### Форма добавления комментария
```blade
<form action="{{ route('comments.store', $article->id) }}" method="POST">
    @csrf
    <input type="text" name="author" required>
    <textarea name="content" rows="3" required></textarea>
    <button type="submit">Добавить комментарий</button>
</form>
```

#### Список комментариев
```blade
@forelse($article->comments()->latest()->get() as $comment)
    <div class="card">
        <h6>{{ $comment->author }}</h6>
        <p>{{ $comment->content }}</p>
        <small>{{ $comment->created_at->format('d.m.Y H:i') }}</small>

        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Удалить</button>
        </form>
    </div>
@empty
    <p>Пока нет комментариев. Будьте первым!</p>
@endforelse
```

**Функционал:**
- Отображение количества комментариев в заголовке
- Форма для добавления нового комментария с валидацией
- Список всех комментариев (от новых к старым)
- Кнопка удаления для каждого комментария с подтверждением
- Сообщение, если комментариев нет
- Success-уведомления после операций
- CSRF-защита для всех форм

---

### 10. Каскадное удаление комментариев

**Реализация:**

Каскадное удаление настроено на уровне базы данных в миграции:

```php
$table->foreignId('article_id')
    ->constrained('articles')
    ->onDelete('cascade');
```

**Принцип работы:**
- При удалении статьи автоматически удаляются все связанные комментарии
- Не требуется дополнительный код в контроллере
- База данных сама следит за целостностью данных

**Проверка:**
1. Создайте статью с комментариями
2. Удалите статью
3. Комментарии автоматически удалятся из базы данных

---

## Технологии и концепции

### 1. Eloquent ORM
- Использованы отношения `hasMany` и `belongsTo`
- Route Model Binding для автоматической подгрузки моделей
- Методы `create()`, `update()`, `delete()`

### 2. Валидация
- Form Request класс (CommentRequest)
- Кастомные сообщения об ошибках на русском языке
- Отображение ошибок в Blade-шаблонах

### 3. Миграции
- Внешние ключи с каскадным удалением
- Правильная структура таблиц

### 4. Фабрики и сидеры
- Автоматическая генерация тестовых данных
- Использование Faker для реалистичных данных

### 5. Blade-шаблоны
- Директивы @csrf, @method
- Условные операторы @if, @forelse
- Отображение ошибок валидации
- Success-уведомления

### 6. RESTful маршруты
- Правильное использование HTTP методов (POST, PUT, DELETE)
- Именованные маршруты для удобства

---

## Запуск проекта

```bash
# Обновить базу данных с тестовыми данными
php artisan migrate:fresh --seed

# Запустить сервер
php artisan serve
```

После запуска:
1. Перейдите на страницу новостей
2. Откройте любую статью
3. Прокрутите вниз до раздела комментариев
4. Попробуйте добавить, просмотреть и удалить комментарии

---

## Выводы

В результате выполнения задания:
- ✅ Реализован полный CRUD функционал для комментариев
- ✅ Настроены отношения между моделями Article и Comment
- ✅ Добавлена валидация данных с кастомными сообщениями
- ✅ Реализовано каскадное удаление комментариев при удалении статьи
- ✅ Создан удобный пользовательский интерфейс для работы с комментариями
- ✅ Все операции защищены CSRF-токенами
- ✅ Добавлены фабрики и сидеры для тестовых данных

Система комментариев полностью функциональна и готова к использованию!
