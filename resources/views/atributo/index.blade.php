@extends('base')
@section('content')
<h2>Atributos</h2>
@if(Session::has('message'))

<div class="alert alert-{{session()->get('type')}}">
    {{ session()->get('message')}}
</div>
@endif
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Borrar Atributo</h5>
        <button type="button" id="cross-modal-btn" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Estás a punto de borrar el atributo <span id="delete-item">asdf</span>
      </div>
      <div class="modal-footer">
        <button type="button" id="close-modal-btn" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" id="delete-modal-btn" class="btn btn-primary">Borrar</button>
      </div>
    </div>
  </div>
</div>

<form id="delete-form" method="POST" action="">
  @csrf
  @method('delete')
</form>

<form class="form-inline" action="{{ $rutaSearch ?? '' }}" method="get">
<div class="input-group">
  <div class="form-outline">
    @foreach($appendData as $name => $value)
    
    <input type="hidden" name="{{$name}}" value="{{$value}}">
    @endforeach
    
    <select name="filter" class="form-select">
      <option value="" disabled selected>Filtro</option>
      @foreach($filters as $filter => $filterdata)
      @if ($filter == $appendData['filter'])
      <option selected value="{{ $filter }}">{{ $filterdata }}</option>
      @else
      <option value="{{ $filter }}">{{ $filterdata }}</option>
      @endif
      @endforeach
    </select>
    <input placeholder="Search..."type="search" id="form1" value="{{$appendData['search']}}"name="search" class="form-control" />
    
  </div>
  <button type="submit" style="margin-left:5px" type="button" class="btn btn-primary">
    <i class="fas fa-search"></i>
  </button>
</div>
</form>

<table style="margin-top:40px"class="table">
    <thead class="thead">
        <tr>
            <td>#</td>
            
            <td>
              <a href="{{ route('atributo.index',['orderby' =>'id', 'order'=>'asc', 'search' => $searchvalue, 'filter'=> $filterselected] ) }}"><i class="fa fa-arrow-up"></i></a>
              ID
              <a href="{{ route('atributo.index',['orderby' =>'id', 'order'=>'desc', 'search' => $searchvalue, 'filter'=> $filterselected] ) }}"><i class="fa fa-arrow-down"></i></a>
            </td>
            <td>
              <a href="{{ route('atributo.index',['orderby' =>'nombre', 'order'=>'asc', 'search' => $searchvalue, 'filter'=> $filterselected] ) }}"><i class="fa fa-arrow-up"></i></a>
              Nombre
              <a href="{{ route('atributo.index',['orderby' =>'nombre', 'order'=>'desc', 'search' => $searchvalue, 'filter'=> $filterselected] ) }}"><i class="fa fa-arrow-down"></i></a> 
            </td>
            <td>
              <a href="{{ route('atributo.index',['orderby' =>'tipo', 'order'=>'asc', 'search' => $searchvalue, 'filter'=> $filterselected] ) }}"><i class="fa fa-arrow-up"></i></a>
              Tipo
              <a href="{{ route('atributo.index',['orderby' =>'tipo', 'order'=>'desc', 'search' => $searchvalue, 'filter'=> $filterselected] ) }}"><i class="fa fa-arrow-down"></i></a> 
            </td>
            
            <td>Ver</td>
            @if (auth()->user()->rol != 'user')
            <td>Editar</td>
            <td>Borrar</td>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($atributos as $atributo)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $atributo->id }}</td>
            <td>{{ $atributo->nombre }}</td>
            <!--<td>{{ $atributo->descripcion }}</td>-->
            
            <td>{{ $atributo->tipo }}</td>
            <td><a href="{{url('atributo/'. $atributo->id)}}">Ver</a></td>
            @if (auth()->user()->rol != 'user')
            <td><a href="{{url('atributo/'. $atributo->id . '/edit')}}">Editar</a></td>
            <td><a href="" data-name="{{ $atributo->nombre }}" data-id="{{ $atributo->id  }}" class="delete-btn">Delete</a></td>
            @endif
        </tr>
        @endforeach
    </tbody>
    
    
</table>

{{ $atributos->onEachSide(2)->links() }}

@if (auth()->user()->rol != 'user')
<a style="margin-top:30px" class="btn btn-primary" href="{{ url('atributo/create') }}">Añadir Atributo</a>
@endif
@endsection

@section('js')
<script>
var myModal = new bootstrap.Modal(document.getElementById('exampleModal'))

$('.delete-btn').on('click', function(event){
  event.preventDefault();
  myModal.show();
  $('#delete-item').text($(this).data('name'))
  $("#delete-form").attr('action', 'atributo/'+$(this).data('id'));

})

$('#close-modal-btn').on('click', function(){
  myModal.toggle();
})

$('#cross-modal-btn').on('click', function(){
  myModal.toggle();
})

$('#delete-modal-btn').on('click', function() {
  console.log("asdf")
  
    $("#delete-form").submit();
})
</script>
@endsection