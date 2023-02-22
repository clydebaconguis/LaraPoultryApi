<x-layout>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Orders</h1>

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
                                <th>OrderId</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>OrderId</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                             @unless (count($orders) == 0)           
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{$order->trans_code}}</td>
                                        <td>{{$order->name}}</td>
                                        <td>{{$order->phone}}</td>
                                        <td>{{$order->total_payment}}</td>
                                        <td>{{$order->status}}</td>
                                        <td class="d-flex">
                                            <a type="button" class="btn btn-info" href="/">Details</a>
                                            <form method="POST" action="/orderstat" enctype="multipart/form-data">
                                            @csrf
                                                <input type="hidden" name="orderid" value = {{$order->id}}/>
                                                <select name="orderstat" class="btn btn-danger ml-1" onchange="this.form.submit()">
                                                    <option selected>Select status</option>
                                                    <option value="delivered">Delivered</option>
                                                    <option value="cancel">Cancel</option>
                                                </select>
                                            </form>
                                        </td>
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