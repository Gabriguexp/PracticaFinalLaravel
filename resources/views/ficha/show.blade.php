@extends('base')
@section('content')

@if(Session::has('message'))

<div class="alert alert-{{$type}}">
    {{ session()->get('message')}}
</div>
@endif

<h3>{{ $ficha->nombre }}</h3>
<div>
    <img width="400px" height="300px" alt="{{ $ficha->nombre }}" src="{{ url('storage/images/'. $ficha->id.'/'. $ficha->imagen) }}">
</div>
<table class="table">
    <thead>
        <tr>
            <td>Coste</td>
            <td>Vida</td>
            <td>Mana</td>
            <td>Poder de ataque</td>
            <td>Poder de habilidad</td>
            <td>Habilidad</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{$ficha->coste}}</td>
            <td>{{$ficha->vida}}</td>
            <td>{{$ficha->mana}}</td>
            <td>{{$ficha->ad}}</td>
            <td>{{$ficha->ap}}</td>
            <td>{{$ficha->ulti}}</td>
        </tr>
    </tbody>
</table>

<table class="table">
    <thead class="thead">
        <tr>Atributos</tr>
    </thead>
    <tbody>
        @foreach($ficha->atributos()->get() as $atributo)
        <tr>
                <td><a href="{{ url('atributo/'. $atributo->id) }}">{{$atributo->nombre }}</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection