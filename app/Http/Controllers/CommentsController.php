<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

use View;

use App\Hotel;
use App\Comment;
use App\KnowFromSelect;

class CommentsController extends Controller
{  
    /**
    /   Wyswietlanie opini z komentarzami
    /
    /   @return Response
    */
    public function show($hotel_id)
    {
        $hotel = Hotel::findOrFail($hotel_id);
        $comments = Comment::with('sub_comments')->where('hotel_id', $hotel_id)->get();
        
        return Response::json(compact('comments'));
    }
    
    
    /**
    /   Dodanie opini
    /
    /   @return Response
    */
    public function store($hotel_id, Request $request)
    {
        $hotel = Hotel::findOrFail($hotel_id);
        $request->request->add(['hotel_id' => $hotel_id]); 
        
        $know_from_select = KnowFromSelect::get();
        $know_from_select_validation = [];
        foreach($know_from_select as $know_from)
            $know_from_select_validation[] = $know_from['id'];
        
        $this->validate($request, [ 
            'hotel_id' => 'required|integer',
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'know_from' => 'required|integer|in:' . implode(',', $know_from_select_validation)
        ]);

        $data = $request->all();
        $comment = new Comment();
        $comment->fill($data)->save();

        return Response::json(['status' => 'success']);
    }
    
    
    /**
    /   Edycja opini
    /
    /   @return Response
    */
    public function edit($comment_id, Request $request)
    {
        $comment = Comment::findOrFail($comment_id);
        
        $know_from_select = KnowFromSelect::get();
        $know_from_select_validation = [];
        foreach($know_from_select as $know_from)
            $know_from_select_validation[] = $know_from['id'];
        
        $this->validate($request, [ 
            'comment' => 'string',
            'rating' => 'integer|min:1|max:5',
            'know_from' => 'integer|in:' . implode(',', $know_from_select_validation)
        ]);

        $data = $request->all();
        $comment->update($data);
            
        return Response::json(['status' => 'success']);
    }
    
    
    /**
    /   Usuwanie opini z komentarzami
    /
    /   @return Response
    */ 
    public function remove($comment_id)
    {
        $comment = Comment::findOrFail($comment_id);
        
        $comment->delete();

        return Response::json(['status' => 'success']);
    }
}
