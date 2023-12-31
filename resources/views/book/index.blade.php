<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Buku
        </h2>
    </x-slot>
    <div class="flex justify-start">
        <a href="books/create"><button class="mx-4 my-5 py-3 px-5 rounded bg-green-400">New Book</button></a>
    </div>
    <div class="pt-3 mx-4">
        <label for="category">Category : </label>
        <select name="category" id="category" onchange="categoryChangedTrigger()">
            <option value={{app('request')->input('category')}}>{{app('request')->input('category')}}</option>
            @foreach ($categories as $category)
            <option value={{$category->category}}>{{$category->category}}</option>
            @endforeach
        </select>
    </div>
    <div class="py-4 relative overflow-x-auto">
        <table class="table-auto w-full text-sm text-left rtl:text-right py-10">
            <thead class="text-md text-gray-700 uppercase ">
                <tr class="">
                    <th scope="col" class="px-6 py-3">Title</th>
                    <th scope="col" class="px-6 py-3">Description</th>
                    <th scope="col" class="px-6 py-3">Category</th>
                    <th scope="col" class="px-6 py-3">Quantity</th>
                    <th scope="col" class="px-6 py-3">Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $book)
                <tr class="bg-white border-b">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{$book->title}}</th>
                    <td>{{$book->description}}</td>
                    <td>{{$book->categories}}</td>
                    <td>{{$book->quantity}}</td>
                    <td class="text-center"><a href={{"books/".$book->id}} class="p-2 px-4 bg-gray-200 rounded">Go to
                            Details</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
<script>
    function categoryChangedTrigger() {
        let queryString = window.location.search;  // get url parameters
        let params = new URLSearchParams(queryString);  // create url search params object
        params.delete('category');  // delete city parameter if it exists, in case you change the dropdown more then once
        params.append('category', document.getElementById("category").value); // add selected city
        document.location.href = "?" + params.toString(); // visit new params
    }
</script>