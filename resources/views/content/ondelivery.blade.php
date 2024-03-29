<x-layout>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Orders</h1>

        @if(session()->has('message')) <p class="alert alert-success">{{session('message')}}</p> @endif

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="d-flex justify-content-between card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Poultry</h6>
                <a class="btn btn-primary ms-5" href="/forapproval">For Approval</a>
                <a class="btn btn-primary ms-5" href="/preparing">Preparing for Delivery</a>
                <a class="btn btn-primary ms-5" href="/ondelivery">On Deliverey</a>
                <a class="btn btn-primary ms-5" href="/delivered">Delivered</a>
            </div>
            @php
                $total = 0;
                $status = "";
            @endphp
            <div class="card-header py-3">
                @unless (count($orders) == 0)        
                @php
                    
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
        {{-- <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Completed</h6>
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
                            @if ($order->status == "delivered")
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
                            @endif
                            @endforeach
                            @endunless
                        </tbody>
                    </table>
                </div>
            </div>
        </div> --}}
    </div>
    <script>
        window.onload = function(){
            // alert('yawa ka');
            var sorter = document.getElementById('sorter');
            for(let i = 0; i < 2; i++){
                sorter.click();
            }
        }
        // function sort(){
        //     
        // }
    </script>
</x-layout>
