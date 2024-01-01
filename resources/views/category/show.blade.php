<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kategori {{$data->category}}
        </h2>
    </x-slot>
    <div class="m-8">
        <div class=" text-lg capitalize">jumlah buku : {{$data->count}}</div>
        <hr class="my-8 h-px bg-gray-800">
        <a href={{Request::url()."/edit"}}>
            <button class="px-3 py-2 m-2 rounded bg-blue-500 text-white">Update Kategori</button>
        </a>
        <form action={{ route('categories.destroy', ['category'=>$data->category]) }} method="post" class="inline">
            @method('DELETE')
            <button type="submit" class="px-3 py-2 m-2 rounded bg-red-500 text-white">Delete Kategori</button>
        </form>
    </div>
</x-app-layout>