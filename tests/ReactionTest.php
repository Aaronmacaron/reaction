<?php

namespace Aaronmacaron\Reaction\Tests;

use Aaronmacaron\Reaction\InvalidReactionTypeException;
use Aaronmacaron\Reaction\Reaction;
use PHPUnit\Framework\TestCase;

class ReactionTest extends TestCase
{

    public function testFailure()
    {
        try {
            $failure = Reaction::failure();
        } catch (InvalidReactionTypeException $e) {
            $this->fail("Unexpected InvalidReactionTypeException thrown" . $e->getMessage());
            return;
        }

        $this->assertInstanceOf(Reaction::class, $failure);
        $this->assertTrue($failure->isFailure());
        $this->assertFalse($failure->isSuccess());
        $this->assertEquals('', $failure->getMessage());
    }

    public function testFailureWithMessage()
    {
        $message = 'message';

        try {
            $failure = Reaction::failure($message);
        } catch (InvalidReactionTypeException $e) {
            $this->fail("Unexpected InvalidReactionTypeException thrown" . $e->getMessage());
            return;
        }

        $this->assertEquals($message, $failure->getMessage());
    }

    public function testFail()
    {
        $message = 'message';

        try {
            $failure = Reaction::failure($message);
        } catch (InvalidReactionTypeException $e) {
            $this->fail("Unexpected InvalidReactionTypeException thrown" . $e->getMessage());
            return;
        }

        $executorIsExecuted = false;

        $newReaction = $failure->fail(function (Reaction $reaction) use (&$executorIsExecuted, $message) {
            $executorIsExecuted = true;

            $this->assertNotNull($reaction);
            $this->assertTrue($reaction->isFailure());
            $this->assertEquals($message, $reaction->getMessage());
        });

        $this->assertEquals($failure, $newReaction);

        $this->assertTrue($executorIsExecuted, 'Executor should have been executed at this point.');
    }

    public function testSucceedIsNotExecutedOnFail()
    {
        try {
            $failure = Reaction::failure();
        } catch (InvalidReactionTypeException $e) {
            $this->fail("Unexpected InvalidReactionTypeException thrown" . $e->getMessage());
            return;
        }

        $newReaction = $failure->succeed(function (Reaction $reaction) {
            $this->assertNotNull($reaction);
            $this->fail("The succeed executor shouldn't be executed on failure.");
        });

        $this->assertEquals($failure, $newReaction);
    }

    public function test__construct()
    {
        $message = 'message';
        try {
            $reaction = new Reaction($message, Reaction::SUCCESS);
        } catch (InvalidReactionTypeException $e) {
            $this->fail("Unexpected InvalidReactionTypeException thrown" . $e->getMessage());
            return;
        }

        $this->assertInstanceOf(Reaction::class, $reaction);
    }

    public function test__constructThrowsExceptionIfInvalidTypeIsPassed()
    {
        $message = 'message';
        try {
            new Reaction($message, -1);
        } catch (InvalidReactionTypeException $e) {
            $this->assertNotNull($e);
            return;
        }

        $this->fail("The test should throw a new InvalidReactionTypeException.");
    }

    public function testSucceed()
    {
        $message = 'message';

        try {
            $failure = Reaction::success($message);
        } catch (InvalidReactionTypeException $e) {
            $this->fail("Unexpected InvalidReactionTypeException thrown" . $e->getMessage());
            return;
        }

        $executorIsExecuted = false;

        $failure->succeed(function (Reaction $reaction) use (&$executorIsExecuted, $message) {
            $executorIsExecuted = true;

            $this->assertNotNull($reaction);
            $this->assertTrue($reaction->isSuccess());
            $this->assertEquals($message, $reaction->getMessage());
        });

        $this->assertTrue($executorIsExecuted, 'Executor should have been executed at this point.');
    }

    public function testFailIsNotExecutedOnSuccess()
    {
        try {
            $success = Reaction::success();
        } catch (InvalidReactionTypeException $e) {
            $this->fail("Unexpected InvalidReactionTypeException thrown" . $e->getMessage());
            return;
        }

        $newReaction = $success->fail(function (Reaction $reaction) {
            $this->assertNotNull($reaction);
            $this->fail("The succeed executor shouldn't be executed on failure.");
        });

        $this->assertEquals($success, $newReaction);
    }

    public function testIsFailure()
    {
        try {
            $failure = Reaction::failure();
        } catch (InvalidReactionTypeException $e) {
            $this->fail("Unexpected InvalidReactionTypeException thrown" . $e->getMessage());
            return;
        }

        $this->assertTrue($failure->isFailure());
        $this->assertFalse($failure->isSuccess());
    }

    public function testIsSuccess()
    {
        try {
            $success = Reaction::success();
        } catch (InvalidReactionTypeException $e) {
            $this->fail("Unexpected InvalidReactionTypeException thrown" . $e->getMessage());
            return;
        }

        $this->assertTrue($success->isSuccess());
        $this->assertFalse($success->isFailure());
    }

    public function testSuccess()
    {
        $message = 'message';

        try {
            $success = Reaction::success($message);
        } catch (InvalidReactionTypeException $e) {
            $this->fail("Unexpected InvalidReactionTypeException thrown" . $e->getMessage());
            return;
        }

        $executorIsExecuted = false;

        $newReaction = $success->succeed(function (Reaction $reaction) use (&$executorIsExecuted, $message) {
            $executorIsExecuted = true;

            $this->assertNotNull($reaction);
            $this->assertTrue($reaction->isSuccess());
            $this->assertEquals($message, $reaction->getMessage());
        });

        $this->assertEquals($success, $newReaction);

        $this->assertTrue($executorIsExecuted, 'Executor should have been executed at this point.');
    }

    public function testGetMessage()
    {
        $message = 'message';
        try {
            $reaction = new Reaction($message, Reaction::SUCCESS);
        } catch (InvalidReactionTypeException $e) {
            $this->fail("Unexpected InvalidReactionTypeException thrown" . $e->getMessage());
            return;
        }

        $this->assertEquals($message, $reaction->getMessage());
    }

    public function testGetMessageWithEmptyMessage()
    {
        try {
            $success = Reaction::success();
        } catch (InvalidReactionTypeException $e) {
            $this->fail("Unexpected InvalidReactionTypeException thrown" . $e->getMessage());
            return;
        }

        $this->assertEquals('', $success->getMessage());
    }

    public function testGetType() {
        $type = Reaction::SUCCESS;

        try {
            $success = new Reaction('message', $type);
        } catch (InvalidReactionTypeException $e) {
            $this->fail("Unexpected InvalidReactionTypeException thrown" . $e->getMessage());
            return;
        }

        $this->assertEquals($type, $success->getType());
    }

}
