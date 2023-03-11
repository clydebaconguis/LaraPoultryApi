<x-layout>
    <x-card>
        <header class="text-center">
            <h2 class="text-center text-lg mb-5">
                Update a Product
            </h2>
        </header>

        <div class="content">
        <div class="col-sm-12 justify-content-center flex">
        <div class="card col-sm-10 p-4">
            <div class="text-center">
                <img src="https://drive.google.com/uc?export=view&id={{$products->image}}" style="width: 80px; height: 80px" class="rounded img-thumbnail" alt="image">
            </div>

            <form method="POST" action="/updateprod" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="prodname">Product Name</label>
                    <input class="form-control" value="{{$products->name}}" id="prodname" name="name" type="text" placeholder="Product Name">
                </div>
                <div class="form-group">
                        <label for="stock">Stocks</label>
                        <input type="number" value="{{$products->stock}}" class="form-control" name="stock" id="stock" placeholder="Stock">
                </div>

                @unless (count($prices) == 0)
                @foreach ($prices as $price)
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" value="{{$price->value+"&"+$price->id}}" name="price" id="{{$price->id}}" placeholder="price">
                    </div>
                 @endforeach
                 @endunless

                <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control-file" name="image" id="image" placeholder="image">
                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="/products" class="text-dark ml-2"> Back </a>
            </form>
        </div>
        </div>
        </div>
    </x-card>
</x-layout>
