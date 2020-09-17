<?php

namespace DocDoc\LogTraceProcessor;

use Monolog\Logger;
use Monolog\Processor\ProcessorInterface;

class TraceProcessor implements ProcessorInterface
{
    protected int $level = Logger::WARNING;
    protected int $skipLast = 3;
    protected int $traceLimit = 20;
    protected TraceFormatter $traceFormatter;

    public function __construct(
        TraceFormatter $traceFormatter,
        int $level = Logger::WARNING,
        int $skipLast = 3,
        int $traceLimit = 20
    ) {
        $this->traceFormatter = $traceFormatter;
        $this->level = $level;
        $this->skipLast = $skipLast;
        $this->traceLimit = $traceLimit;
    }

    /**
     * @inheritdoc
     */
    public function __invoke(array $record)
    {
        if ($record['level'] >= $this->level) {
            $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $this->traceLimit);
            for ($i = 0; $i < $this->skipLast; $i++) {
                count($trace) && array_shift($trace);
            }

            $record['extra']['debug_trace'] = $this->traceFormatter->formatTrace($trace);
        }

        return $record;
    }
}