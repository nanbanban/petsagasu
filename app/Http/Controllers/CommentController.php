<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\Comment;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        $post_id = $data['post_id'];

        Comment::insertGetID([
            'content' => $data['content'], 
            'post_id' => $post_id, 
            'user_id' => Auth::id(), 
        ]);

        return redirect()->route('post', compact('post_id'));
    }
    
    public function edit($comment_id)
    {
        $comment = Comment::where('id', $comment_id)
                          ->where('user_id', Auth::id())
                          ->first();

        return view('edit_comment', compact('comment'));
    }
    
    public function update(Request $request, $comment_id)
    {
        $data = $request->all();
        $query = Comment::where('id', $comment_id)->where('user_id', Auth::id());

        // ユーザーが不正な操作で他人のコメントを編集しようとしていないかチェック
        if ($query->exists()) {
            $query->update(['content' => $data['content']]); // コメントの更新
            $post_id = Comment::where('id', $comment_id)->first()->post_id; // 該当のコメントがつく記事の id を取得
            return redirect()->route('post', compact('post_id')); // 該当の記事へリダイレクト
        } else {
            abort(500); // サーバーエラー
        }
    }
    
    public function delete($comment_id)
    {
        $post_id = Comment::where('id', $comment_id)->first()->post_id;
        $query = Comment::where('id', $comment_id)->where('user_id', Auth::id());

        // ユーザーが不正な操作で、他人のコメントを削除しないかチェック
        if ($query->exists()) {
            Comment::destroy($comment_id);
            return redirect()->route('post', compact('post_id')); // 該当の記事へリダイレクト
        } else {
            abort(500); // サーバーエラー
        }
    }
    
}
