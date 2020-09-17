# monolog debug trace processor

Процесор для логера monolog, добавляет к логу компактный trace для отладки
Пример как выглядит такой лог в kibana:

```js
  "_index": "xxx-2020.09.17",
  "_id": "xxx",
  "_source": {
    "host": "xxx",
    "short_message": "Ошибка валидации ответа по json схеме",
    "level": 3,
    "extra": {
      "debug_trace": [
        "./xxx/xxx/JsonSchemaResponse.php:57 :: xxx\\Logger->error",
        "./xxx/xxx/JsonSchemaResponse.php:40 :: xxx\\xxx\\JsonSchemaResponse->checkResponse",
        "./vendor/relay/relay/src/Runner.php:31 :: xxx\\xxx\\JsonSchemaResponse->process",
        "./src/middlewares/InfluxTime.php:37 :: xxx\\Runner->handle",
        "./xxx/xxx/xxx/xxx/Runner.php:31 :: xxx\\xxx\\InfluxTime->process",
        "./xxx/xxx/xxx/xxx/Relay.php:22 :: xxx\\Runner->handle",
        "./src/KernelPsr15.php:59 :: Relay\\Relay->handle",
        "./public/index.php:8 :: App\\KernelPsr15->run"
      ],
    },
  }
}
```

Процессор раскладывает исключение в ключ `debug_trace` в extra данные монолога.

### Настройки

Процессор имеет настройки. Чтобы минимизировать лог, все пути могут быть указаны относительно определенной директории, например корня проекта.

```js
"extra": {
  "debug_trace": [
    "./src/JsonSchemaResponse.php:57 :: xxx\\Logger->error",
    "...",
  ],
}
```

Вместо абсолютных путей:

```js
"extra": {
  "debug_trace": [
    "/var/www/project/src/JsonSchemaResponse.php:57 :: xxx\\Logger->error",
    "...",
  ],
}
```


