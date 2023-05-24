<x-layout>
    <x-card>
        <header class="text-center">
            <h2 class="text-center text-lg mb-5">
                Create New Category
            </h2>
        </header>

        @if(session()->has('message')) <p class="alert alert-success">{{session('message')}}</p> @endif

        <div class="content">
        <div class="col-sm-12 justify-content-center flex">
        <div class="card col-sm-10 p-4">
            <form method="POST" action="/addtype" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input class="form-control" id="name" name="name" type="text">
                    @error('name')
                        <p class="alert alert-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="units">Unit</label>
                    <input class="form-control" id="units" name="units" type="text">
                    @error('units')
                        <p class="alert alert-danger">{{$message}}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="/types" class="text-dark ml-2"> Back </a>
            </form>
        </div>
        </div>
        </div>
    </x-card>
</x-layout>
