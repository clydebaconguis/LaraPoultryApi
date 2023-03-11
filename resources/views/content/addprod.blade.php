<x-layout>
    <x-card>
        <header class="text-center">
            <h2 class="text-center text-lg mb-5">
                Create a Product
            </h2>
        </header>

        <div class="content">
        <div class="col-sm-12 justify-content-center flex">
        <div class="card col-sm-10 p-4">
            <form method="POST" action="/addproduct" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="prodname">Product Name</label>
                    <input class="form-control" id="prodname" name="name" type="text" placeholder="Product Name">
                </div>
                <div class="form-group">
                        <label for="stock">Stocks</label>
                        <input type="number" class="form-control" name="stock" id="stock" placeholder="Stock">
                </div>
                <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" name="price" id="price" placeholder="price">
                </div>
                <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control-file" name="image" id="image" placeholder="image">
                </div>
                
                <div class="form-group">
                    <label for="type">Categories</label>
                    <select class="form-control" aria-label="Default select example" id="type" name="type" class="p-2">
                        <option selected>Select Types</option>
                        @unless (count($types) == 0)           
                            @foreach ($types as $type)
                                <option value={{$type->id}}>{{$type->name}}</option>
                            @endforeach
                        @endunless
                    </select>
                </div>

                <div class="form-group">
                    <label for="unit">Unit</label>
                    <select class="form-control" aria-label="Default select example" id="unit" name="unit" class="p-2">
                        <option selected>Select Unit</option>
                        @unless (count($units) == 0)           
                            @foreach ($units as $unit)
                                <option value={{$unit->id}}>{{$unit->unit}}</option>
                            @endforeach
                        @endunless
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="/products" class="text-dark ml-2"> Back </a>
            </form>
        </div>
        </div>
        </div>
    </x-card>
</x-layout>
