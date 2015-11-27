<?php
namespace ConnectHolland\MongoAggregations\Collection\Test;

use ConnectHolland\MongoAggregations\Collection\EmbeddedCollection;
use ConnectHolland\MongoAggregations\Test\AbstractTestCase;


/**
 * Unit test for the embedded collection class
 *
 * @author Ron Rademaker
 */
class EmbeddedCollectionTest extends AbstractTestCase
{
    /**
     * Reference collection
     */
    protected $referencesCollection;

    /**
     * Create testdata with references
     */
    public function setUp()
    {
        parent::setUp();
        $this->referencesCollection = $this->db->selectCollection(static::class . 'References');

        $ref1Data = ['foo' => 'bar'];
        $ref2Data = ['foo' => 'foo'];

        $this->referencesCollection->save($ref1Data);
        $this->referencesCollection->save($ref2Data);

        $ref1 = $this->referencesCollection->createDBRef($ref1Data);
        $ref2 = $this->referencesCollection->createDBRef($ref2Data);

        $this->collection->save(
            [
                'bar' => 'baz',
                'foo' => $ref1,
                'foobar' => [
                    'baz' => 'foobar',
                    'foo' => $ref2
                ]
            ]
        );

        $this->collection->save(
            [
                'foo' => $ref1,
                'foobar' => [
                    'baz' => 'foobar',
                    'foo' => $ref1
                ]
            ]
        );

        $this->collection->save(
            [
                'bar' => 'foobar',
                'foo' => $ref2
            ]
        );
    }

    /**
     * Remove test collections
     */
    public function tearDown()
    {
        parent::tearDown();

        $this->referencesCollection->drop();
    }

    /**
     * Tests unreferencing an entire collection
     */
    public function testUnreferenceCollection()
    {
        $embeddedCollection = new EmbeddedCollection($this->db, $this->collection->getName(), []);

        $originalResult = $this->collection->find();
        $embeddedResult = $embeddedCollection->find();

        $this->assertEquals($originalResult->count(), $embeddedResult->count());

        foreach ($originalResult as $originalDocument) {
            $embedded = null;
            foreach ($embeddedResult as $embeddedDocument) {
                if ($embeddedDocument['_id'] == $originalDocument['_id']) {
                    $embedded = $embeddedDocument;
                }
            }

            $this->assertNotNull($embedded);

            if (array_key_exists('bar', $originalDocument) && $originalDocument['bar'] === 'baz') {
                $this->assertEquals(
                    [
                        '_id' => $originalDocument['_id'],
                        'bar' => 'baz',
                        'foo' => ['_id' => $originalDocument['foo']['$id'], 'foo' => 'bar'],
                        'foobar' => [
                            'baz' => 'foobar',
                            'foo' => [
                                '_id' => $originalDocument['foobar']['foo']['$id'],
                                'foo' => 'foo'
                            ]
                        ]
                    ],
                    $embedded
                );
            } elseif (array_key_exists('bar', $originalDocument) && $originalDocument['bar'] === 'foobar') {
                $this->assertEquals(
                    [
                        '_id' => $originalDocument['_id'],
                        'bar' => 'foobar',
                        'foo' => ['_id' => $originalDocument['foo']['$id'], 'foo' => 'foo']
                    ],
                    $embedded
                );
            } else {
                $this->assertEquals(
                    [
                        '_id' => $originalDocument['_id'],
                        'foo' => ['_id' => $originalDocument['foo']['$id'], 'foo' => 'bar'],
                        'foobar' => [
                            'baz' => 'foobar',
                            'foo' => [
                                '_id' => $originalDocument['foobar']['foo']['$id'],
                                'foo' => 'bar'
                            ]
                        ]
                    ],
                    $embedded
                );
            }
        }

        $embeddedCollection->drop();
    }

    /**
     * Test unreferencing a selection of a collection
     */
    public function testUnrefenceSelection()
    {
        $query = ['bar', ['$exists' => 1]];
        $embeddedCollection = new EmbeddedCollection($this->db, $this->collection->getName(), $query);

        $originalResult = $this->collection->find($query);
        $embeddedResult = $embeddedCollection->find();

        $this->assertEquals($originalResult->count(), $embeddedResult->count());

        foreach ($originalResult as $originalDocument) {
            $embedded = null;
            foreach ($embeddedResult as $embeddedDocument) {
                if ($embeddedDocument['_id'] == $originalDocument['_id']) {
                    $embedded = $embeddedDocument;
                }
            }

            $this->assertNotNull($embedded);

            if ($originalDocument['bar'] === 'baz') {
                $this->assertEquals(
                    [
                        '_id' => $originalDocument['_id'],
                        'bar' => 'baz',
                        'foo' => ['_id' => $originalDocument['foo']['$id'], 'foo' => 'bar'],
                        'foobar' => [
                            'baz' => 'foobar',
                            'foo' => [
                                '_id' => $originalDocument['foobar']['foo']['$id'],
                                'foo' => 'foo'
                            ]
                        ]
                    ],
                    $embedded
                );
            } elseif ($originalDocument['bar'] === 'foobar') {
                $this->assertEquals(
                    [
                        '_id' => $originalDocument['_id'],
                        'bar' => 'foobar',
                        'foo' => ['_id' => $originalDocument['foo']['$id'], 'foo' => 'foo']
                    ],
                    $embedded
                );
            } else {
                $this->assertFalse(true, 'Unexpected result');
            }
        }

        $embeddedCollection->drop();
    }
}
