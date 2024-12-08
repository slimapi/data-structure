<?php

declare(strict_types=1);

namespace SlimAPI\DataStructure\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use SlimAPI\DataStructure\SortedLinkedList;
use SlimAPI\DataStructure\SortedLinkedList\Direction;

class SortedLinkedListTest extends TestCase
{
    public function testInsertIntAsc(): void
    {
        $list = new SortedLinkedList()
            ->insert(2)
            ->insert(1)
            ->insert(3);

        self::assertEquals([1, 2, 3], $list->toArray());
    }

    public function testInsertIntDesc(): void
    {
        $list = new SortedLinkedList(Direction::DESC)
            ->insert(2)
            ->insert(1)
            ->insert(3);

        self::assertEquals([3, 2, 1], $list->toArray());
    }

    public function testInsertStringAsc(): void
    {
        $list = new SortedLinkedList()
            ->insert('banana')
            ->insert('grace')
            ->insert('apple');

        self::assertEquals(['apple', 'banana', 'grace'], $list->toArray());
    }

    public function testInsertStringDesc(): void
    {
        $list = new SortedLinkedList(Direction::DESC)
            ->insert('banana')
            ->insert('grace')
            ->insert('apple');

        self::assertEquals(['grace', 'banana', 'apple'], $list->toArray());
    }

    // ******************
    // *** EDGE CASES ***
    // ******************

    public function testInsertMixedInput(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('The value must be of type "string", but "int" was given.');

        $list = new SortedLinkedList();
        $list->insert('banana');
        $list->insert(3);
    }
}
