@extends('layouts.app')
@section('content')
    <div class="container">
        <h2>Add user</h2>


        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        @if ($errors->any())
            <hr/>
            <ul class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        {{ Form::open(array('url' => 'users')) }}


            <div class="form-group">
                <label for="usr">Name:</label>
                <input type="text" class="form-control" name="name" id="usr" value="">
            </div>
            <div class="form-group">
                <label for="pwd">E-mail:</label>
                <input type="email" class="form-control" id="pwd" name="email"  value="">
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="text" name="password" class="form-control" id="pwd" value="">
            </div>
            <div class="form-group" style="text-align: right;">
                <button type="submit" class="btn btn-success" >Add User</button>
            </div>

        {{ Form::close() }}


    </div>
@endsection