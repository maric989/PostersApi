<?php

namespace App\Transformers;

use App\Comments;

class CommentTransformer extends \League\Fractal\TransformerAbstract
{
    protected $availableIncludes = ['post'];
    protected $defaultIncludes   = ['user'];

    public function transform(Comments $comments)
    {
        return [
            'body'       =>  $comments->body,
            'created_at' =>  $comments->created_at->diffForHumans(),
        ];
    }

    public function includeUser(Comments $comments)
    {
        return $this->item($comments->user,new UserTransformer());
    }

    public function includePost(Comments $comments)
    {
        return $this->item($comments->post(),new PostTransformer());
    }
}
