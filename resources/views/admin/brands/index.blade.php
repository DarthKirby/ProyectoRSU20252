@extends('adminlte::page')

@section('title', 'Proyecto RSU')

@section('content_header')
<button class="btn btn-success float-right" id="btnRegistrar"><i class="fas fa-plus"></i>Nueva Marca</button>
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
                        <td><img src="{{ asset($brand->logo == '' ? asset('storage/brand_logo/no-image-icon-6.png') : $brand->logo) }}" width="70px" height="50px" alt="{{ $brand->name }}"></td>
                        <td>{{ $brand->name }}</td>
                        <td>{{ $brand->description }}</td>
                        <td>{{ $brand->created_at }}</td>
                        <td>{{ $brand->updated_at }}</td>
                        <td><!--<a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-warning btn-sm btn-editar"><i class="fas fa-edit"></i></a></td>-->
                        <button class="btn btn-warning btn-sm btnEditar" id={{ $brand->id }}><i class="fas fa-pen"></i></button>
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

<div class="modal fade" id="modal" data-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Formulario de marcas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
    </div>
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
        
        $('#btnRegistrar').click(function(){
            $.ajax({
                url: "{{ route('admin.brands.create') }}",
                type: "GET",
                success: function(response){
                    $('#modal .modal-body').html(response);
                    $('#modal .modal-title').html("Nueva marca");
                    $('#modal').modal('show');
                }
            });
        });

        $(document).on('click','.btnEditar', function(){
            var id = $(this).attr('id');
            $.ajax({
                url: "{{ route('admin.brands.edit', 'id') }}".replace('id', id),
                type: "GET",
                success: function(response){
                    $('#modal .modal-body').html(response);
                    $('#modal .modal-title').html("Editar marca");
                    $('#modal').modal('show');
                }
            });
        });

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
