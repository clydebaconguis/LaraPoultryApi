 <x-layout >
  <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <p style="display: none" id="dash-admin" >Welcome {{ $user->name }}</p>
        {{-- <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Products</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalProducts}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Category</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalCategory}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Orders
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$totalOrder}}</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalUser}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Orders</h1>

        @if(session()->has('message')) <p class="alert alert-success">{{session('message')}}</p> @endif

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                @unless (count($orders) == 0)        
                @php
                    $total = 0;
                    $status = "";
                    foreach($orders as $order) {
                        $total += $order['total_payment'];
                        $status = $order['status'];
                    }
                @endphp
                @endunless
                <h6 class="m-0 font-weight-bold text-primary">{{$status}} @if ($status == "delivery")
                    Grand Total {{$total}}
                @endif</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>OrderId</th>
                                <th>Name</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th id="sorter">Date</th>
                                <th>
                                    <img style="display:none" src="" alt="" onload="sort();">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>OrderId</th>
                                <th>Name</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @unless (count($orders) == 0)           
                            @foreach ($orders as $order)
                            <tr>
                                <td>{{$order->trans_code}}</td>
                                <td>{{$order->name}}</td>
                                <td>{{$order->total_payment}}</td>
                                <td>{{$order->status}}</td>
                                <td>{{$order->created_at}}</td>
                                <td>
                                    <p hidden >{{$order->id}}</p>
                                    <div>
                                        <form method="POST" action="/orderstat/{{$order->id}}">
                                        @csrf
                                            <a type="button" class="btn btn-info" href="/orderdetails/{{$order->id}}">Details</a>
                                            @if($order->status == "cancel"||$order->status == "delivered")
                                                <select name="orderstat" id="orderstat" class="btn btn-secondary ml-1" disabled onchange="this.form.submit()">
                                                    <option  class="bg-light text-dark" selected>Select status</option>
                                                    <option  class="bg-light text-dark" value="preparing for delivery">Approve</option>
                                                    <option  class="bg-light text-dark" value="delivery">On Delivery</option>
                                                    <option  class="bg-light text-dark" value="delivered">Delivered</option>
                                                    <option  class="bg-light text-dark" value="failed">Failed</option>
                                                    <option  class="bg-light text-dark"  value="cancel">Cancel</option>
                                                </select>
                                            @elseif($order->status == "failed")
                                                <select name="orderstat" id="orderstat" class="btn btn-warning ml-1" onchange="this.form.submit()">
                                                    <option  class="bg-light text-dark" selected>Select status</option>
                                                    <option  class="bg-light text-dark" disabled value="preparing for delivery">Approve</option>
                                                    <option  class="bg-light text-dark" disabled value="delivery">On Delivery</option>
                                                    <option  class="bg-light text-dark" value="delivered">Delivered</option>
                                                    <option  class="bg-light text-dark" disabled value="failed">Failed</option>
                                                    <option  class="bg-light text-dark"  value="cancel">Cancel</option>
                                                </select>
                                            @elseif($order->status == "for approval")
                                            <select name="orderstat" id="orderstat" class="btn btn-danger ml-1" onchange="this.form.submit()">
                                                <option  class="bg-light text-dark" selected>Select status</option>
                                                <option  class="bg-light text-dark" value="preparing for delivery">Approve</option>
                                                <option  class="bg-light text-dark" disabled value="delivery">On Delivery</option>
                                                <option  class="bg-light text-dark" disabled value="delivered">Delivered</option>
                                                <option  class="bg-light text-dark" disabled value="failed">Failed</option>
                                                <option  class="bg-light text-dark" value="cancel">Cancel</option>
                                            </select>
                                            @elseif($order->status == "preparing for delivery")
                                            <select name="orderstat" id="orderstat" class="btn btn-danger ml-1" onchange="this.form.submit()">
                                                <option  class="bg-light text-dark" selected>Select status</option>
                                                <option  class="bg-light text-dark" disabled value="preparing for delivery">Approve</option>
                                                <option  class="bg-light text-dark" value="delivery">On Delivery</option>
                                                <option  class="bg-light text-dark" disabled value="delivered">Delivered</option>
                                                <option  class="bg-light text-dark" disabled value="failed">Failed</option>
                                                <option  class="bg-light text-dark" value="cancel">Cancel</option>
                                            </select>
                                            @else
                                            <select name="orderstat" id="orderstat" class="btn btn-danger ml-1" onchange="this.form.submit()">
                                                <option  class="bg-light text-dark" selected>Select status</option>
                                                <option  class="bg-light text-dark" disabled value="preparing for delivery">Approve</option>
                                                <option  class="bg-light text-dark" disabled value="delivery">On Delivery</option>
                                                <option  class="bg-light text-dark" value="delivered">Delivered</option>
                                                <option  class="bg-light text-dark" value="failed">Failed</option>
                                                <option  class="bg-light text-dark" value="cancel">Cancel</option>
                                            </select>
                                            @endif
                                        </form>
                                    </div>
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
    
    <script>
        let p1 = document.getElementById('dash-admin').innerHTML;
        let p2 = document.getElementById('admin-title');
        p2.innerHTML = p1
        
    </script>

</x-layout>