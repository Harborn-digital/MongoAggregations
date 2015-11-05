# MongoAggregations
Library allowing easy access to the mongo aggregate framework

**This is version 0.1-RC1 of this library, the API may change before the first stable release.**

## Builders
This library constructs aggregation pipelines using builders. You can add stages (instances of AggregationInterface), collections of stages (AggregationBags) or other builders to construct your pipeline. A special builder is the UnwindBuilder. This Builder will create a pipeline that can unwind both strings and arrays and databases that has the two mixed (the latter should be avoided). Basically the builder will transform any mongo field to an array and then unwind that array.

Example usage of the UnwindBuilder is in its Test: https://github.com/ConnectHolland/MongoAggregations/blob/master/tests/Builder/UnwindBuilderTest.php

## Supported stages
This library currently supports the following stages in the aggregate framwork:

* $match: https://docs.mongodb.org/manual/reference/operator/aggregation/match/#pipe._S_match
* $project: https://docs.mongodb.org/manual/reference/operator/aggregation/project/#pipe._S_project
* $unwind: https://docs.mongodb.org/manual/reference/operator/aggregation/unwind/#pipe._S_unwind
* $group: https://docs.mongodb.org/manual/reference/operator/aggregation/group/#pipe._S_group

Currently, other stages are not required by our application that uses this library. Contributions adding support for other stages are welcome.

## Supported operations
Within the stages operations can be used, these are currently supported:

* $sum: https://docs.mongodb.org/manual/reference/operator/aggregation/sum/#grp._S_sum
* $cond: https://docs.mongodb.org/manual/reference/operator/aggregation/cond/#exp._S_cond
* $push: https://docs.mongodb.org/manual/reference/operator/aggregation/push/#grp._S_push
* A ranged condition, a special kind of $cond which can map ranges (for example: 1 to 10) to strings (for example to 'low'). 

Currently, other operations are not required by our application that uses this library. Contributions adding support for other operations are welcome.

**Stages or operations that aren't supported by the library, can still be used be constructing arrays. However, creating a class and the abstraction layer that comes with that is to be preferred.**
