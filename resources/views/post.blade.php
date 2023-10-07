<x-guest-layout>
    <x-slot name="title">{{ $post['title'] }}</x-slot>
    
    <h1>{{ $post['title'] }}</h1>
    
    <div class="bg-orange-300 font-bold p-3 mb-8">
        著　　者：{{ $post->user->name }}<br>
        <time datetime="{{ $post['created_at'] }}" itemprop="datepublished">
            作　　成：{{ (new DateTime($post['created_at']))->format("Y年m月d日") }}<br>
        </time>
        <time datetime="{{ $post['updated_at'] }}" itemprop="modified">
            最終更新：{{ (new DateTime($post['updated_at']))->format("Y年m月d日") }}
        </time>
    </div>
    
    @if (isset($post['image_url']))
        <div><img src="{{ $post['image_url'] }}" alt="画像が見つかりません"></div>
    @endif
    
    <div class="not-prose">
        <pre class="whitespace-pre-wrap">{{ $post['content'] }}</pre>
    </div>
    
    <h2>みんなのコメント</h2>
    @forelse ($comments as $comment)
        <div class="bg-gray-300 p-3 mb-4 not-prose">
            <span class="text-blue-700">{{ $comment->user->name }} さんのコメント：</span><br>
            <pre class="whitespace-pre-wrap">{{ $comment['content'] }}</pre>
            @auth
                @if ($comment->user->id === Auth::id())
                    <div class="flex flex-row-reverse mt-1">
                        <form method='POST' action="{{ route('delete_comment', $comment['id']) }}">
                            @csrf
                            <button type='submit' class="bg-red-600 hover:bg-red-500 text-white rounded px-4 py-2" 
                                    onclick='return confirm("コメント「{{ Str::limit($comment->content, 80, '...') }}」を削除しますか？");'>
                                削除
                            </button>
                        </form>
                        <button class="bg-green-600 hover:bg-green-500 text-white rounded px-4 py-2 mr-2" 
                                type="button" onclick="location.href='{{ route('edit_comment', $comment['id']) }}'">
                            編集
                        </button>
                    </div>
                @endif
            @endauth
        </div>
    @empty
        <p>コメントはまだありません。</p>
    @endforelse
    
    @auth
        <h2>コメントを投稿する</h2>
        <form class="grid grid-cols-1 gap-6 text-black" method='POST' action="{{ route('store_comment') }}" enctype="multipart/form-data">
            @csrf
            <input type='hidden' name='post_id' value="{{ $post['id'] }}">
            <label class="block">
                <textarea name='content'
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    rows="3"></textarea>
            </label>
            <button type='submit' class="w-20 bg-blue-600 hover:bg-blue-500 text-white rounded px-4 py-2">投稿</button>
        </form>
    @else
        <p>ログインするとコメントを投稿することができます。</p>
    @endauth
</x-guest-layout>