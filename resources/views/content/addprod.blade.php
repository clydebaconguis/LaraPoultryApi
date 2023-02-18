<x-layout>
    <x-card>
        <header class="text-center">
            <h2 class="text-center text-lg mb-5">
                Create a Product
            </h2>
        </header>

        <form method="POST" action="/addproduct" enctype="multipart/form-data">
        <table>
            @csrf
             <input
                    type="hidden"
                    name="purpose"
                    value="add"
                />

            <tr class="mb-2">
                <td>
                    <label
                        class="text-md"
                        >Product Name</label
                    >
                </td>

                <td>
                    <input
                        type="text"
                        class=""
                        required
                        name="name"
                        value="{{old('name')}}"
                    />
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </td>
            </tr>

            <tr class="mb-2">
                <td>
                    <label class="inline-block text-md mb-2"
                        >Stocks</label
                    >
                </td>

                <td>
                    <input
                        type="number"
                        name="stock"
                        value="{{old('stock')}}"
                    />
                    @error('stock')
                        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </td>
            </tr>

            <tr class="mb-2">
                <td>
                    <label
                        for="type"
                        class="inline-block text-md mb-2"
                        >Type</label
                    >
                </td>
                <td>
                    <select class="form-select" aria-label="Default select example" id="type" name="type" class="p-2">
                        <option selected>Select Types</option>
                        @unless (count($types) == 0)           
                            @foreach ($types as $type)
                                <option value={{$type->id}}>{{$type->name}}</option>
                            @endforeach
                        @endunless
                    </select>
                </td>
            </tr>

            <tr class="mb-2">
                <td>
                    <label
                        for="price"
                        class="inline-block text-md mb-2"
                        >Prices</label>
                </td>
                <td>
                    <input
                        type="number"
                        name="price"
                        value="{{old('price')}}"
                    />
                </td>
                <td>
                    <select class="form-select" aria-label="Default select example" id="unit" name="unit" class="p-2">
                        <option selected>Select Unit</option>
                        @unless (count($units) == 0)
                            @foreach ($units as $unit)
                                    <option value={{$unit->unit}}>{{$unit->unit}}</option>
                            @endforeach
                        @endunless
                    </select>
                </td>
            </tr>

            <tr class="mb-6">
                <td>
                    <label for="image" class="inline-block text-lg mb-2">
                        Product Image
                    </label>
                </td>

                <td>
                    <input
                        type="file"
                        class="border border-gray-200 rounded p-2 w-full"
                        name="image"
                    />
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </td>
            </tr>
            </table>

            <div class="mb-6 mt-4">
                <button type="submit"
                    class="bg-dark text-white rounded py-2 px-4 hover:bg-black"
                >
                    Create
                </button>

                <a href="/products" class="text-dark ml-2"> Back </a>
            </div>
        </form>
    </x-card>
</x-layout>
