@extends('layouts.master')

@section('page', 'categories')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>@lang('library.all-books')</h1>
        <a href="" class="btn btn-secondary">@lang('library.add-book') </a>
    </div>
    <table class="table table-bordered table-striped table-hover">
        <tr class="table-secondary">
            <th>#</th>
            <th>name</th>
            <th>book count</th>
            <th>action</th>
        </tr>
        @foreach ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->books_count }}</td>
                <td>
                    <a href="" class="btn btn-sm btn-primary">Edit</a>
                    <form action="" method="post" class="d-inline-block">
                        <button class="btn btn-sm btn-danger">delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
