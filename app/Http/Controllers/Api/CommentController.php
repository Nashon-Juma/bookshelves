<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Comment\CommentResource;
use App\Models\Book;
use App\Models\Comment;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * @group User: Comment
 */
class CommentController extends ApiController
{
    /**
     * GET Comments for entity.
     */
    public function index(string $model, string $slug)
    {
        $model_name = 'App\Models\\'.ucfirst($model);
        $entity = $model_name::whereSlug($slug)->first();
        $comments = $entity->comments;

        return CommentResource::collection($comments);
    }

    /**
     * GET Comments by user.
     *
     * @authenticated
     */
    public function user(int $user)
    {
        $comments = Comment::whereUserId($user)->orderBy('created_at', 'DESC')->get();

        return CommentResource::collection($comments);
    }

    /**
     * POST Store new comment.
     *
     * @authenticated
     */
    public function store(Request $request, string $model, string $slug)
    {
        $model_name = 'App\Models\\'.ucfirst($model);
        $entity = $model_name::whereSlug($slug)->first();
        $userId = Auth::id();
        $user = Auth::user();

        foreach ($entity->comments as $key => $value) {
            if ($value->user_id === $userId) {
                return response()->json(['error' => 'A comment exist, you can post only one comment here.'], 401);
            }
        }

        $comment_text = $request->text;
        $comment = Comment::create([
            'text' => $comment_text,
            'rating' => $request->rating,
        ]);
        $comment->user()->associate($user);
        $entity->comments()->save($comment);

        return response()->json([
            'Success' => 'Comment created',
            'Comment' => $comment,
        ], 200);
    }

    /**
     * POST Edit comment.
     *
     * @authenticated
     */
    public function edit(string $book)
    {
        $book = Book::whereSlug($book)->first();
        $userId = Auth::id();

        $comment = Comment::whereBookId($book->id)->whereUserId($userId)->firstOrFail();
        if (null == $comment) {
            return response()->json(['error' => 'A comment exist'], 401);
        }

        return response()->json($comment);
    }

    /**
     * POST Update comment.
     *
     * @authenticated
     */
    public function update(Request $request, string $book)
    {
        $book = Book::whereSlug($book)->first();
        $userId = Auth::id();

        $comment = Comment::whereBookId($book->id)->whereUserId($userId)->firstOrFail();
        if (null == $comment) {
            return response()->json(['error' => "Comment don't exist"], 401);
        }
        $comment_text = $request->text;
        $comment_text = Str::markdown($comment_text);
        $comment->text = $comment_text;
        $comment->rating = $request->rating;
        $comment->save();

        return response()->json($comment);
    }

    /**
     * POST Destroy comment.
     *
     * @authenticated
     */
    public function destroy(int $id)
    {
        Comment::destroy($id);

        return response()->json(['Success' => 'Comment have been deleted'], 200);
    }
}
