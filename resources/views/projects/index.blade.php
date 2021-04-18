@extends('layouts.app')

@section('content')
    <div class="pull-left ">
        <a class="btn btn-success" href="{{ route('category.create') }}" title="Create a project"> <i class="fas fa-plus-circle"></i></a>
        <a class="btn btn-light" href="{{ route('getDeleteProjects') }}" title="View Deleted Projects"> <i class="fas fa-recycle"></i></a>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="row">
    <div class="col-md-12">
        <div class="card">
        <div class="card-header">
            <h3>Categories</h3>
        </div>
        <div class="card-body">
            <ul class="list-group">
            @foreach ($categories as $category)
                <li class="list-group-item">
                <div class="d-flex justify-content-between">
                    {{ $category->name }}

                    <div class="button-group d-flex">

                    <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                        <a href="{{ route('category.show', $category->id) }}" title="show"> <i class="fas fa-eye text-success fa-lg"></i></a>
                        <a href="{{ route('category.edit', $category->id) }}"> <i class="fas fa-edit  fa-lg"></i> </a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" title="delete" style="border: none; background-color:transparent;">
                            <i class="fas fa-trash fa-lg text-danger"></i>

                        </button>
                    </form>
                    </div>
                </div>

                @if ($category->sub)
                    <ul class="list-group mt-2">
                    @foreach ($category->sub as $child)
                        <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            {{ $child->name }}

                            <div class="button-group d-flex">
                            <form action="{{ route('category.destroy', $child->id) }}" method="POST">
                                <a href="{{ route('category.show', $child->id) }}" title="show"> <i class="fas fa-eye text-success fa-lg"></i></a>
                                <a href="{{ route('category.edit', $child->id) }}"> <i class="fas fa-edit  fa-lg"></i> </a>

                                @csrf
                                @method('DELETE')

                                <button type="submit" title="delete" style="border: none; background-color:transparent;">
                                    <i class="fas fa-trash fa-lg text-danger"></i>

                                </button>
                            </form>
                            </div>
                        </div>
                        @if ($child->sub)
                    <ul class="list-group mt-2">
                    @foreach ($child->sub as $childs)
                        <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            {{ $childs->name }}

                            <div class="button-group d-flex">
                            <form action="{{ route('category.destroy', $childs->id) }}" method="POST">
                                <a href="{{ route('category.show', $childs->id) }}" title="show"> <i class="fas fa-eye text-success fa-lg"></i></a>
                                <a href="{{ route('category.edit', $childs->id) }}"> <i class="fas fa-edit  fa-lg"></i> </a>

                                @csrf
                                @method('DELETE')

                                <button type="submit" title="delete" style="border: none; background-color:transparent;">
                                    <i class="fas fa-trash fa-lg text-danger"></i>

                                </button>
                            </form>
                            </div>
                        </div>
                        @if ($childs->sub)
                    <ul class="list-group mt-2">
                    @foreach ($childs->sub as $ch)
                        <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            {{ $ch->name }}

                            <div class="button-group d-flex">
                            <form action="{{ route('category.destroy', $ch->id) }}" method="POST">
                                <a href="{{ route('category.show', $ch->id) }}" title="show"> <i class="fas fa-eye text-success fa-lg"></i></a>
                                <a href="{{ route('category.edit', $ch->id) }}"> <i class="fas fa-edit  fa-lg"></i> </a>

                                @csrf
                                @method('DELETE')

                                <button type="submit" title="delete" style="border: none; background-color:transparent;">
                                    <i class="fas fa-trash fa-lg text-danger"></i>

                                </button>
                            </form>
                            </div>
                        </div>
                        </li>
                    @endforeach
                    </ul>
                @endif
                        </li>
                    @endforeach
                    </ul>
                @endif
                        </li>
                    @endforeach
                    </ul>
                @endif
                </li>
            @endforeach
            </ul>
        </div>
        </div>
    </div>
    </div>


@endsection