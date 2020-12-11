<?php
declare(strict_types=1);

namespace DocDoc\LogTraceProcessor;

class TraceFormatter
{
    protected int $ignoreFilePrefixSize = 0;

    public function __construct(string $ignorePath = null)
    {
        $path = $this->prepareIgnorePath($ignorePath);
        $this->ignoreFilePrefixSize = $path ? mb_strlen($path) + 1 : 0;
    }

    /**
     * Игнорирует все пути до vendor директории по-умолчанию
     *
     * @return string
     */
    protected function prepareIgnorePath(string $path = null): string
    {
        if ($path === null) {
            $paths = explode('/vendor/', __DIR__, 2);
            $path = count($paths) === 1 ? dirname(__DIR__) : $paths[0];
        }

        return rtrim($path, '/');
    }

    /**
     * Преобразуем в более компактный вид трейс, для логов
     *
     * @param array[] $traces
     *
     * @return string[]
     */
    public function formatTrace(array $traces): array
    {
        return array_map(function(array $t): string {
            $file = $this->getFile($t['file'] ?? '');
            return $file . ':' . $t['line'] . ' :: ' . $t['class'] . $t['type'] . $t['function'];
        }, $traces);
    }

    protected function getFile(string $file): string
    {
        return $this->ignoreFilePrefixSize
            ? './' . mb_substr($file, $this->ignoreFilePrefixSize)
            : $file;
    }
}