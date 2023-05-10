<x-layout>
    <x-card>
        <header class="text-center">
            <h2 class="text-center text-lg mb-5">
                Update a Accounts
            </h2>
        </header>

        @if(session()->has('message')) <p class="alert alert-success">{{session('message')}}</p> @endif

        <div class="content">
        <div class="col-sm-12 justify-content-center flex">
        <div class="card col-sm-10 p-4">
            <form method="POST" name="myform" id="myform" action="/updateaccount/{{$detail->id}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="prodname">Number</label>
                    <input class="form-control" value="{{$detail->num}}" id="prodname" name="name" type="text" placeholder="Product Name">
                </div>
                <div class="form-group">
                        <label for="stock">Passcode</label>
                        <input type="number" value="{{$detail->passcode}}" class="form-control" name="stock" id="stock" placeholder="Stock">
                </div>

                <button type="submit" class="btn btn-primary" >Submit</button>
                <a href="/products" class="text-dark ml-2"> Back </a>
            </form>
        </div>
        </div>
        </div>
    </x-card>

</x-layout>
