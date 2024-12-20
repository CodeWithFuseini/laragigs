@extends('layout')

@section('content')
    <div class="bg-gray-50 border border-gray-200 p-10 rounded">
        <header>
            <h1 class="text-3xl text-center font-bold my-6 uppercase">
                Manage Gigs
            </h1>
        </header>

        <table class="w-full table-auto rounded-sm">
            <tbody>
                <tr class="border-gray-300">
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        @empty($listings)
                            <h1>You have no listing yet, try add some</h1>
                        @endempty
                    </td>
                </tr>

                @foreach ($listings as $listing)
                    <tr class="border-gray-300">
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            <a href="/listing/{{ $listing->id }}">
                                {{ $listing->title }}
                            </a>
                        </td>
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            <a href="/listing/{{ $listing->id }}/edit" class="text-blue-400 px-6 py-2 rounded-xl"><i
                                    class="fa-solid fa-pen-to-square"></i>
                                Edit</a>
                        </td>
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            <form action="/listings/{{ $listing->id }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600">
                                    <i class="fa-solid fa-trash-can"></i>
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
