@extends('layout.app')

@section('title', 'terms')

@section('content')
    <div class="row">
        <div class="col-3">
            @include('shared.left-sidebar')
        </div>
        <div class="col-6">
            <h1>Terms</h1>
            <div>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Non totam distinctio eum exercitationem laudantium,
                in saepe nulla numquam consequuntur quam quo error tenetur vero veritatis, ipsam dicta laborum quasi
                facilis?
            </div>
        </div>
        <div class="col-3">
            @include('shared.search-bar')
            @include('shared.follow-box')
        </div>

    </div>
@endsection
