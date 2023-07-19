@extends('master')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-6 offset-3">
                <div class="">
                    <a href="{{ route('post#update', $post[0]['id']) }}" class="text-black">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row ">
            <div class="col-6 offset-3">
                <form action="{{ route('update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <label class="mt-3" for="">Post title</label>
                    <input type="hidden" name="postId" value="{{ $post[0]['id'] }}">
                    <input type="text" name="postTitle" class="form-control  @error('postTitle') is-invalid @enderror"
                        value="{{ old('postTitle', $post[0]['title']) }}" placeholder="Enter post title...">
                    @error('postTitle')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="my-3">
                        <h6>Image</h6>
                        @if ($post[0]['image'] == null)
                            <img src="{{ asset('img_not_found.png') }}" class="img-thumbnail w-75 mb-4">
                        @else
                            <img src="{{ asset('storage/' . $post[0]['image']) }}" class="img-thumbnail w-75 mb-4">
                        @endif
                        <input type="file" name="postImage"
                            class="form-control @error('postImage') is-invalid  @enderror" value="{{ old('postImage') }}">
                        @error('postImage')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <label class="mt-3" for="">Post Description</label>
                    <textarea class="form-control @error('postDescription') is-invalid @enderror" name="postDescription" id=""
                        cols="30" rows="10" placeholder="Enter post description">{{ old('postDescription', $post[0]['description']) }}</textarea>
                    @error('postDescription')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="text-group mt-3">
                        <label for="">Post Fee</label>
                        <input type="number" name="postFee" class="form-control" placeholder="Enter Post Fee"
                            value="{{ old('postFee', $post[0]['price']) }}">
                    </div>
                    <div class="text-group mt-3">
                        <label for="">Post Address</label>
                        <input type="text" name="postAddress" class="form-control" placeholder="Enter Post Address"
                            value="{{ old('postAddress', $post[0]['address']) }}">
                    </div>

                    <div class="text-group mt-3">
                        <label for="">post rating</label>
                        <input type="number" name="postrating" min="0" max="5" class="form-control"
                            placeholder="enter post rating" value="{{ old('postrating', $post[0]['rating']) }}">
                    </div>

                    <input type="submit" value="Update" class="btn btn-dark float-end my-3 ">
                </form>
            </div>
        </div>


    </div>
@endsection
