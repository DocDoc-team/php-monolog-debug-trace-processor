<?php

namespace DocDoc\LogTraceProcessor;

class TraceFormatter
{
    protected int $ignoreFilePrefixSize = 0;

    public function __construct(string $ignorePath = '')
    {
        $path = rtrim($ignorePath, '/');
        $this->ignoreFilePrefixSize = $path ? mb_strlen($path) + 1 : 0;
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