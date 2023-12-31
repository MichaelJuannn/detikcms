<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Category') }}
        </h2>
    </x-slot>
    <div>
        <form action="/dashboard/categories" method="post">
            <label for="category">Masukkan Kategori Baru</label>
            <input type="text" name="category" id="category">
            <button type="submit">submit</button>
        </form>
    </div>
</x-app-layout>