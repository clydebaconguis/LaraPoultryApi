<x-layout>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Account</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Gcash & Passcode</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Number</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                             @unless (count($accounts) == 0)           
                                @foreach ($accounts as $item)
                                    <tr>
                                        <td>{{$item->num}}</td>
                                        <td>{{$item->passcode}}</td>
                                            {{-- <form method="GET" action="/verify/{{$user->id}}">
                                                @csrf
                                                <input type="hidden" name="stat" value="1" >
                                                <a type="button" onclick="this.form.submit()" class="btn btn-info">Approve</a>
                                            </form> --}}
                                        <td><a type="button" class="btn btn-info" href="/editaccount/{{$item->id}}/edit">Edit</a></td>
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