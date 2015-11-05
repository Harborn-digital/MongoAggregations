<?php
namespace ConnectHolland\MongoAggregations\Aggregation;

/**
 * Base Aggregation that requires an array as definition
 *
 * @author Ron Radeaker
 */
class AbstractArrayDefinitionAggregation extends AbstractAggregation
{
    /**
     * Gets the definition for the projection
     *
     * @return array
     */
    protected function getDefinition()
    {
        $definition = parent::getDefinition();
        if (!is_array($definition)) {
            $definition = [];
        }
        return $definition;
    }

    /**
     * Sets the value of $field in the definition to $value
     *
     * @param string $field
     * @param mixed $value
     */
    protected function setField($field, $value)
    {
        $definition = $this->getDefinition();

        if (array_key_exists($field, $definition)) {
            throw new InvalidAggregationDefinitionException(
                sprintf('Using the same field \'%s\' in one aggregation is not allowed', $field)
            );
        } else {
            $definition[$field] = $value;
        }
        $this->setDefinition($definition);
    }
}
