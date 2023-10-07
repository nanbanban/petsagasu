<x-app-layout>
    <x-slot name="title">新しい記事の作成</x-slot>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            新しい記事の作成
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl px-6 lg:px-8">
            <form class="grid grid-cols-1 gap-6" method='POST' action="{{ route('store') }}" enctype="multipart/form-data">
                @csrf
                <label class="block">
                    <span class="text-gray-700">タイトル</span>
                    <input name="title" type="text" class="mt-1 block w-full rounded-md shadow-sm">
                </label>
                <label class="block">
                    <span class="text-gray-700">画像</span>
                    <input type="file" class="block" name='image' id="image">
                </label>
                <label class="block">
                    <span class="text-gray-700">内容</span>
                    <textarea id="markdown-editor" class="block w-full mt-1 rounded-md" name="content" rows="5"></textarea>
                </label>
                <button type='submit' class="w-20 bg-blue-600 hover:bg-blue-500 text-white rounded px-4 py-2">投稿</button>
            </form>
        </div>
    </div>
</x-app-layout>