<?php

declare(strict_types=1);

namespace SlimAPI\DataStructure;

use Countable;
use Generator;
use InvalidArgumentException;
use LogicException;
use SlimAPI\DataStructure\SortedLinkedList\Direction;
use SlimAPI\DataStructure\SortedLinkedList\Node;
use SlimAPI\DataStructure\Tests\SortedLinkedListTest;

/**
 * @see SortedLinkedListTest
 */
class SortedLinkedList implements Countable
{
    private ?Node $head = null;

    private int $length = 0;

    public function __construct(private readonly Direction $sorting = Direction::ASC)
    {
    }

    public function insert(mixed $value): self
    {
        $this->validateInput($value);
        $node = new Node($value);

        // If the list is empty, set the new node as the head.
        if ($this->head === null) {
            $this->head = $node;
            $this->length++;
            return $this;
        }

        // If the new value is smaller than the head value, insert it at the beginning of the list.
        if ($this->compare($this->head->value, $value)) {
            $node->next = $this->head;
            $this->head = $node;
            $this->length++;
            return $this;
        }

        // Traverse the list to find the correct position for the new node.
        $currentNode = $this->head;
        while ($currentNode->next !== null && $this->compare($value, $currentNode->next->value)) {
            $currentNode = $currentNode->next;
        }

        $node->next = $currentNode->next;
        $currentNode->next = $node;

        $this->length++;
        return $this;
    }

    public function remove(mixed $value): self
    {
        // If the list is empty, we cannot remove anything.
        if ($this->head === null) {
            throw new InvalidArgumentException('Cannot remove from an empty list.');
        }

        // If the list has only one element, and it matches the value, simply remove the head.
        if ($this->head->value === $value) {
            $this->head = $this->head->next;
            $this->length--;
            return $this;
        }

        // Traverse the list and look for the node to remove.
        $currentNode = $this->head;
        while ($currentNode->next !== null) {
            if ($currentNode->next->value === $value) {
                // If we find the node that matches the value, remove it.
                $currentNode->next = $currentNode->next->next;
                $this->length--;
                return $this;
            }
            $currentNode = $currentNode->next;
        }

        throw new InvalidArgumentException(sprintf('Value [%s] not found in the list.', var_export($value, true)));
    }

    /**
     * @return mixed[]
     */
    public function toArray(): array
    {
        $data = [];
        $currentNode = $this->head;
        while ($currentNode !== null) {
            $data[] = $currentNode->value;
            $currentNode = $currentNode->next;
        }

        return $data;
    }

    public function toGenerator(): Generator
    {
        $currentNode = $this->head;
        while ($currentNode !== null) {
            yield $currentNode->value;
            $currentNode = $currentNode->next;
        }
    }

    public function count(): int
    {
        return $this->length;
    }

    protected function compare(mixed $a, mixed $b): bool
    {
        return match (get_debug_type($a)) {
            'int' => $this->sorting === Direction::ASC
                ? $a > $b
                : $a < $b,
            'string' => $this->sorting === Direction::ASC
                ? strcmp($a, $b) > 0
                : strcmp($a, $b) < 0,
            default => throw new LogicException(sprintf('Comparison for type "%s" is not implemented.', get_debug_type($a))),
        };
    }

    private function validateInput(mixed $value): void
    {
        if ($this->head === null) {
            return;
        }

        $currentType = get_debug_type($value);
        $expectedType = get_debug_type($this->head->value);
        if ($currentType !== $expectedType) {
            throw new InvalidArgumentException(
                sprintf(
                    'The value must be of type "%s", but "%s" was given.',
                    $expectedType,
                    $currentType,
                ),
            );
        }
    }
}
