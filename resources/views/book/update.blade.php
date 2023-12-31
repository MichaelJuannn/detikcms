<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Buku Judul: {{ $data->title }}
        </h2>
    </x-slot>
    <div class="">
        <form action={{"/dashboard/books/".$data->id}} method="POST" enctype="multipart/form-data">
            @method('PATCH')
            <input type="text" name="title">
            <select name="category" id="category">
                @foreach ($category as $category)
                <option value={{$category->category}}>{{$category->category}}</option>
                @endforeach
            </select>
            <input type="text" name="description">
            <input type="text" name="quantity">
            <input type="file" name="file">
            <input type="file" name="cover">
            <button type="submit">submit</button>
        </form>
    </div>
</x-app-layout>