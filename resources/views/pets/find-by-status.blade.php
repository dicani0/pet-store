@php use App\Enums\PetStatus; @endphp
<x-app-layout>
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 mt-1 text-center">
            @foreach($errors->all() as $error)
                <span class="block">{{ $error }}</span>
            @endforeach
        </div>
    @endif

    <div class="container mx-auto mt-4">
        <div class="max-w-lg mx-auto bg-white shadow-md rounded-md overflow-hidden">
            <div class="w-full p-4">
                <h2 class="text-2xl font-bold text-center mb-4">Find Pets by status</h2>
                <form action="{{ route('pet.index') }}" method="get" class="space-y-6">
                    <div class="flex flex-col">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status">
                            @foreach(PetStatus::cases() as $status)
                                <option value="{{ $status->value }}">{{ $status->getLabel() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-center">
                        <button type="submit"
                                class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Find Pets
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>