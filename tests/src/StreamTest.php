<?php declare(strict_types=1);

namespace Tests\SouthPointe\Ansi;

use AssertionError;
use SouthPointe\Ansi\Buffer;
use SouthPointe\Ansi\Stream;
use function assert;
use function fread;
use function fseek;
use function is_resource;
use function tmpfile;

class StreamTest extends TestCase
{
    /**
     * @param resource $stream
     * @return Stream
     */
    private function stream(mixed $stream): Buffer
    {
        return new Stream($stream);
    }

    public function test_clear(): void
    {
        $temp = tmpfile();
        assert(is_resource($temp));

        $buffer = $this->stream($temp)
            ->text('1')
            ->clear();

        self::assertInstanceOf(Stream::class, $buffer);
        self::assertEquals('', $buffer->toString());
    }

    public function test_flush(): void
    {
        $temp = tmpfile();
        assert(is_resource($temp));

        $buffer = $this->stream($temp)->text('1')->flush();
        fseek($temp, 0);

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals('1', fread($temp, 10));
    }

    public function test_flush_non_resource(): void
    {
        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('assert(is_resource($stream))');
        $this->stream(1)->flush();
    }

}
