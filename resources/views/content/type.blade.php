<x-layout>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Category</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="d-flex justify-content-between card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Poultry</h6>
                <a class="btn btn-primary ms-5" href="/showtype">Add Category</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                               <th>ID</th>
                                <th>Category</th>
                            </tr>
                        </tfoot>
                        <tbody>
                             @unless (count($types) == 0)           
                                @foreach ($types as $type)
                                    <tr>
                                        <td>{{$type->id}}</td>
                                        <td>{{$type->name}}</td>
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