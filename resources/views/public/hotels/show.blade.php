@extends('layouts.app')

@section('title', 'Hotel {{$hotel->name}}')

@section('content')
<a href="/hotels">Volver a hoteles</a>
    <h1>Title: {{$hotel->name}}</h1>
    <p>
        <b>address:</b> {{$hotel->address}} <br>
        <b>contacto:</b> {{$hotel->email}} <br>
        <b>Estrellas:</b> {{$hotel->stars}} <br>
    </p>
    <p>
        {{$hotel->description}}

    </p>
@endsection
