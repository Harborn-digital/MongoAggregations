<?php

namespace ConnectHolland\MongoAggregations\Collection;

use MongoCollection;
use MongoDB;
use MongoDBRef;

/**
 * Collection that allows to derefence references into an embedded collection.
 *
 * @author Ron Rademaker
 */
class EmbeddedCollection extends MongoCollection
{
    /**
     * DB to lookup references.
     *
     * @var MongoDB
     */
    private $db;

    /**
     * Create a new embedded collection in $db from $collection containing all documents that match $query.
     *
     * @param MongoDB $db
     * @param string  $name
     * @param array   $query
     */
    public function __construct(MongoDB $db, $name, array $query)
    {
        parent::__construct($db, '__embedded_'.uniqid());

        $this->db = $db;
        $this->dereferenceFromCollection(new MongoCollection($db, $name), $query);
    }

    /**
     * Fills this collection with the dererefenced result of $query from $collection.
     *
     * @param MongoCollection $collection
     * @param array           $query
     */
    private function dereferenceFromCollection(MongoCollection $collection, array $query)
    {
        $unreferenced = $collection->find($query);
        foreach ($unreferenced as $document) {
            $this->save($this->unreferenceDocument($document));
        }
    }

    /**
     * Unreference all references in $document.
     *
     * @param array $document
     *
     * @return array
     */
    private function unreferenceDocument(array $document)
    {
        foreach ($document as $key => $value) {
            if (MongoDBRef::isRef($value)) {
                $document[$key] = MongoDBRef::get($this->db, $value);
            } elseif (is_array($value)) {
                $document[$key] = $this->unreferenceDocument($value);
            }
        }

        return $document;
    }
}
