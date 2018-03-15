<?php

namespace Logic\Functional\Articles;

use Logic\BaseCase;
use Logic\UseDatabaseTrait;

class ListArticles extends BaseCase
{
    use UseDatabaseTrait;

    /** @ */
    public function it_return_all_articles()
    {
        $response = $this->runApp('GET', '/api/articles');

        $this->assertEquals(200, $response->getStatusCode());
    }
}