<?php

declare(strict_types=1);

namespace SlimAPI\DataStructure\Tests;

use PHPUnit\Framework\TestCase;
use SlimAPI\DataStructure\SortedLinkedList;

class SortedLinkedListTest extends TestCase
{
    public function testInsert(): void
    {
        $list = new SortedLinkedList()
            ->insert();

        self::assertTrue($list);
    }
}
