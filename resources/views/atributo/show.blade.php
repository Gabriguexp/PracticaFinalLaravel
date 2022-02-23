@extends('base')
@section('content')
<h2>{{$atributo->nombre}}</h2>

@if(Session::has('message'))

<div class="alert alert-{{session()->get('type')}}">
    {{ session()->get('message')}}
</div>
@endif
<table class="table">
    <thead class="thead">
        <tr>
            <td>ID</td>
            <td>Nombre</td>
            <td>Descripcion</td>
            <td>Tipo</td>
            <td>Editar</td>
            <td>Borrar</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $atributo->id }}</td>
            <td>{{ $atributo->nombre }}</td>
            <td>{{ $atributo->descripcion }}</td>
            
            <td>{{ $atributo->tipo }}</td>
            
            <td><a href="{{url('atributo/'. $atributo->id . '/edit')}}">Editar</a></td>
            <td>Delete</td>
        </tr>
        
    </tbody>
</table>

<div>
    <h4>Fichas con el atributo {{ $atributo->nombre}}</h4>
    <ul class="list-group">
        @foreach ($atributo->fichas()->get() as $ficha)
        <li class="list-group-item"><a href="{{url('ficha/'. $ficha->id)}}">{{ $ficha->nombre }}</a></li>
        @endforeach
    </ul>
</div>

@endsection