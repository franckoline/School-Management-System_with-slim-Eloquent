<?php

namespace Logic\Functional\Comments;

use Logic\BaseCase;
use Logic\UseDatabaseTrait;

class AddComment extends BaseCase
{

    use UseDatabaseTrait;

    /** @ */
    public function an_authenticated_user_may_comment_on_an_article()
    {
        $article = $this->createArticle();
        $user = $this->createUserWithValidToken();
        $headers = ['HTTP_AUTHORIZATION' => 'Token ' . $user->token];

        $payload = [
            'comment' => [
                'body' => 'His name was my name too.',
            ],
        ];

        $response = $this->request(
            'POST',
            "/api/articles/$article->slug/comments",
            $payload,
            $headers);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('comments', ['body' => 'His name was my name too.']);
        $this->assertEquals(1, $article->comments()->count());
        $this->assertEquals(1, $user->comments()->count());
    }


    /** @ */
    public function un_unauthenticated_may_not_post_new_comment()
    {
        $article = $this->createArticle();
        $response = $this->request('POST', "/api/articles/$article->slug/comments");

        $this->assertEquals(401, $response->getStatusCode());
    }

}