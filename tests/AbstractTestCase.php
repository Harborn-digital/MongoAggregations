<?php

namespace ConnectHolland\MongoAggregations\Test;

use MongoClient;
use MongoCollection;
use PHPUnit_Framework_TestCase;

/**
 * Description of AbstractTestCase.
 *
 * @author ron
 */
class AbstractTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Mongo collection to use for testing.
     *
     * @var MongoCollection
     */
    protected $collection;

    /**
     * Keep the db.
     *
     * @var MongoDB
     */
    protected $db;

    /**
     * setUp.
     */
    public function setUp()
    {
        $client = new MongoClient();
        $this->db = $client->selectDB('MongAggregationsUnitTest');
        $this->collection = $this->db->selectCollection(static::class);
    }

    /**
     * tearDown.
     */
    public function tearDown()
    {
        $this->collection->drop();
    }
}
