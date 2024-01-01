<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Kategori
        </h2>
    </x-slot>
    <div class="flex justify-start">
        <a href={{route('categories.create')}}>
            <button class="mx-4 my-5 py-3 px-5 rounded bg-green-400">New Category</button>
        </a>
    </div>
    <div class="py-4 relative overflow-x-auto">
        <table class="table-auto w-full text-sm rtl:text-right py-10">
            <thead class="text-md text-gray-700 uppercase ">
                <tr class="">
                    <th scope="col" class="px-6 py-3">Category</th>
                    <th scope="col" class="px-6 py-3">Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $category)
                <tr class="bg-white border-b">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{$category->category}}
                    </th>
                    <td class="text-center"><a href={{route('categories.show',['category'=> $category->category])}}
                            class="p-2
                            px-4
                            bg-gray-200 rounded">Go to
                            Details</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>