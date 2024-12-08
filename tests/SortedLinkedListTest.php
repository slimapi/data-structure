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

    public function testInsertDuplicate(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('That value already exists.');

        new SortedLinkedList()
            ->insert('apple')
            ->insert('apple');
    }

    public function testRemove(): void
    {
        $list = new SortedLinkedList()
            ->insert(2)
            ->insert(1)
            ->insert(3)
            ->remove(2);

        self::assertEquals([1, 3], $list->toArray());
    }

    public function testToGenerator(): void
    {
        $list = new SortedLinkedList()
            ->insert('banana')
            ->insert('grace')
            ->insert('apple');

        $expected = ['apple', 'banana', 'grace'];
        $actual = [];
        foreach ($list->toGenerator() as $value) {
            $actual[] = $value;
        }

        self::assertEquals($expected, $actual, 'The generator should yield values in the correct order.');
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

    public function testRemoveLengthZero(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Cannot remove from an empty list.');

        new SortedLinkedList()
            ->remove(0);
    }

    public function testRemoveLengthOne(): void
    {
        $list = new SortedLinkedList()
            ->insert(0);

        self::assertCount(1, $list);

        $list->remove(0);

        self::assertCount(0, $list);
    }

    public function testRemoveUnknown(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage("Value ['apple'] not found in the list.");

        new SortedLinkedList()
            ->insert('banana')
            ->remove('apple');
    }

    public function testRemoveLast(): void
    {
        $list = new SortedLinkedList()
            ->insert(2)
            ->insert(1)
            ->insert(3)
            ->remove(3);

        self::assertEquals([1, 2], $list->toArray());
    }
}
