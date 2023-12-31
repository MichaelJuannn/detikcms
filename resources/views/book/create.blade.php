<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Books') }}
        </h2>
    </x-slot>
    <div class="m-7">
        <form action="/dashboard/books" method="post" enctype="multipart/form-data" class="max-w-sm">
            <div class="mb-2">
                <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Book Title</label>
                <input type="text" name="title" id="title"
                    class="bg-gray-50 border border-gray-500 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>
            <label for="category" class="block mb-2 text-sm font-medium text-gray-900">Category</label>
            <select name="category" id="category"
                class="bg-gray-50 border border-gray-500 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                @foreach ($data as $category)
                <option value={{$category->category}}>{{$category->category}}</option>
                @endforeach
            </select>
            <div class="mb-2">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                <input type="text" name="description" id="description"
                    class="bg-gray-50 border border-gray-500 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">

            </div>
            <div class="mb-2">
                <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900">Quantity</label>
                <input type="text" name="quantity" id="quantity"
                    class="bg-gray-50 border border-gray-500 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>
            <div class="mb-2">
                <label class="block mb-2 text-sm font-medium text-gray-900" for="file">Upload file</label>
                <input type="file" name="file" id="file"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none">
            </div>
            <div class="mb-2">
                <label for="category" class="block mb-2 text-sm font-medium text-gray-900">Upload Cover</label>
                <input type="file" name="cover" id="cover"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none">
            </div>
            <button type="submit" class="bg-blue-400 rounded px-3 py-2">Submit</button>
        </form>
    </div>
</x-app-layout>