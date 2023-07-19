@extends('master')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-5">
                <div class="p-3">
                    @if (session('insertSuccess'))
                        <div class="alert-message">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('insertSuccess') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    @if (session('UpdateSuccess'))
                        <div class="alert-message">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('UpdateSuccess') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('post#create') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="text-group mb-3">
                            <label for="">Post Title</label>
                            <input type="text" value="{{ old('postTitle') }}" name="postTitle"
                                class="form-control @error('postTitle') is-invalid @enderror"
                                placeholder="Enter Post Title">
                            @error('postTitle')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="text-group mb-3">
                            <label for="">Post Description</label>
                            <textarea name="postDescription" cols="30" rows="10"
                                class="form-control @error('postDescription') is-invalid @enderror" placeholder="Enter Post Description">{{ old('postDescription') }}</textarea>
                            @error('postDescription')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="text-group mb-3">
                            <label for="">Post Image</label>
                            <input type="file" name="postImage"
                                class="form-control @error('postImage') is-invalid  @enderror"
                                value="{{ old('postImage') }}">
                            @error('postImage')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="text-group mb-3">
                            <label for="">Post Fee</label>
                            <input type="number" name="postFee"
                                class="form-control  @error('postFee') is-invalid @enderror" placeholder="Enter Post Fee"
                                value="{{ old('postFee') }}">
                            @error('postFee')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="text-group mb-3">
                            <label for="">Post Address</label>
                            <input type="text" name="postAddress"
                                class="form-control @error('postAddress') is-invalid @enderror"
                                placeholder="Enter Post Address" value="{{ old('postAddress') }}">
                            @error('postAddress')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="text-group mb-3">
                            <label for="">post rating</label>
                            <input type="number" name="postrating" min="0" max="5"
                                class="form-control @error('postrating') is-invalid @enderror"
                                placeholder="enter post rating" value="{{ old('postrating') }}">
                            @error('postrating')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class=" mb-3">
                            <input type="submit" value="Create" class="btn btn-danger">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-7">
                <div class="d-flex justify-content-between align-content-center">
                    <div class="">
                        <h5 class="mt-1">Total posts-{{ $posts->total() }}</h5>
                    </div>
                    <form action="{{ route('post#createPage') }}" method="get">
                        <div class="">
                            <div class="input-group mb-3">
                                <input type="text" name="searchKey" class="form-control"
                                    value="{{ request('searchKey') }}" placeholder="Enter Search Key"
                                    aria-label="Enter Search Key" aria-describedby="basic-addon2">
                                <button type="submit" class="input-group-text" id="basic-addon2"><i
                                        class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                    </form>
                </div>
            </div>
            <div class="data-container">
                @if (count($posts) != 0)
                    @foreach ($posts as $item)
                        <div class="post p-3 shadow-sm mb-4">
                            <div class="mb-4">
                                <h4>{{ $item['title'] }}</h4>
                                <p>{{ $item['created_at'] }}</p>
                            </div>
                            {{-- <p>{{ $item['description'] }}</p> --}}
                            <p class="mt-3">{{ Str::words($item['description'], 20, '....') }}</p>
                            <span>
                                <i class="fa-solid fa-money-bill-wave text-primary"></i><small> {{ $item['price'] }}
                                    kyats</small>
                            </span> |
                            <span>
                                <small><i class="fa-solid fa-location-dot"></i> {{ $item['address'] }}</small> </span> |
                            <span>
                                <small><i class="fa-solid fa-star" style="color: #cee51f;"></i>
                                    {{ $item['rating'] }}</small>
                            </span>
                            <div class="text-end">
                                <a href="{{ url('post/delete/' . $item['id']) }}">
                                    <button class="btn"><i class="fa-solid fa-trash"></i></button>
                                </a>
                                <a href="{{ url('post/updatePage/' . $item['id']) }}">
                                    <button class="btn"><i class="fa-solid fa-file-lines"></i></button>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h3 class="text-danger text-center mt-5">There is no data!</h3>
                @endif


                {{-- for looping --}}
                {{-- @for ($i = 0; $i < count($posts); $i++)
                        <div class="post p-3 shadow-sm mb-4">
                            <h4>{{ $posts[$i]['title'] }}</h4>
                            <p>{{ $posts[$i]['description'] }}</p>
                            <div class="text-end">
                                <button class="btn btn-sm"><i class="fa-solid fa-trash"></i></button>
                                <button class="btn btn-sm"><i class="fa-solid fa-file-lines"></i></button>
                            </div>
                        </div>
                    @endfor --}}
            </div>
            {{ $posts->appends(request()->query())->links() }}
        </div>
    </div>
    </div>
@endsection
