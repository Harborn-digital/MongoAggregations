<?php

namespace ConnectHolland\MongoAggregations\Operation;

/**
 * Operation to push results in the group stage.
 *
 * @author Ron Rademaker
 */
class Push extends AbstractOperation implements GroupOperationInterface
{
    /**
     * Creates a new condition.
     */
    public function __construct()
    {
        $this->setOperationType('$push');
    }

    /**
     * Sets the value to push.
     *
     * @param mixed $push
     */
    public function setPush($push)
    {
        if ($push instanceof OperationInterface) {
            $this->setArguments($push->getOperation());
        } else {
            $this->setArguments($push);
        }
    }
}
