<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Auth;
use Storage;

class PostController extends Controller
{
    
    public function index()
    {
        $posts = Post::latest('updated_at')->get();
        return view('welcome', compact('posts'));
    }
    
    public function store(Request $request)
    {
        $data = $request->all(); // フォームで送信されたデータをすべてとってきます
        $image = $request->file('image');

        if($request->hasFile('image')){
            $path = Storage::put('/public', $image); // 画像は public ディレクトリに保存します
            $image_url = Storage::url($path);
        }else{
            $image_url = null;
        }
        
        $post_id = Post::insertGetId([
            'user_id' => Auth::id(), // ログイン中のユーザーの ID を格納します
            'title' => $data['title'], // 入力された文字列を格納します
            'content' => $data['content'], // 入力された文字列を格納します
            'image_url' => $image_url, 
        ]);

        return redirect()->route('post', compact('post_id'));
    }
    
    public function post($post_id)
    {
        $post = Post::where('id', $post_id)->first();
        if (is_null($post)) {
            abort(404);
        }
        
        $comments = $post->comments()->get(); 
        return view('post', compact('post', 'comments'));
    }
    
    public function show()
    {
        $posts = Post::where('user_id', Auth::id())->latest('updated_at')->get();
        return view('dashboard', compact('posts'));
    }
    
     public function edit($post_id)
    {
        $post = Post::where('id', $post_id)
                    ->where('user_id', Auth::id()) // ログイン中のユーザーが編集しようとしていることを確認
                    ->first();

        return view('edit', compact('post'));
    }
    
    public function update(Request $request, $post_id)
    {
        $data = $request->all();

        $query = Post::where('id', $post_id)->where('user_id', Auth::id());

        // ログイン中のユーザーが記事を更新しようとしていることを確認
        if ($query->exists()) {
            $query->update(['title' => $data['title'], 
                            'content' => $data['content']]);
            return redirect()->route('post', compact('post_id')); // 該当の記事にリダイレクト
        } else {
            abort(500); // サーバーエラー
        }
    }
    
    public function delete($post_id)
    {
        $query = Post::where('id', $post_id)->where('user_id', Auth::id());

        // ログイン中のユーザーが記事を削除しようとしていることを確認
        if ($query->exists()) {
            Post::destroy($post_id);
            return redirect()->route('dashboard');
        } else {
            abort(500); // サーバーエラー
        }
    }
}