<?php
namespace ConnectHolland\MongoAggregations\Operation;

/**
 * A $cond operation
 *
 * @author Ron Rademaker
 */
class Condition extends AbstractOperation implements ProjectOperationInterface
{
    /**
     * Creates a new condition
     */
    public function __construct()
    {
        $this->setOperationType('$cond');
    }

    /**
     * Factory method to get condition by array if (@see setIfByArray)
     *
     * @param array $if
     * @param mixed $then
     * @param mixed $else
     * @return Condition
     */
    public static function getConditionByIfArray(array $if, $then, $else) {
        $condition = new static();
        $condition->setIfByArray($if);
        $condition->setThen($then);
        $condition->setElse($else);
        return $condition;
    }


    /**
     * Sets the if part by array
     * Further abstraction here is possible using objects but this is not needed now
     * The method name prepares for future methods setIf(BooleanExpression $if)
     *
     * @param array $if
     */
    public function setIfByArray(array $if)
    {
        $arguments = $this->getArguments();
        if ($arguments[0] !== false) {
            throw new InvalidAggregationOperationArgument('Attempt to add a second if in a condition is not alllowed');
        } else {
            $arguments[0] = $if;
        }
        $this->setArguments($arguments);
    }

    /**
     * Sets the then part
     *
     * @param mixed $then
     */
    public function setThen($then)
    {
        $arguments = $this->getArguments();
        if ($arguments[1] !== false) {
            throw new InvalidAggregationOperationArgument('Attempt to add a second then in a condition is not alllowed');
        } else {
            $arguments[1] = $then;
        }
        $this->setArguments($arguments);
    }

    /**
     * Sets the else part
     *
     * @param mixed $else
     */
    public function setElse($else)
    {
        $arguments = $this->getArguments();
        if ($arguments[2] !== false) {
            throw new InvalidAggregationOperationArgument('Attempt to add a second else in a condition is not alllowed');
        } else {
            $arguments[2] = $else;
        }
        $this->setArguments($arguments);
    }

     /**
     * Gets the arguments for the condition
     *
     * @return array
     */
    protected function getArguments()
    {
        $arguments = parent::getArguments();
        if (!is_array($arguments)) {
            $arguments = [false, false, false];
        }
        return $arguments;
    }
}
