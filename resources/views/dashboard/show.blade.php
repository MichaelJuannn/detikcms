<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buku: {{$data->title}}
        </h2>
    </x-slot>

    <div class="py-12 px-4">
        <img class="my-5" src={{asset('storage/'.$data->cover)}} alt="cover buku" srcset="">
        <div>
            <div>Judul Buku: {{$data->title}} </div>
            <div>Kategori: {{$data->categories}} </div>
            <div>Deskripsi: {{$data->description}} </div>
            <div>Jumlah Buku: {{$data->quantity}} </div>
            <div> Buku: <a class="text-blue-600 underline" href={{ asset('storage/'.$data->file) }}>Download</a></div>
        </div>
        <div class="flex">
            <a href={{Request::url()."/edit"}}><button class="px-3 py-2 m-2 rounded bg-blue-500">Update</button></a>
            <form action={{ route('dashboard.destroy', ['dashboard'=>$data->id]) }} method="post">
                @method('DELETE')
                <button type="submit" class="px-3 py-2 m-2 rounded bg-red-500">Delete</button>
            </form>
        </div>
    </div>
</x-app-layout>