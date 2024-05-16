<x-app-layout>
    <div class="container mx-auto mt-8 p-4">
        <div class="grid grid-cols-3 gap-2">
            @foreach($pets as $pet)
                <div class="bg-white shadow-md rounded-md p-6 border border-sky-500">
                    <div>
                        <div class="flex space-x-8">
                            <h1 class="text-2xl font-bold mb-4">
                                Pet Details
                            </h1>
                            <div class="flex space-x-2">
                                <a href="{{route(name: 'pet.edit', parameters:  $pet?->getId())}}"
                                   class="h-10 bg-sky-600 py-2 px-4 rounded">Edit</a>
                                <form method="post"
                                      action="{{ route(name: 'pet.destroy', parameters: $pet?->getId()) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-rose-600 py-2 px-4 rounded">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col space-y-2">
                        <div>
                            <h2 class="text-lg font-semibold">ID:</h2>
                            <p class="text-gray-700">{{ $pet?->getId() }}</p>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold">Name:</h2>
                            <p class="text-gray-700">{{ $pet?->getName() }}</p>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold">Category ID:</h2>
                            <p class="text-gray-700">{{ $pet?->getCategory()?->getId() }}</p>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold">Category Name:</h2>
                            <p class="text-gray-700">{{ $pet?->getCategory()?->getName() }}</p>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold">Status:</h2>
                            <p class="text-gray-700">{{ $pet?->getStatus() }}</p>
                        </div>

                        @if(($pet?->getPhotoUrls()))
                            <div>
                                <h2 class="text-lg font-semibold">Photo URLs:</h2>
                                <ul class="list-disc list-inside text-gray-700">
                                    @foreach($pet?->getPhotoUrls() as $photoUrl)
                                        <li>{{ $photoUrl }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if($pet?->getTags())
                            <div>
                                <h2 class="text-lg font-semibold">Tags:</h2>
                                <ul class=" text-gray-700 space-y-2">
                                    @foreach($pet?->getTags() as $tag)
                                        <li>
                                            <p>ID: {{ $tag?->getId() }}</p>
                                            <p>Name: {{ $tag?->getName() }}</p>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>