<x-layout>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Account</h1>
        @if(session()->has('message')) <p class="alert alert-success">{{session('message')}}</p> @endif

        <form  method="POST" action="/addaccount" enctype="multipart/form-data">
            @csrf
            <div class="d-flex justify-content-between">
                <div>
                    <h4>Add New GCash</h4>
                    <div class="form-group">
                        <label for="num">Gcash</label>
                        <input type="text" class="form-control" name="num" id="num" required placeholder="Enter Number">
                    </div>
                    <input type="hidden" value="number" class="form-control" name="purpose" id="purpose">
                    <div>
                        <button type="submit" class="mb-4 btn btn-primary">Add</button>
                    </div>
                </div>
                <div>
                    <h4>Add New Admin</h4>
                    <div class="form-group">
                        <label for="username">Email</label>
                        <input type="email" class="form-control" name="username" id="username" required placeholder="Enter Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" class="form-control" name="password" id="password" required placeholder="Enter Password">
                    </div>
                    <div>
                        <input type="hidden" value="admin" class="form-control" name="purpose" id="purpose">
                        <button type="submit" class="mb-4 btn btn-primary">Add</button>
                    </div>
                </div>
            </div>
        </form>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Gcash & other payment number</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Number</th>
                                {{-- <th>Passcode</th> --}}
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Number</th>
                                {{-- <th>Passcode</th> --}}
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                             @unless (count($accounts) == 0)           
                                @foreach ($accounts as $item)
                                    <tr>
                                        <td>{{$item->num}}</td>
                                        {{-- <td>{{$item->passcode}}</td> --}}
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