@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Send message</th>
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
                            <td><button type="button"  data-id = {!! $user['id'] !!}  data-name="{!! $user['name'] !!}" class="btn btn-success chat-boxp enable">Open Box Chat</button></td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="live-chat" style="display: none">

    <header class="clearfix">

        <a href="#" class="chat-close">x</a>

        <h4 class="send-user-name">John Doe</h4>

        <span class="chat-message-counter">3</span>

    </header>

    <div class="chat">

        <div class="chat-history">
        </div> <!-- end chat-history -->
        <div class="send-inp">
            <fieldset>
                <input type="text" placeholder="Type your message…" data-to_id="" class="send" autofocus>
            </fieldset>
        </div>
    </div> <!-- end chat -->

</div> <!-- end live-chat -->
@endsection
