<?php

namespace Bas\Reco4PHP\Tests\Integration\Model;

use GraphAware\Reco4PHP\Engine\BaseRecommendationEngine;

class RecoEngine extends BaseRecommendationEngine
{
    /**
     * @return string
     */
    public function name() : string
    {
        return 'find_products';
    }

    public function discoveryEngines() : array
    {
        return [
            new OtherPeopleAlsoBought(),
            new PopularProducts()
        ];
    }
}
