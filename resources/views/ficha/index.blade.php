@extends('base')
@section('content')
<h2>Fichas</h2>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Borrar Ficha</h5>
        <button type="button" id="cross-modal-btn" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Estás a punto de borrar la ficha <span id="delete-item">asdf</span>
      </div>
      <div class="modal-footer">
        <button type="button" id="close-modal-btn" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" id="delete-modal-btn" class="btn btn-primary">Borrar</button>
      </div>
    </div>
  </div>
</div>

@if(Session::has('message'))
<div class="alert alert-{{session()->get('type')}}">
    {{ session()->get('message')}}
</div>
@endif
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

<form id="delete-form" method="POST" action="">
  @csrf
  @method('delete')
</form>
<table class="table" style="margin-top:30px">
    <thead class="thead-dark">
        <tr>
            <td scope="col">#</td>
            <td scope="col">
              <a href="{{ route('ficha.index',['orderby' =>'id', 'order'=>'asc', 'search' => $searchvalue, 'filter'=> $filterselected] ) }}"><i class="fa fa-arrow-up"></i></a>
              ID
              <a href="{{ route('ficha.index',['orderby' =>'id', 'order'=>'desc', 'search' => $searchvalue, 'filter'=> $filterselected] ) }}"><i class="fa fa-arrow-down"></i></a>
            </td>
            <td scope="col">
              <a href="{{ route('ficha.index',['orderby' =>'nombre', 'order'=>'asc', 'search' => $searchvalue, 'filter'=> $filterselected] ) }}"><i class="fa fa-arrow-up"></i></a>
              Nombre
              <a href="{{ route('ficha.index',['orderby' =>'nombre', 'order'=>'desc', 'search' => $searchvalue, 'filter'=> $filterselected] ) }}"><i class="fa fa-arrow-down"></i></a>
            </td>
            <td scope="col">
              <a href="{{ route('ficha.index',['orderby' =>'coste', 'order'=>'asc', 'search' => $searchvalue, 'filter'=> $filterselected] ) }}"><i class="fa fa-arrow-up"></i></a>
              Coste
              <a href="{{ route('ficha.index',['orderby' =>'coste', 'order'=>'desc', 'search' => $searchvalue, 'filter'=> $filterselected] ) }}"><i class="fa fa-arrow-down"></i></a>
            </td>
            <td scope="col">
              imagen
            </td>
            <td scope="col">
              Definitiva
            </td>
            <td scope="col">
              Ver
            </td>
            <td scope="col">
              Editar
            </td>
            <td scope="col">
              Borrar
            </td>
        </tr>
    </thead>
    <tbody>
        @foreach($fichas as $ficha)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $ficha->id }}</td>
            <td>{{ $ficha->nombre }}</td>
            <td>{{ $ficha->coste }}</td>
            <td><img width="150px" height="100px"alt="{{ $ficha->nombre }}" src="{{ url('storage/images/'. $ficha->id.'/'. $ficha->imagen) }}"></td>
            <td>{{ $ficha->ulti }}</td>
            <td><a href="{{url('ficha/'. $ficha->id)}}">Ver</a></td>
            <td><a href="{{url('ficha/'. $ficha->id . '/edit')}}">Editar</a></td>
            <td><a href="" data-name="{{ $ficha->nombre }}" data-id="{{ $ficha->id  }}" class="delete-btn">Delete</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $fichas->onEachSide(2)->links() }}

@if (auth()->user()->rol != 'user')
<a style="margin-top:50px"class="btn btn-primary" href="{{ url('ficha/create') }}">Añadir ficha</a>
@endif
@endsection
@section('js')
<script>
var myModal = new bootstrap.Modal(document.getElementById('exampleModal'))

$('.delete-btn').on('click', function(event){
  event.preventDefault();
  myModal.show();
  $('#delete-item').text($(this).data('name'))
  $("#delete-form").attr('action', 'ficha/'+$(this).data('id'));

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