@extends('adminlte::page')

@section('title', 'Proyecto RSU')
    

@section('content_header')
    <h1>Nueva marca</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        {!! Form::open(['route' => 'admin.brands.store']) !!}
        @include('admin.brands.template.form')
        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>Registrar</button>
        <a href="{{ route('admin.brands.index')}}" class="btn btn-danger"><i class="fas fa-angle-double-left"></i></i>Cancelar</a>
        {!! Form::close() !!}
    </div>
</div>
@endsection