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
                                <th>Transaction</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Method</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Transaction</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Method</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                             @unless (count($orders) == 0)           
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{$order->trans_code}}</td>
                                        <td>{{$order->name}}</td>
                                        <td>{{$order->user_add}}</td>
                                        <td>{{$order->phone}}</td>
                                        <td>{{$order->payment_opt}}</td>
                                        <td>{{$order->total_payment}}</td>
                                        <td><button style="background-color:blue">Edit</button></td>
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