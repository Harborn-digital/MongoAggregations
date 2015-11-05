<?php
namespace ConnectHolland\MongoAggregations\Operation;

/**
 * Abstract operation
 *
 * @author Ron Rademaker
 */
abstract class AbstractOperation implements \ConnectHolland\MongoAggregations\Operation\OperationInterface
{
    /**
     * The type of operation
     *
     * @var string
     */
    private $operationType;

    /**
     * The arguments for the operation
     *
     * @var mixed
     */
    private $arguments;

    /**
     * Gets the operation
     *
     * @return array
     */
    public function getOperation()
    {
        return [$this->operationType => $this->getArguments()];
    }

    /**
     * Setter for the operation type
     * Should be set from the constructor of the subclass
     *
     * @param string $operationType
     */
    protected function setOperationType($operationType)
    {
        $this->operationType = $operationType;
    }

    /**
     * Gets the arguments for the operation
     *
     * @return mixed
     */
    protected function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Sets the definition of this aggregation
     *
     * @param mixed arguments
     */
    protected function setArguments($arguments)
    {
        $this->arguments = $arguments;
    }
}
