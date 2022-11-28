<?php declare(strict_types=1);

namespace SouthPointe\Ansi;

use function assert;
use function fopen;
use function fwrite;
use function is_resource;

class Stream extends Buffer
{
    /**
     * @var resource
     */
    protected $stream;

    /**
     * @param resource|null $stream
     */
    public function __construct(mixed $stream = null)
    {
        $stream ??= fopen('php://stdout', 'w');
        assert(is_resource($stream));
        $this->stream = $stream;
    }

    /**
     * Flushes the buffer to set resource.
     *
     * @return $this
     */
    public function flush(): static
    {
        fwrite($this->stream, $this->toString());
        return $this->clear();
    }
}
