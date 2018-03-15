<?php

namespace Logic\Unit\Models;

use Main\Models\Article;
use Main\Models\Tag;
use Main\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Logic\BaseCase;
use Logic\UseDatabaseTrait;

class Tag extends BaseCase
{

    use UseDatabaseTrait;

    /** @ */
    public function a_tag_can_have_many_articles()
    {
        $tag = new Tag();

        $this->assertInstanceOf(BelongsToMany::class, $tag->articles());
        $this->assertInstanceOf(Article::class, $tag->articles()->getRelated());
    }

    /** @ */
    public function a_tag_belongs_to_user()
    {
        $tag = new Tag();

        $this->assertInstanceOf(BelongsTo::class, $tag->user());
        $this->assertInstanceOf(User::class, $tag->user()->getRelated());
    }
}