<?php

namespace Bas\Reco4PHP\Tests\Integration;

use Bas\Reco4PHP\Tests\Integration\Model\RecoEngine;
use GraphAware\Neo4j\Client\Client;
use GraphAware\Neo4j\Client\ClientBuilder;
use GraphAware\Reco4PHP\Context\SimpleContext;
use GraphAware\Reco4PHP\RecommenderService;

class NorthwindRecoEngineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RecommenderService
     */
    protected $recoService;

    /**
     * @var Client
     */
    protected $client;

    function setUp()
    {
        $this->recoService = RecommenderService::create('bolt://neo4j');
        $this->recoService->registerRecommendationEngine(new RecoEngine());
        $this->client = ClientBuilder::create()
            ->addConnection('default', 'bolt://neo4j')
            ->build();
    }

    public function testRecoForRoland()
    {
        $engine = $this->recoService->getRecommender('find_products');
        $roland = $this->getCustomerNode('Roland Mendel');

        $recommendations = $engine->recommend($roland, new SimpleContext());
        $recommendations->sort();
        $this->assertEquals(7, $recommendations->size());

        $this->assertNull($recommendations->getItemBy('productNaem', 'Camembert Pierrot'));

        /*
        $boughtProducts = $this->getBoughtProductForNode('Roland Mendel');
        var_dump($boughtProducts->firstRecord()->values()));
        exit;
        */
    }

    private function getCustomerNode($name)
    {
        $q = 'MATCH (n:Customer) WHERE n.contactName = {contactName} RETURN n';
        $result = $this->client->run($q, ['contactName' => $name]);
        return $result->firstRecord()->get('n');
    }

    private function getBoughtProductForNode($name)
    {
        $q = 'MATCH (n:Customer)-[:PURCHASED]->(:Order)-[:ORDERS]->(p:Product) WHERE n.contactName = {contactName} RETURN p';
        $result = $this->client->run($q, ['contactName' => $name]);
        return $result;
    }
}
