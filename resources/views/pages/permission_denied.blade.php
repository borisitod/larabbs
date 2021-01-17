@extends('layouts.app')
@section('title', 'Permission denied')

@section('content')
    <div class="col-md-4 offset-md-4">
        <div class="card ">
            <div class="card-body">
                @if (Auth::check())
                    <div class="alert alert-danger text-center mb-0">
                        The current login account has no access permission.
                    </div>
                @else
                    <div class="alert alert-danger text-center">
                        Please log in to proceed
                    </div>

                    <a class="btn btn-lg btn-primary btn-block" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt"></i>
                        Login
                    </a>
                @endif
            </div>
        </div>
    </div>
@stop
