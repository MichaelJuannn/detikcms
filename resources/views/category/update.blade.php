<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit {{$data}}
        </h2>
    </x-slot>
    <div class="">
        <form action={{ route('categories.update', ['category'=>$data]) }} method="post" class="max-w-sm m-6 space-y-6">
            @method('PATCH')
            <label for="category" class="block mb-2 text-sm font-medium text-gray-900">Masukkan Kategori Baru</label>
            <input type="text" name="category" id="category"
                class="bg-gray-50 border border-gray-500 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <button type="submit" class="bg-blue-400 rounded px-3 py-2 text-white">Submit</button>
        </form>
    </div>
</x-app-layout>