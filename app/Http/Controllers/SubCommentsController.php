<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

use App\Comment;
use App\SubComment;

class SubCommentsController extends Controller
{
    
    /**
    /   Dodanie komentarza
    /
    /   @return Response
    */
    public function store($comment_id, Request $request)
    {
        $comment = Comment::findOrFail($comment_id);
        $request->request->add(['comment_id' => $comment_id]);  
        
        $this->validate($request, [ 
            'comment_id' => 'required|integer',
            'comment' => 'required|string',
        ]);

        $data = $request->all();
        
        $sub_comment = new SubComment();
        $sub_comment->fill($data)->save();

        return Response::json(['status' => 'success']);
    }  
}
