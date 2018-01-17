@extends('layouts.app')
@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- will be used to show any messages -->
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
                <div class="form-group style="margin-bottom: 10px;"">
                    <a href="/users/create" type="submit" class="btn btn-success" >Add User</a>
                </div>
                <div class="panel panel-default">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Username</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Password</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>

                        </tr>
                        </thead>
                        <tbody>

                        @php
                            $i=0
                        @endphp

                        @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{$i+=1}}</th>
                                <td>{!! $user['name'] !!}</td>
                                <td>{!! $user['email'] !!}</td>
                                <td></td>
                                <td><a href="/admin/users/{{$user['id']}}/edit " type="button" class="btn btn-primary">Edit</a></td>
                                <td>
                                    @if(Auth::user()->id !=  $user['id'])
                                        {{ Form::open(array('url' => 'users/' . $user['id'])) }}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                        {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                                        {{ Form::close() }}
                                    @endif

                                </td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection