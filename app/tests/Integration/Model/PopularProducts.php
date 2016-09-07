<?php

namespace Bas\Reco4PHP\Tests\Integration\Model;

use GraphAware\Common\Cypher\Statement;
use GraphAware\Reco4PHP\Engine\SingleDiscoveryEngine;

class PopularProducts extends SingleDiscoveryEngine
{
    /**
     * @return string The name of the discovery engine
     */
    public function name() : string
    {
        return 'popular_products_discovery';
    }

    /**
     * The statement to be executed for finding items to be recommended.
     *
     * @param \GraphAware\Common\Type\Node $input
     * @param \GraphAware\Reco4PHP\Context\Context $context
     *
     * @return \GraphAware\Common\Cypher\Statement
     */
    public function discoveryQuery(\GraphAware\Common\Type\Node $input, \GraphAware\Reco4PHP\Context\Context $context) : \GraphAware\Common\Cypher\StatementInterface
    {
        $query = 'MATCH (c:Customer)-[:PURCHASED]->(o:Order)-[:ORDERS]->(reco:Product)
        MATCH (me:Customer) WHERE id(me) = {id} AND NOT ( (me)-[:PURCHASED]->(:Order)-[:ORDERS]->(reco) )
RETURN reco, count(o) as score
ORDER BY score DESC
LIMIT 5';

        return Statement::prepare($query, ['id' => $input->identity()]);
    }
}