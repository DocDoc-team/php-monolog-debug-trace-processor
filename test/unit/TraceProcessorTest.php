<?php
declare(strict_types=1);

use DocDoc\LogTraceProcessor\TraceFormatter;
use DocDoc\LogTraceProcessor\TraceProcessor;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;

class TraceProcessorTest extends TestCase
{
    protected TraceFormatterTest $formatter;

    /**
     * @param array $expected
     * @param int $level
     * @param int $skipLast
     * @param int $traceLimit
     *
     * @dataProvider processorProvider
     */
    public function testProcessor(
        array $expected,
        $level = Logger::WARNING,
        int $skipLast = 0,
        int $traceLimit = 0
    ): void {
        $relDir = dirname(__DIR__, 2);
        $processor = new TraceProcessor(new TraceFormatter($relDir), $level, $skipLast, $traceLimit);

        $record = [
            'level' => Logger::WARNING,
            'message' => 'test message',
        ];

        $expected = array_merge($record, $expected);
        $recordAfter = $processor($record);
        static::assertSame($expected, $recordAfter);
    }

    public function processorProvider(): array
    {
        $trace = [
            './test/unit/TraceProcessorTest.php:36 :: DocDoc\LogTraceProcessor\TraceProcessor->__invoke',
            './vendor/phpunit/phpunit/src/Framework/TestCase.php:1526 :: TraceProcessorTest->testProcessor',
            './vendor/phpunit/phpunit/src/Framework/TestCase.php:1132 :: PHPUnit\Framework\TestCase->runTest',
            './vendor/phpunit/phpunit/src/Framework/TestResult.php:722 :: PHPUnit\Framework\TestCase->runBare',
            './vendor/phpunit/phpunit/src/Framework/TestCase.php:884 :: PHPUnit\Framework\TestResult->run',
            './vendor/phpunit/phpunit/src/Framework/TestSuite.php:677 :: PHPUnit\Framework\TestCase->run',
            './vendor/phpunit/phpunit/src/Framework/TestSuite.php:677 :: PHPUnit\Framework\TestSuite->run',
            './vendor/phpunit/phpunit/src/Framework/TestSuite.php:677 :: PHPUnit\Framework\TestSuite->run',
            './vendor/phpunit/phpunit/src/Framework/TestSuite.php:677 :: PHPUnit\Framework\TestSuite->run',
            './vendor/phpunit/phpunit/src/TextUI/TestRunner.php:667 :: PHPUnit\Framework\TestSuite->run',
            './vendor/phpunit/phpunit/src/TextUI/Command.php:142 :: PHPUnit\TextUI\TestRunner->run',
            './vendor/phpunit/phpunit/src/TextUI/Command.php:95 :: PHPUnit\TextUI\Command->run',
            './vendor/phpunit/phpunit/phpunit:61 :: PHPUnit\TextUI\Command::main',
        ];

        return [
            [
                [
                    'extra' => [
                        'debug_trace' => $trace,
                    ],
                ],
                Logger::WARNING,
                0,
                0,
            ],
            'with skip' => [
                [
                    'extra' => [
                        'debug_trace' => array_slice($trace, 2),
                    ],
                ],
                Logger::WARNING,
                2,
                0,
            ],
            'with limit' => [
                [
                    'extra' => [
                        'debug_trace' => array_slice($trace, 0, 2),
                    ],
                ],
                Logger::WARNING,
                0,
                2,
            ],
            'with limit + skip' => [
                [
                    'extra' => [
                        'debug_trace' => array_slice($trace, 1, 6 - 1),
                    ],
                ],
                Logger::WARNING,
                1,
                6,
            ],
        ];
    }

}
