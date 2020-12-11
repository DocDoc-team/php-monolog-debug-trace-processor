<?php
declare(strict_types=1);

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
            './vendor/phpunit/phpunit/src/Framework/TestCase.php:1526 :: TraceFormatterTest->testFormatter',
            './vendor/phpunit/phpunit/src/Framework/TestCase.php:1132 :: PHPUnit\Framework\TestCase->runTest',
            './vendor/phpunit/phpunit/src/Framework/TestResult.php:722 :: PHPUnit\Framework\TestCase->runBare',
            './vendor/phpunit/phpunit/src/Framework/TestCase.php:884 :: PHPUnit\Framework\TestResult->run',
            './vendor/phpunit/phpunit/src/Framework/TestSuite.php:677 :: PHPUnit\Framework\TestCase->run',
            './vendor/phpunit/phpunit/src/Framework/TestSuite.php:677 :: PHPUnit\Framework\TestSuite->run',
            './vendor/phpunit/phpunit/src/Framework/TestSuite.php:677 :: PHPUnit\Framework\TestSuite->run',
            './vendor/phpunit/phpunit/src/TextUI/TestRunner.php:667 :: PHPUnit\Framework\TestSuite->run',
            './vendor/phpunit/phpunit/src/TextUI/Command.php:142 :: PHPUnit\TextUI\TestRunner->run',
            './vendor/phpunit/phpunit/src/TextUI/Command.php:95 :: PHPUnit\TextUI\Command->run',
            './vendor/phpunit/phpunit/phpunit:61 :: PHPUnit\TextUI\Command::main',
        ];

        static::assertSame($expected, $actual);
    }

    public function testFormatterDefaultIgnoreDir(): void
    {
        $formatter = new TraceFormatter;

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $actual = $formatter->formatTrace($trace);

        $expected = [
            './vendor/phpunit/phpunit/src/Framework/TestCase.php:1526 :: TraceFormatterTest->testFormatterDefaultIgnoreDir',
            './vendor/phpunit/phpunit/src/Framework/TestCase.php:1132 :: PHPUnit\Framework\TestCase->runTest',
            './vendor/phpunit/phpunit/src/Framework/TestResult.php:722 :: PHPUnit\Framework\TestCase->runBare',
            './vendor/phpunit/phpunit/src/Framework/TestCase.php:884 :: PHPUnit\Framework\TestResult->run',
            './vendor/phpunit/phpunit/src/Framework/TestSuite.php:677 :: PHPUnit\Framework\TestCase->run',
            './vendor/phpunit/phpunit/src/Framework/TestSuite.php:677 :: PHPUnit\Framework\TestSuite->run',
            './vendor/phpunit/phpunit/src/Framework/TestSuite.php:677 :: PHPUnit\Framework\TestSuite->run',
            './vendor/phpunit/phpunit/src/TextUI/TestRunner.php:667 :: PHPUnit\Framework\TestSuite->run',
            './vendor/phpunit/phpunit/src/TextUI/Command.php:142 :: PHPUnit\TextUI\TestRunner->run',
            './vendor/phpunit/phpunit/src/TextUI/Command.php:95 :: PHPUnit\TextUI\Command->run',
            './vendor/phpunit/phpunit/phpunit:61 :: PHPUnit\TextUI\Command::main',
        ];

        static::assertSame($expected, $actual);
    }

}
