<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$data->title}}
        </h2>
    </x-slot>

    <div class="py-12">
        @foreach ($data->category()->get() as $key)
        <div>{{$key->category}}</div>
        @endforeach
    </div>
</x-app-layout>