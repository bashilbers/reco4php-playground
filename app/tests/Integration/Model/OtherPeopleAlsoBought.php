<?php

namespace Bas\Reco4PHP\Tests\Integration\Model;

use GraphAware\Common\Cypher\Statement;
use GraphAware\Reco4PHP\Engine\SingleDiscoveryEngine;

class OtherPeopleAlsoBought extends SingleDiscoveryEngine
{
    /**
     * @return string The name of the discovery engine
     */
    public function name() : string
    {
        return 'other_people_also_bought_discovery';
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
        // id 304 is Roland Mendel
        $query = 'MATCH (me:Customer)-[:PURCHASED]->(o:Order)-[:ORDERS]->(p:Product)<-[:ORDERS]-(o2:Order)-[:ORDERS]->(reco:Product)-[:PART_OF]->(:Category)<-[:PART_OF]-(p)
        WHERE id(me) = {id} AND NOT ( (me)-[:PURCHASED]->(:Order)-[:ORDERS]->(reco) )
        RETURN reco, count(DISTINCT o2) AS score
        ORDER BY score DESC
        LIMIT 5';

        return Statement::prepare($query, ['id' => $input->identity()]);
    }
}