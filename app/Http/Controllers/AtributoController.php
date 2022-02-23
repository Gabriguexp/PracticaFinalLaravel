<?php

namespace App\Http\Controllers;

use App\Models\Atributo;
use App\Models\Ficha;
use Illuminate\Http\Request;
use App\Http\Requests\AtributoCreateRequest;
use App\Http\Requests\AtributoEditRequest;

class AtributoController extends Controller
{
        
    public function __construct() {
        $this->middleware('verified');
        $this->middleware('adminmiddleware')->only(['create', 'edit', 'update', 'delete', 'store']);
    }
        

    public function index(Request $request)
    {
        $data = [];
        $data['appendData'] = [];
        $search = $request->input('search') ? $request->input('search') : '';
        $type = $request->input('filter') ? $request->input('filter') : 'id';;
        $order = $request->input('order') ? $request->input('order') : 'asc';
        $data['filters'] = ['nombre' =>'Nombre','tipo' => 'Tipo'];
        $orderby = $request->input('orderby') ? $request->input('orderby') : 'id';
        $appendData = ['filter' => $type, 'order' => $order, 'search'=> $search, 'orderby' => $orderby];
        $data['appendData'] = $appendData;
        $atributo = Atributo::where($type, 'like', '%'.$search.'%')->orderBy($orderby, $order)->paginate(5)->appends($appendData);
        $data['atributos'] = $atributo;
        $data['filterselected'] = $type;
        $data['searchvalue'] = $search;
        // dd($data);
        return view('atributo.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        return view('atributo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AtributoCreateRequest $request)
    {
        
        $data = [];
        try{
            $atributo = new Atributo($request->all());
            $atributo->save();
            $data['type'] = 'success';
            $data['message'] = 'Atributo creado';
            return redirect('atributo')->with($data);
        } catch(\Exception $e){
            dd($e);
            $data['type'] = 'danger';
            $data['message'] = 'Error al crear el atributo';
            return back()->withInput()->with($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Atributo  $atributo
     * @return \Illuminate\Http\Response
     */
    public function show(Atributo $atributo)
    {
        $data = [];
        $data['atributo'] = $atributo;
        return view('atributo.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Atributo  $atributo
     * @return \Illuminate\Http\Response
     */
    public function edit(Atributo $atributo) {
        $data = [];
        
        $data['atributo'] = $atributo;
        //$data['fichas'] = ;
        
        return view('atributo.edit')->with($data); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Atributo  $atributo
     * @return \Illuminate\Http\Response
     */
    public function update(AtributoEditRequest $request, Atributo $atributo){
        $data =[];
        try {
            $result = $atributo->update($request->all());
            $data['type'] = 'success';
            $data['message'] = 'Atributo actualizado';
            return redirect('atributo')->with($data);
        } catch(\Exception $e){
            $data['type'] = 'error';
            $data['message'] = 'No se ha podido actualizar el atributo';
            return redirect('atributo')->with($data);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Atributo  $atributo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Atributo $atributo) {
        $data =[];
        try{
            $atributo->delete();
            $data['type'] = 'success';
            $data['message'] = 'Atributo borrado';
            return redirect('atributo')->with($data);
        } catch(\Exception $e){
            $data['type'] = 'error';
            $data['message'] = 'No se ha podido borrar el atributo';
            return redirect('atributo')->with($data);
            
        }
    }
}
