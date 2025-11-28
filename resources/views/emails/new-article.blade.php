<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новая статья</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .email-header {
            background-color: #0d6efd;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 30px;
        }
        .article-title {
            color: #0d6efd;
            font-size: 22px;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .article-meta {
            background-color: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #0d6efd;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .article-meta p {
            margin: 5px 0;
            font-size: 14px;
            color: #6c757d;
        }
        .article-content {
            margin-bottom: 25px;
            line-height: 1.8;
            color: #495057;
        }
        .btn-primary {
            display: inline-block;
            padding: 12px 30px;
            background-color: #0d6efd;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 12px;
            border-top: 1px solid #dee2e6;
        }
        .divider {
            height: 1px;
            background-color: #dee2e6;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>📰 Новая статья опубликована</h1>
        </div>

        <div class="email-body">
            <p>Здравствуйте, уважаемый модератор!</p>

            <p>На сайте была добавлена новая статья. Вот детали:</p>

            <div class="article-title">
                {{ $article->title }}
            </div>

            <div class="article-meta">
                <p><strong>Автор:</strong> {{ $article->author }}</p>
                <p><strong>Дата публикации:</strong> {{ $article->published_at->format('d.m.Y H:i') }}</p>
                <p><strong>Дата создания:</strong> {{ $article->created_at->format('d.m.Y H:i') }}</p>
            </div>

            <div class="article-content">
                <strong>Содержание статьи:</strong>
                <p>{{ Str::limit($article->content, 300) }}</p>
            </div>

            <div class="divider"></div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('articles.show', $article->id) }}" class="btn-primary">
                    Просмотреть статью
                </a>
            </div>

            <p style="color: #6c757d; font-size: 14px; margin-top: 30px;">
                Это автоматическое уведомление о новой статье. Пожалуйста, проверьте её содержание на соответствие правилам сайта.
            </p>
        </div>

        <div class="email-footer">
            <p>© {{ date('Y') }} Мой сайт. Все права защищены.</p>
            <p>Это письмо было отправлено автоматически. Пожалуйста, не отвечайте на него.</p>
        </div>
    </div>
</body>
</html>
