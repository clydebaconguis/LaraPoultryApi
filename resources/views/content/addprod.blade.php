<x-layout>
    <x-card>
        <header class="text-center">
            <h2 class="text-center text-lg">
                Create a Product
            </h2>
        </header>

        <form method="POST" action="/product_categories" enctype="multipart/form-data">
            @csrf
            <div class="mb-2">
                <label
                    for="product"
                    class="text-md"
                    >Product Name</label
                >
                <input
                    type="text"
                    class=""
                    name="name"
                    value="{{old('product')}}"
                />

                @error('product')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-2">
                <label for="stock" class="inline-block text-md mb-2"
                    >Stocks</label
                >
                <input
                    type="text"
                    name="stock"
                    value="{{old('stock')}}"
                />
                @error('stock')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-2">
                <label
                    for="type"
                    class="inline-block text-md mb-2"
                    >Type</label
                >
                <select class="form-select" aria-label="Default select example" id="type" name="type" class="p-2">
                    <option selected>Select Types</option>
                    @unless (count($types) == 0)           
                         @foreach ($types as $type)
                            <option value={{$type->id}}>{{$type->name}}</option>
                        @endforeach
                    @endunless
                </select>
            </div>

            <div class="mb-2">
                <label
                    class="inline-block text-md mb-2"
                    >Prices</label>
                 <input
                    type="text"
                    name="price"
                    value="{{old('price')}}"
                />
                <select class="form-select" aria-label="Default select example" id="prices" name="prices" class="p-2">
                    <option selected>Select Unit</option>
                    @unless (count($units) == 0)
                        @foreach ($units as $unit)
                                <option value={{$unit->unit}}>{{$unit->unit}}</option>
                        @endforeach
                    @endunless
                </select>
            </div>

            <div class="mb-6">
                <label for="logo" class="inline-block text-lg mb-2">
                    Product Image
                </label>
                <input
                    type="file"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="image"
                />

                @error('logo')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
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
