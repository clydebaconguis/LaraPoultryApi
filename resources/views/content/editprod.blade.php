<x-layout>
    <x-card>
        <header class="text-center">
            <h2 class="text-center text-lg">
                Edit a Product
            </h2>
        </header>

        <form method="POST" action="/" enctype="multipart/form-data">
            @csrf
             <input
                    type="hidden"
                    name="purpose"
                    value="edit"
                />

            <div class="mb-6">
                <image class="mx-auto d-block" style="width: 100px; height: 100px" src="https://drive.google.com/uc?export=view&id={{$products->image}}" />
            </div>

            <div class="mb-2">
                <label
                    for="name"
                    class="text-md"
                    >Product Name</label
                >
                <input
                    type="text"
                    class=""
                    required
                    name="name"
                    value="{{$products->name}}"
                />

                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-2">
                <label for="stock" class="inline-block text-md mb-2"
                    >Stocks</label
                >
                <input
                    type="number"
                    name="stock"
                    value="{{$products->stock}}"
                />
                @error('stock')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            @unless (count($prices) == 0)
            @foreach ($prices as $price)
                <div class="mb-2">
                    <label
                        for="price"
                        class="inline-block text-md mb-2"
                        >Price</label>

                    <input
                        type="number"
                        name="price"
                        value="{{$price->value}}"
                    />
                    <select class="form-select" aria-label="Default select example" id="unit" name="unit" class="p-2">
                        <option selected>{{$price->unit}}</option>
                    </select>
                </div>
             @endforeach
             @endunless

            <div class="mb-6">
                <button type="submit"
                    class="bg-dark text-white rounded py-2 px-4 hover:bg-black"
                >
                    Save
                </button>

                <a href="/products" class="text-dark ml-2"> Back </a>
            </div>
        </form>
    </x-card>
</x-layout>
