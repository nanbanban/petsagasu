<x-app-layout>
    <x-slot name="title">ダッシュボード</x-slot>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}（あなたの記事一覧）
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="table-auto border-solid border-black border-2" style="border-collapse: separate; border-spacing: 0">
                <tr class="bg-green-300">
                    <th class="border border-black px-4 py-2">タイトル</th>
                    <th class="border border-black px-4 py-2">内容</th>
                    <th class="border border-black px-4 py-2">更新日時</th>
                    <th class="border border-black px-4 py-2 bg-yellow-300 w-40" colspan="2">操作</th>
                </tr>
                @foreach ($posts as $post)
                    <tr>
                        <td class="border border-black px-4 py-2 text-blue-500">
                            <a href="{{ route('post', $post['id']) }}">{{ Str::limit($post['title'], 80, '...') }}</a>
                        </td>
                        <td class="border border-black px-4 py-2">{{ Str::limit($post['content'], 80, '…' ) }}</td>
                        <td class="border border-black px-4 py-2">{{ $post['updated_at'] }}</td>
                        <td class="border border-black px-4 py-2 text-blue-500 text-center"><a href="{{ route('edit', $post['id']) }}">編集</a></td>
                        <td class="border border-black px-4 py-2 text-center">
                            <form method='POST' action="{{ route('delete', $post['id']) }}">
                                @csrf
                                <button class="text-red-700" onclick='return confirm("タイトルが「{{ $post->title }}」の記事を削除しますか？");'>削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>