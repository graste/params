<?php

namespace Params\Tests;

class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    protected function getExampleValues()
    {
        return array(
            'str' => 'some string',
            'int' => mt_rand(0, 999),
            'bool' => (mt_rand(1, 100) <= 50) ? true : false,
            'first_level' => 'first level',
            'nested' => array(
                'str' => 'some nested string',
                'int' => mt_rand(10000, 19999),
                'bool' => (mt_rand(1, 100) <= 50) ? true : false,
                '2nd level' => 'second level',
            ),
            'more' => array(
                'str' => 'other nested string'
            )
        );
    }

    protected function getExampleElasticSearchQueryAsArray()
    {
        return json_decode($this->getExampleElasticSearchQuery(), true);
    }

    protected function getExampleElasticSearchQuery()
    {
        return <<<EOQ
{
    "filter": {
        "bool": {
            "must": [
                {
                    "match_all": []
                },
                {
                    "term": {
                        "live": true
                    }
                },
                {
                    "match_all": []
                }
            ],
            "must_not": [],
            "should": []
        }
    },
    "size": 10000
}
EOQ;
    }

}
