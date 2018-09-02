<?php

namespace Aaronmacaron\Reaction;

use RuntimeException;
use Throwable;

class InvalidReactionTypeException extends RuntimeException
{
    /** @var $type int */
    private $type;

    /** @var $reaction Reaction */
    private $reaction;

    /**
     * InvalidReactionTypeException constructor.
     * @param int $type
     * @param Reaction $reaction
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        int $type,
        Reaction $reaction = null,
        string $message = null,
        int $code = 0,
        Throwable $previous = null
    ) {
        if ($message === null) {
            $message = "${type} is not a valid reaction type value.";
        }

        parent::__construct($message, $code, $previous);

        $this->type = $type;
        $this->reaction = $reaction;
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

    /**
     * Getter for $this->reaction
     *
     * @return Reaction
     */
    public function getReaction(): Reaction
    {
        return $this->reaction;
    }
}
