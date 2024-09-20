<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .title {
            text-align: center;
        }
    </style>
</head>
<body>
<div>
    <div>Вопрос</div>
    <div>{{$question}}</div>
    <br>
    <br>
    <div>Ответ</div>
    <div>{{$answer}}</div>
</div>
</body>
</html>
