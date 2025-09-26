@extends('adminlte::page')

@section('title', 'Proyecto RSU')

@section('content_header')
<a href="{{ route('admin.brands.create') }}" class="btn btn-success float-right"><i class="fas fa-plus"></i>Nueva Marca</a>
<h1>Lista de Marcas</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped" id="table">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Fecha Creación</th>
                        <th>Fecha Actualización</th>
                        <th width='20px'></th>
                        <th width='20px'></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($brands as $brand)
                    <tr>
                        <td>{{ $brand->logo }}</td>
                        <td>{{ $brand->name }}</td>
                        <td>{{ $brand->description }}</td>
                        <td>{{ $brand->created_at }}</td>
                        <td>{{ $brand->updated_at }}</td>
                        <td><a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a></td>
                        <td>
                            <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="frmDelete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script>
        $('.frmDelete').submit(function(e) {
            e.preventDefault();
            Swal.fire({
            title: "Estás seguro de eliminar?",
            text: 'Esto no se puede deshacer',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, eliminar!"
            }).then((result)  => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        })

        $(document).ready(function() {
            $('#table').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });
        });
    </script>
    @if (session('action') != null)
        <script>
            Swal.fire({
                title: "Proceso exitoso!",
                text: '{{ session("action") }}',
                icon: "success",
                draggable: true
            });
        </script>
    @endif
@endsection

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop
