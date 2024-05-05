<?php

namespace App\Http\Controllers;

use App\Events\CommentCreated;
use App\Http\Requests\CommentRequest;
use App\Models\Chirp;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommentController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(Chirp $chirp): View
    {
        return view('comment.create')->with(['chirp' => $chirp]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Chirp $chirp, CommentRequest $request): RedirectResponse
    {
        $comment =[
            'body' => $request->body,
            'chirp_id' => $chirp->id,
            'user_id' => request()->user()->id
        ];
        $commentCreated = Comment::create($comment);
        CommentCreated::dispatch($commentCreated);
        return redirect(route('chirps.index'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment):View
    {
        $this->authorize('update', $comment);
        return view('comment.edit')->with(['comment'=>$comment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Comment $comment, CommentRequest $request)
    {
        $this->authorize('update', $comment);
        $comment->update(["body"=>$request->body]);
        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return redirect(route("chirps.index"));
    }
}
