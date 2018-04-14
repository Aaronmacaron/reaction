<?php

use Aaronmacaron\Reaction\InvalidReactionTypeException;
use Aaronmacaron\Reaction\Reaction;
use PHPUnit\Framework\TestCase;

class InvalidReactionTypeExceptionTest extends TestCase
{

    public function testGetType()
    {
        try {
            $reaction = Reaction::success();
        } catch (InvalidReactionTypeException $e) {
            $this->fail("Unexpected InvalidReactionTypeException thrown" . $e->getMessage());
            return;
        }

        $e = new InvalidReactionTypeException($reaction->getType(), $reaction);
        $this->assertEquals($reaction->getType(), $e->getType());
    }

    public function testGetReaction()
    {
        try {
            $reaction = Reaction::success();
        } catch (InvalidReactionTypeException $e) {
            $this->fail("Unexpected InvalidReactionTypeException thrown" . $e->getMessage());
            return;
        }

        $e = new InvalidReactionTypeException($reaction->getType(), $reaction);
        $this->assertEquals($reaction, $e->getReaction());
    }

    public function test__construct()
    {
        try {
            $reaction = Reaction::success();
        } catch (InvalidReactionTypeException $e) {
            $this->fail("Unexpected InvalidReactionTypeException thrown" . $e->getMessage());
            return;
        }

        $e = new InvalidReactionTypeException($reaction->getType(), $reaction);
        $this->assertNotNull($e);
        $this->assertInstanceOf(Exception::class, $e);
    }
}
