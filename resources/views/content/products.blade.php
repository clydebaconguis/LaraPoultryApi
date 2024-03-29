<x-layout>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-flex justify-content-between p-4">
            <h1 class="h3 text-gray-800">Products</h1>
            <a class="btn btn-primary ms-5" href="/addprod">Add Product</a>

        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Poultry</h6>
            </div>
           
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Stock</th>
                                <th>Date</th>
                                <th>Actions</th>
            
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Stock</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                             @unless (count($products) == 0)           
                                @foreach ($products as $product)
                                    <tr>
                                        <td> <image class="rounded-circle justify-content-center" style="width: 50px; height: 50px" src="https://drive.google.com/uc?export=view&id={{$product->image}}" /></td>
                                        @if ($product->status == 1)
                                            <td class="text-success">{{$product->name}}</td>
                                            <td class="text-success">Active</td>
                                        @else
                                            <td class="text-danger">{{$product->name}}</td>
                                            <td class="text-danger">Disable</td>
                                        @endif
                                        <td>{{$product->stock}} {{$product->type}}</td>
                                        <td>{{$product->created_at}}</td>
                                        <td><a type="button" class="btn btn-info" href="/editprod/{{$product->id}}/edit">Edit</a></td>
                                    </tr>
                                
                                @endforeach
                         
                            @endunless
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
</x-layout>