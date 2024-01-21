@extends('layouts.app')
@section('content')
<div class="container">
    @if(Session::has('success'))
    <div class="alert alert-success w-25">
        {{ Session::get('success') }}
    </div>
    @endif
    <p>
        <a class="btn btn-primary" href="{{route('categories.create')}}"><span class="glyphicon glyphicon-plus"></span> Add Category</a>
    </p>
    <table class="table table-bordered table-hover">
        <thead>
            <th>#</th>
            <th>@sortablelink('name','Name')</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @if ($categories->count() == 0)
            <tr>
                <td colspan="5">No categories to display.</td>
            </tr>
            @endif

            @foreach ($categories as $category)
            <tr>
                <td> {{$loop->iteration + $categories->firstItem() - 1}}</td>

                <td>{{ $category->name }}</td>
                <td class=" d-flex">

                    <a class="btn btn-sm btn-success" href="{{route('categories.edit',$category->id)}}">Edit</a>


                    <form action="{{route('categories.destroy',$category->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class=" btn btn-danger ms-3" onclick="return confirm('Are you sure you want to delete this item?');">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $categories->appends(Request::except('page'))->render() !!}
    <p>
        Displaying {{$categories->count()}} of {{ $categories->total() }} product(s).
    </p>


</div>
@endsection
