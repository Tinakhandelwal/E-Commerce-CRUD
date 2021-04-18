@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Recycle Bin</h2>
            </div>
        </div>
    </div>

    <div class="pull-left ">
        <a class="btn btn-success" href="{{ route('category.index') }}" title="Back to Index"> <i class="fas fa-home"></i> </a>
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

                    <a href="{{ route('restoreDeletedProjects', $category->id) }}" title="restore project">
                        <i class="fas fa-window-restore text-success  fa-lg"></i>
                    </a>
                    <a href="{{ route('deletePermanently', $category->id) }}" title="Permanently delete">
                        <i class="fas fa-trash text-danger  fa-lg"></i>
                    </a>
                    </div>
                </div>

                @if ($category->sub)
                    <ul class="list-group mt-2">
                    @foreach ($category->sub as $child)
                        <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            {{ $child->name }}

                            <div class="button-group d-flex">
                            </div>
                        </div>
                        @if ($child->sub)
                    <ul class="list-group mt-2">
                    @foreach ($child->sub as $childs)
                        <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            {{ $childs->name }}

                            <div class="button-group d-flex">
                            </div>
                        </div>
                        @if ($childs->sub)
                    <ul class="list-group mt-2">
                    @foreach ($childs->sub as $ch)
                        <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            {{ $ch->name }}

                            <div class="button-group d-flex">
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


