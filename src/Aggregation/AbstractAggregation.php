<?php
namespace ConnectHolland\MongoAggregations\Aggregation;

/**
 * Abstract aggregation stage
 *
 * @author Ron Rademaker
 */
abstract class AbstractAggregation implements AggregationInterface
{
    /**
     * The type of aggregation
     *
     * @var string
     */
    private $aggregationType;

    /**
     * Var holding the stage's definition
     *
     * @var mixed
     */
    private $definition;

    /**
     * Gets the aggregation stage
     *
     * @return array
     */
    public function getStage()
    {
        return [$this->aggregationType => $this->getDefinition()];
    }

    /**
     * Setter for the aggregation type
     * Should be set from the constructor of the subclass
     *
     * @param string $aggregationType
     */
    protected function setAggregationType($aggregationType)
    {
        $this->aggregationType = $aggregationType;
    }

    /**
     * Gets the definition of this aggregation
     *
     * @return mixed
     */
    protected function getDefinition()
    {
        return $this->definition;
    }

    /**
     * Sets the definition of this aggregation
     *
     * @param mixed $definition
     */
    protected function setDefinition($definition)
    {
        $this->definition = $definition;
    }
}
