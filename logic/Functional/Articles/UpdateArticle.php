<?php

namespace Logic\Functional\Articles;

use Main\Models\Article;
use Logic\BaseCase;
use Logic\UseDatabaseTrait;

class UpdateArticle extends BaseCase
{

    use UseDatabaseTrait;

    /** @ */
    public function an_authenticated_user_may_update_an_article()
    {
        $user = $this->createUserWithValidToken();
        $article = $this->createArticle(['user_id' => $user->id]);
        $headers = ['HTTP_AUTHORIZATION' => 'Token ' . $user->token];
        $payload = [
            'article' => [
                'description' => 'Update description',
            ],
        ];

        $response = $this->request('PUT', "/api/articles/$article->slug", $payload, $headers);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('articles', ['description' => 'Update description']);
    }

    /** @ */
    public function unauthenticated_users_may_not_send_request_to_update_articles()
    {
        $article = $this->createArticle();

        $response = $this->request('PUT', "/api/articles/$article->slug");

        $this->assertEquals(401, $response->getStatusCode());
    }

    /** @ */
    public function only_the_owner_of_the_article_can_update_the_article()
    {
        $article = $this->createArticle();
        $unauthorizedUser = $this->createUserWithValidToken();
        $headers = ['HTTP_AUTHORIZATION' => 'Token ' . $unauthorizedUser->token];
        $payload = [
            'article' => [
                'description' => 'Update description',
            ],
        ];

        $response = $this->request('PUT', "/api/articles/$article->slug", $payload, $headers);

        $this->assertEquals(403, $response->getStatusCode());
        $this->assertDatabaseHas('articles', ['description' => $article->description]);
    }

}