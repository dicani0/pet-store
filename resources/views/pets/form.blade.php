@php use App\Enums\PetStatus; @endphp
<x-app-layout>
    <div class="container mx-auto mt-8 p-4">
        <div class="bg-white shadow-md rounded-md p-6">
            <h1 class="text-2xl font-bold mb-4">{{isset($pet) ? 'Edit Pet' : 'Add a New Pet'}}</h1>
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    @foreach ($errors->all() as $error)
                        <p class="block">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <form action="{{ isset($pet) ? route('pet.update') : route('pet.store') }}" method="POST"
                  class="space-y-6">
                @csrf
                @if(isset($pet))
                    @method('PUT')
                @endif

                <div class="flex flex-col">
                    <label for="name" class="block text-sm font-medium text-gray-700">ID</label>
                    <input type="number" id="id" name="id"
                           value="{{isset($pet) ? $pet?->getId() : ''}}"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                           required>
                </div>
                <div class="flex flex-col">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" name="name"
                           value="{{isset($pet) ? $pet?->getName() : ''}}"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                           required>
                </div>
                <div class="flex flex-col">
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category ID</label>
                    <input type="number" id="category_id" name="category_id"
                           value="{{isset($pet) ? $pet->getCategory()?->getId() : ''}}"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                           required>
                </div>
                <div class="flex flex-col">
                    <label for="category_name" class="block text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" id="category_name" name="category_name"
                           value="{{isset($pet) ? $pet->getCategory()?->getName() : ''}}"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                           required>
                </div>
                <div class="flex flex-col">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="status" name="status"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required>
                        @foreach(PetStatus::cases() as $status)
                            @if(isset($pet) && $pet->getStatus() === $status->value)
                                <option selected value="{{$status->value}}">{{$status->getLabel()}}</option>
                            @else
                                <option value="{{$status->value}}">{{$status->getLabel()}}</option>
                            @endif
                        @endforeach
                        {{--                        @if(isset($pet) && $pet->getStatus() === 'available')--}}
                        {{--                            <option selected value="available">Available</option>--}}
                        {{--                        @else--}}
                        {{--                            <option value="available">Available</option>--}}
                        {{--                        @endif--}}
                        {{--                        @if(isset($pet) && $pet->getStatus() === 'pending')--}}
                        {{--                            <option selected value="pending">Pending</option>--}}
                        {{--                        @else--}}
                        {{--                            <option value="pending">Pending</option>--}}
                        {{--                        @endif--}}
                        {{--                        @if(isset($pet) && $pet->getStatus() === 'sold')--}}
                        {{--                            <option selected value="sold">Sold</option>--}}
                        {{--                        @else--}}
                        {{--                            <option value="sold">Sold</option>--}}
                        {{--                        @endif--}}
                    </select>
                </div>
                <div class="flex flex-col">
                    <label for="photoUrls" class="block text-sm font-medium text-gray-700">Photo URLs
                        (comma-separated)</label>
                    <textarea id="photoUrls" name="photoUrls"
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{isset($pet) ? implode(separator: ',', array: $pet->getPhotoUrls()) : ''}}</textarea>
                </div>
                <div class="flex flex-col">
                    <label for="tags" class="block text-sm font-medium text-gray-700">Tags</label>
                    <div id="tags-container" class="space-y-4 mb-4">
                        <div class="flex flex-col space-y-2 tag-item">
                            {{--                            <div class="flex space-x-8">--}}
                            {{--                                <input type="number" name="tags[0][id]" placeholder="Tag ID"--}}
                            {{--                                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">--}}
                            {{--                                <input type="text" name="tags[0][name]" placeholder="Tag Name"--}}
                            {{--                                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">--}}
                            {{--                                <button type="button" onclick="removeTag(this)"--}}
                            {{--                                        class="py-2 px-4 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">--}}
                            {{--                                    X--}}
                            {{--                                </button>--}}
                            {{--                            </div>--}}
                            @if(isset($pet) && $pet->getTags())
                                @foreach($pet->getTags() as $tag)
                                    <div class="flex space-x-8 tag-box">
                                        <input type="number" name="tags[@php echo $loop->index @endphp][id]"
                                               value="{{$tag->getId()}}"
                                               placeholder="Tag ID"
                                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               required>

                                        <input type="text" name="tags[@php echo $loop->index @endphp][name]"
                                               placeholder="Tag Name"
                                               value="{{$tag->getName()}}"
                                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               required>
                                        <button type="button" onclick="removeTag(this)"
                                                class="py-2 px-4 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            X
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <button type="button" onclick="addTag()"
                            class="mt-2 py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Add Tag
                    </button>
                </div>
                <div class="flex justify-center">
                    <button type="submit"
                            class="w-1/5 py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{isset($pet) ? 'Update Pet' : 'Add Pet'}}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let tagCount = document.getElementsByClassName('tag-box').length;

        function addTag() {
            const container = document.getElementById('tags-container');
            const newTag = document.createElement('div');
            newTag.classList.add('flex', 'flex-col', 'space-y-2', 'tag-item');
            newTag.innerHTML = `
                <div class="flex space-x-8 tag-box">
                    <input type="number" name="tags[${tagCount}][id]" placeholder="Tag ID" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    <input type="text" name="tags[${tagCount}][name]" placeholder="Tag Name" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    <button
                        type="button"
                        onclick="removeTag(this)"
                        class="py-2 px-4 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        X
                    </button>
                </div>
            `;
            container.appendChild(newTag);
            tagCount++;
        }

        function removeTag(button) {
            button.closest('.tag-item').remove();
            tagCount--;
        }
    </script>
</x-app-layout>