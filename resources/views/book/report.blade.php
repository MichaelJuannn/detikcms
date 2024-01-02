<h1 class="text-lg p-6">Laporan Buku CMS</h1>

<div class="flex">
    <div class="py-4 relative overflow-x-auto">
        <table class="table-auto w-full text-sm text-left rtl:text-right py-10">
            <thead class="text-md text-gray-700 uppercase ">
                <tr class="">
                    <th scope="col" class="px-6 py-3">Title</th>
                    <th scope="col" class="px-6 py-3">Description</th>
                    <th scope="col" class="px-6 py-3">Category</th>
                    <th scope="col" class="px-6 py-3">Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $book)
                <tr class="bg-white border-b">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{$book->title}}</th>
                    <td>{{$book->description}}</td>
                    <td>{{$book->categories}}</td>
                    <td>{{$book->quantity}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>