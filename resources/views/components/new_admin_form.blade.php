<x-card>
    <header class="text-center">
        <h2 class="text-center text-lg mb-5">
            Create New Admin
        </h2>
    </header>

    @if(session()->has('message')) <p class="alert alert-success">{{session('message')}}</p> @endif

    <div class="content">
    <div class="col-sm-12 justify-content-center flex">
    <div class="card col-sm-10 p-4">
        <form method="POST" action="/new-admin" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control" id="name" name="name" type="text">
                @error('name')
                    <p class="alert alert-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" >
                @error('email')
                    <p class="alert alert-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="text" class="form-control" name="password" id="password" >
                @error('password')
                    <p class="alert alert-danger">{{$message}}</p>
                @enderror
            </div>
                
            <button type="submit" class="btn btn-primary">Submit</button>
            {{-- <a href="/users" class="text-dark ml-2"> Back </a> --}}
        </form>
    </div>
    </div>
    </div>
</x-card>
