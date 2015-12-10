[![Build Status](https://travis-ci.org/ConnectHolland/MongoAggregations.svg?branch=master)](https://travis-ci.org/ConnectHolland/MongoAggregations)
[![StyleCI](https://styleci.io/repos/45597310/shield)](https://styleci.io/repos/45597310)
[![Latest Stable Version](https://poser.pugx.org/connectholland/mongo-aggregations/v/stable)](https://packagist.org/packages/connectholland/mongo-aggregations) [![Total Downloads](https://poser.pugx.org/connectholland/mongo-aggregations/downloads)](https://packagist.org/packages/connectholland/mongo-aggregations) [![Latest Unstable Version](https://poser.pugx.org/connectholland/mongo-aggregations/v/unstable)](https://packagist.org/packages/connectholland/mongo-aggregations) [![License](https://poser.pugx.org/connectholland/mongo-aggregations/license)](https://packagist.org/packages/connectholland/mongo-aggregations)

# MongoAggregations
Library allowing easy access to the mongo aggregate framework

## Builders
This library constructs aggregation pipelines using builders. You can add stages (instances of AggregationInterface), collections of stages (AggregationBags) or other builders to construct your pipeline. A special builder is the UnwindBuilder. This Builder will create a pipeline that can unwind both strings and arrays and databases that has the two mixed (the latter should be avoided). Basically the builder will transform any mongo field to an array and then unwind that array.

Example usage of the UnwindBuilder is in its Test: https://github.com/ConnectHolland/MongoAggregations/blob/master/tests/Builder/UnwindBuilderTest.php

## Supported stages
This library currently supports the following stages in the aggregate framwork:

| Class | Operator | Description |
|-------|----------|-------------|
|Match|$match| https://docs.mongodb.org/manual/reference/operator/aggregation/match/#pipe._S_match|
|Project|$project| https://docs.mongodb.org/manual/reference/operator/aggregation/project/#pipe._S_project|
|Unwind|$unwind| https://docs.mongodb.org/manual/reference/operator/aggregation/unwind/#pipe._S_unwind|
|Group|$group| https://docs.mongodb.org/manual/reference/operator/aggregation/group/#pipe._S_group|
|Sort|$sort| https://docs.mongodb.org/manual/reference/operator/aggregation/sort/|
|RangeProjection||A ranged projection stage, a special kind of $project which can map ranges (for example: 1 to 10) to strings (for example to 'low'). |

## Supported operations
Within the stages operations can be used, these are currently supported:

| Class | Operator | Description |
|-------|----------|-------------|
|Sum|$sum| https://docs.mongodb.org/manual/reference/operator/aggregation/sum/#grp._S_sum|
|Condition|$cond| https://docs.mongodb.org/manual/reference/operator/aggregation/cond/#exp._S_cond|
|Push|$push| https://docs.mongodb.org/manual/reference/operator/aggregation/push/#grp._S_push|
|WeekOperation|$week| https://docs.mongodb.org/manual/reference/operator/aggregation/week/|
|FieldOperation||Rename a field in a projection (example: ```{$project: {my_field: {'$some.field.hidden.in.complex.nesting'}}}```)|

## EmbeddedCollections
The library adds a class EmbeddedCollection which can be used to create a (temporary) collection that embeds documents that another collection has referenced. 

**Stages or operations that aren't supported by the library, can still be used by constructing arrays. However, creating a class and the abstraction layer that comes with that is to be preferred.**
