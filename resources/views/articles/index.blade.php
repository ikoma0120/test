@extends('layout')

@section('content')
<h1>Articles</h1>

<hr/>

@if (Auth::check())
        {!! link_to('articles/create', '新規作成', ['class' => 'btn btn-primary']) !!}
    @endif

    @foreach($articles as $article)
        ...
    @endforeach
@stop
