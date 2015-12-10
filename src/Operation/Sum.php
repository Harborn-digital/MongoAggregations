<?php

namespace ConnectHolland\MongoAggregations\Operation;

/**
 * Operation to $sum in the $group stage.
 *
 * @author Ron Rademaker
 */
class Sum extends AbstractOperation implements GroupOperationInterface
{
    /**
     * Creates a new condition.
     */
    public function __construct()
    {
        $this->setOperationType('$sum');
    }

    /**
     * Sets the value to sum.
     *
     * @param mixed $sum
     */
    public function setSum($sum)
    {
        if ($sum instanceof OperationInterface) {
            $this->setArguments($sum->getOperation());
        } else {
            $this->setArguments($sum);
        }
    }
}
