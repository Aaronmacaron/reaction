<?php

namespace Aaronmacaron\Reaction;

/**
 * Class Reaction
 * A Reaction represents a response object of any action. A Reaction can be succeed or fail.
 * You should use Reactions when a negative response is expected and you want to provide a message to the response.
 *
 * @package Aaronmacaron\Reaction
 */
class Reaction
{
    /** @var int */
    const SUCCESS = 1;

    /** @var int */
    const FAILURE = 2;

    /** @var $message string */
    private $message;

    /** @var $type int */
    private $type;

    /**
     * Reaction constructor.
     *
     * @param $message
     * @param $type
     */
    public function __construct(string $message, int $type)
    {
        $this->message = $message;

        if (!$this->isValidType($type)) {
            throw new InvalidReactionTypeException($type, $this);
        }
        $this->type = $type;
    }

    /**
     * This method registers an executor that will be executed on success.
     *
     * @param callable $executor The executor is executed on success.
     * @return Reaction The same Reaction that is used for method chaining.
     */
    public function succeed(callable $executor): Reaction
    {
        if ($this->isSuccess()) {
            $executor($this);
        }

        return $this;
    }

    /**
     * This method registers an executor that will be executed on failure.
     *
     * @param callable $executor The executor is executed on failure.
     * @return Reaction The same Reaction that is used for method chaining.
     */
    public function fail(callable $executor): Reaction
    {
        if ($this->isFailure()) {
            $executor($this);
        }

        return $this;
    }

    /**
     * Checks if reaction is success.
     *
     * @return bool Returns true if reaction is of type success.
     */
    public function isSuccess(): bool
    {
        return $this->type === Reaction::SUCCESS;
    }

    /**
     * Checks if reaction is failure.
     *
     * @return bool Returns true if reaction is of type failure.
     */
    public function isFailure(): bool
    {
        return $this->type === Reaction::FAILURE;
    }

    /**
     * Generates new success reaction.
     *
     * @param string $message The message of the reaction
     * @return Reaction The newly generated reaction.
     */
    public static function success($message = ''): Reaction
    {
        return new Reaction($message, Reaction::SUCCESS);
    }

    /**
     * Generates new failure reaction.
     *
     * @param string $message The message of the reaction
     * @return Reaction The newly generated reaction.
     */
    public static function failure($message = ''): Reaction
    {
        return new Reaction($message, Reaction::FAILURE);
    }

    /**
     * Checks if integer is a valid reaction type.
     *
     * @param int $type The type to check.
     * @return bool True if type is valid.
     */
    private function isValidType(int $type): bool
    {
        $validTypes = [
            Reaction::SUCCESS,
            Reaction::FAILURE,
        ];

        return in_array($type, $validTypes);
    }

    /**
     * Getter for $this->message
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Getter for $this->type
     *
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }
}
