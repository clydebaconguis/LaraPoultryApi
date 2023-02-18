<x-layout>
    <x-card>
        <header class="text-center">
            <h2 class="text-center text-lg mb-5">
                Edit a Product
            </h2>
        </header>

        <form method="POST" action="/updateprod" enctype="multipart/form-data">
        <table>
            @csrf
            <div class="mb-5">
                <image class="mx-auto d-block" style="width: 100px; height: 100px" src="https://drive.google.com/uc?export=view&id={{$products->image}}" />
            </div>

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
                        required
                        name="name"
                        value="{{$products->name}}"
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
                        value="{{$products->stock}}"
                    />
                    @error('stock')
                        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </td>
            </tr>

            @unless (count($prices) == 0)
            @foreach ($prices as $price)
                <tr class="mb-2">
                    <td>
                        <label
                            for="price"
                            class="inline-block text-md mb-2"
                            >Price</label>
                    </td>

                    <td>
                        <input
                            type="number"
                            name="price"
                            value="{{$price->value}}"
                        />
                    </td>

                    <td>
                        <select class="form-select" aria-label="Default select example" id="unit" name="unit" class="p-2">
                            <option selected>{{$price->unit}}</option>
                        </select>
                    </td>
                </tr>
             @endforeach
             @endunless

        </table>
        <div class="mb-6 mt-4">
            <button type="submit" disabled
                class="bg-dark text-white rounded py-2 px-4 hover:bg-black"
            >
                Save
            </button>

            <a href="/products" class="text-dark ml-2"> Back </a>
        </div>
        </form>
    </x-card>
</x-layout>
