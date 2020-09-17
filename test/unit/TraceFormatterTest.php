<?php

use DocDoc\LogTraceProcessor\TraceFormatter;
use PHPUnit\Framework\TestCase;

class TraceFormatterTest extends TestCase
{
    protected TraceFormatterTest $formatter;

    public function testFormatter(): void
    {
        $relDir = dirname(__DIR__, 2);
        $formatter = new TraceFormatter($relDir);

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $actual = $formatter->formatTrace($trace);

        $expected = [
            './vendor/phpunit/phpunit/src/Framework/TestCase.php:1533 :: TraceFormatterTest->testFormatter',
            './vendor/phpunit/phpunit/src/Framework/TestCase.php:1139 :: PHPUnit\Framework\TestCase->runTest',
            './vendor/phpunit/phpunit/src/Framework/TestResult.php:730 :: PHPUnit\Framework\TestCase->runBare',
            './vendor/phpunit/phpunit/src/Framework/TestCase.php:880 :: PHPUnit\Framework\TestResult->run',
            './vendor/phpunit/phpunit/src/Framework/TestSuite.php:665 :: PHPUnit\Framework\TestCase->run',
            './vendor/phpunit/phpunit/src/Framework/TestSuite.php:665 :: PHPUnit\Framework\TestSuite->run',
            './vendor/phpunit/phpunit/src/Framework/TestSuite.php:665 :: PHPUnit\Framework\TestSuite->run',
            './vendor/phpunit/phpunit/src/TextUI/TestRunner.php:671 :: PHPUnit\Framework\TestSuite->run',
            './vendor/phpunit/phpunit/src/TextUI/Command.php:148 :: PHPUnit\TextUI\TestRunner->run',
            './vendor/phpunit/phpunit/src/TextUI/Command.php:101 :: PHPUnit\TextUI\Command->run',
            './vendor/phpunit/phpunit/phpunit:61 :: PHPUnit\TextUI\Command::main',
        ];

        static::assertSame($expected, $actual);
    }

}
