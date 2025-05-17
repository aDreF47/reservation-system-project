@extends('layouts.admin')

@section('title', 'show usuario')

@section('content')
    <h1>Usuario especifico</h1>
    <p><b>nombre: </b>{{$user->name}}</p>
    <p><b>email: </b>{{$user->email}}</p>
    <p><b>rol: </b>{{$user->role}}</p>
@endsection
