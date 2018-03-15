<?php

namespace Logic\Unit\Models;

use Main\Models\Article;
use Main\Models\Comment;
use Main\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Logic\BaseCase;
use Logic\UseDatabaseTrait;

class User extends BaseCase
{

    use UseDatabaseTrait;

    /** @ */
    public function a_user_can_have_many_comments()
    {
        $user = new User();

        $this->assertInstanceOf(HasMany::class, $user->comments());
        $this->assertInstanceOf(Comment::class, $user->comments()->getRelated());
    }

    /** @ */
    public function a_user_can_have_many_following_users()
    {
        $user = new User();

        $this->assertInstanceOf(BelongsToMany::class, $user->followings());
        $this->assertInstanceOf(User::class, $user->followings()->getRelated());
    }

    /** @ */
    public function a_user_can_follow_another_user()
    {
        $user = $this->createUser();
        $followedUser = $this->createUser();

        $user->follow($followedUser->id);

        $this->assertCount(1, $user->followings);
    }

    /** @ */
    public function a_user_can_tell_if_it_follows_another_user()
    {
        $user = $this->createUser();
        $followedUser = $this->createUser();
        $this->assertFalse($user->isFollowing($followedUser->id));

        $user->follow($followedUser->id);

        $this->assertTrue($user->fresh()->isFollowing($followedUser->id));
    }

    /** @ */
    public function a_user_can_unfollow_followed_user()
    {
        $user = $this->createUser();
        $followedUser = $this->createUser();
        $user->follow($followedUser->id);
        $this->assertTrue($user->fresh()->isFollowing($followedUser->id));

        $user->unFollow($followedUser->id);

        $this->assertFalse($user->fresh()->isFollowing($followedUser->id));
    }

    /** @ */
    public function a_user_can_not_follow_another_user_twice()
    {
        $user = $this->createUser();
        $followedUser = $this->createUser();
        $user->follow($followedUser->id);
        $this->assertCount(1, $user->followings);

        $user->follow($followedUser->id);
        $this->assertCount(1, $user->fresh()->followings);
    }

    /** @ */
    public function it_has_favorite_articles_relationship()
    {
        $user = new User();

        $this->assertInstanceOf(BelongsToMany::class, $user->favoriteArticles());
        $this->assertInstanceOf(Article::class, $user->favoriteArticles()->getRelated());

    }

    /** @ */
    public function it_return_default_image_profile_when_user_does_not_have_an_image()
    {
        $defaultImageUrl = 'https://static.productionready.io/images/smiley-cyrus.jpg';
        $userWithoutImage = $this->createUser();
        $userWithImage = $this->createUser(['image' => 'http://image.jpg']);

        $this->assertEquals($defaultImageUrl, $userWithoutImage->image);
        $this->assertEquals('http://image.jpg', $userWithImage->image);
    }
}