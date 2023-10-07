<x-app-layout>
    <x-slot name="title">記事の編集</x-slot>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            記事の編集
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl px-6 lg:px-8">
            <form class="grid grid-cols-1 gap-6" method='POST' action="{{ route('update', $post['id']) }}" enctype="multipart/form-data">
                @csrf
                <label class="block">
                    <span class="text-gray-700">タイトル</span>
                    <input name="title" type="text" class="mt-1 block w-full rounded-md shadow-sm" value="{{ $post['title'] }}">
                </label>
                <label class="block">
                    <span class="text-gray-700">内容</span>
                    <textarea class="block w-full mt-1 rounded-md" name="content" rows="5">{{ $post['content'] }}</textarea>
                </label>
                <button type='submit' class="w-20 bg-blue-600 hover:bg-blue-500 text-white rounded px-4 py-2">更新</button>
            </form>
        </div>
    </div>
</x-app-layout>