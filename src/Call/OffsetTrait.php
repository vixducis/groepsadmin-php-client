<?php declare(strict_types=1);

namespace Wouterh\GroepsadminClient\Call;

trait OffsetTrait 
{
    protected int $nextOffset = 0;

    /**
     * Increases the offset with the given number
     * @param int $offset
     */
    protected function increaseOffset(int $offset): void
    {
        $this->nextOffset += $offset;
    }

    /**
     * Returns the next offset.
     * @return int
     */
    public function getNextOffset(): int
    {
        return $this->nextOffset;
    }
}