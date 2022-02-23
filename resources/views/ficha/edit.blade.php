@extends('base')
@section('content')
Edit Ficha
<script src="{{ url('assets/vendor/jquery/jquery.min.js') }}"></script>

@if(Session::has('message'))
<div class="alert alert-{{session()->get('type')}}">
    {{ session()->get('message')}}
</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{url('ficha/'. $ficha->id)}}" class="form" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="row">
        <div class="col-lg-6 d-none d-lg-block ">
            <div class="col-lg-6">
                
                <div class="form-group">
                    <input type="text" class="form-control " value="{{ $ficha->nombre }}" maxlenght="50" placeholder="Nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control " value="{{ $ficha->coste }}" placeholder="Coste" name="coste" min="1" max="5" required>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control " value="{{ $ficha->ad }}" min="1" placeholder="Daño de ataque" name="ad" required>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control " value="{{ $ficha->ap }}" min="1" placeholder="Poder de habilidad" name="ap" required>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control " value="{{ $ficha->vida }}" min="1" placeholder="Vida" name="vida" required>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control " value="{{ $ficha->mana }}" min="1" placeholder="Mana" name="mana" required>
                </div>
                <div class="form-group">
                    <textarea class="form-control " placeholder="Definitiva" name="ulti" required>{{ $ficha->ulti }}</textarea>
                </div>
                <div class="form-group">
                    <input id="imgInp" type="file" name="imagen" accept="image/*">
                </div>
                <input  type="submit" class="btn btn-primary" value="Actualizar">
            </div>
        </div>
        <div class="col-md-5" style="box-sizing:border-box;">
            <img id="img" width="100%" alt="{{ $ficha->nombre }}" src="{{ url('storage/images/'. $ficha->id.'/'. $ficha->imagen) }}">
        </div>

    </div>
            
        @foreach ($atributos as $atrib)
        
            <div class="form-group attribute-select" >
                <button class="btn btn-warning remove-btn">Borrar atributo</button>
                <label for="tipo">Atributo</label>
                <select required name="atributo[]">
                    @foreach($allatributos as $atributo)
                    
                    @if ($atributo->id == $atrib->id)
                    <option selected value="{{ $atributo->id }}">{{ $atributo->nombre }}</option>
                    @else
                    <option value="{{ $atributo->id }}">{{ $atributo->nombre }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        <br>
        @endforeach
</form>




<button id="add-btn" class="btn btn-info">Añadir atributo</button>

<div class="form-group attribute-select sample hidden" >
    <button class="btn btn-warning remove-btn">Borrar atributo</button>
    <label for="tipo">Atributo</label>
    <select required name="atributo[]">
        <option disabled selected value=""></option>
        @foreach($allatributos as $atributo)
        
        <option value="{{ $atributo->id }}">{{ $atributo->nombre }}</option>
        @endforeach
    </select>
</div>

<script>
    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgInp").change(function(){
    console.log("asdf")
    readURL(this);
});

$('.remove-btn').on('click', function(event){
    event.preventDefault()
    $(this).parent().remove()
})

$('#add-btn').on('click', function(event){
    console.log("moi calvo")
    event.preventDefault()
    let select = $('.sample').clone()
    console.log(select)
    select.removeClass('sample')
    select.removeClass('hidden')
    console.log(select)
    
    select.children('.remove-btn').on('click', function(event){
        event.preventDefault()
        $(this).parent().remove()
    })
    $('.form').append(select)
})



</script>
@endsection