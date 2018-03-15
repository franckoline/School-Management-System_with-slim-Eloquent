<?php

namespace Logic\Unit\Models;

use Main\Models\Article;
use Main\Models\Comment;
use Main\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Logic\BaseCase;
use Logic\UseDatabaseTrait;

class Comment extends BaseCase
{

    use UseDatabaseTrait;

    /** @ */
    public function a_comment_belongs_to_an_article()
    {
        $comment = new Comment();

        $this->assertInstanceOf(BelongsTo::class, $comment->article());
        $this->assertInstanceOf(Article::class, $comment->article()->getRelated());
    }

    /** @ */
    public function a_comment_belongs_to_a_user()
    {
        $comment = new Comment();

        $this->assertInstanceOf(BelongsTo::class, $comment->user());
        $this->assertInstanceOf(User::class, $comment->user()->getRelated());

    }
}