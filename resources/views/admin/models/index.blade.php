@extends('adminlte::page')

@section('title', 'Proyecto RSU')

@section('content_header')
<button class="btn btn-success float-right" id="btnRegistrar"><i class="fas fa-plus"></i>Nuevo Modelo</button>
<h1>Lista de Modelos</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped" id="table">
                <thead>
                    <tr>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>Descripción</th>
                        <th>Fecha Creación</th>
                        <th>Fecha Actualización</th>
                        <th width='20px'></th>
                        <th width='20px'></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($models as $model)
                    <tr>
                        <td>{{ $model->name }}</td>
                        <td>{{ $model->brandname }}</td>
                        <td>{{ $model->description }}</td>
                        <td>{{ $model->created_at }}</td>
                        <td>{{ $model->updated_at }}</td>
                        <td>
                        <button class="btn btn-warning btn-sm btnEditar" id={{ $model->id }}><i class="fas fa-pen"></i></button>
                        <td>
                            <form action="{{ route('admin.models.destroy', $model) }}" method="POST" class="frmDelete">
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
        <h5 class="modal-title" id="staticBackdropLabel">Formulario de modelos</h5>
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
        $(document).on('submit', '.frmDelete', function(e) {
            e.preventDefault();
            var form = $(this);
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
                    $.ajax({
                        url: form.attr('action'),
                        type: form.attr('method'),
                        data: form.serialize(),
                        success: function(response){
                            refreshTable();
                            Swal.fire({
                                title: "Proceso exitoso!",
                                text: response.message,
                                icon: "success",
                                draggable: true
                            });
                        },
                        error: function(response){
                            Swal.fire({
                                title: "Error!",
                                text: response.message,
                                icon: "error",
                                draggable: true
                            });
                        }
                    });
                }
            });
        })
        
        $('#btnRegistrar').click(function(){
            $.ajax({
                url: "{{ route('admin.models.create') }}",
                type: "GET",
                success: function(response){
                    $('#modal .modal-body').html(response);
                    $('#modal .modal-title').html("Nueva marca");
                    $('#modal').modal('show');
                    $('#modal form').on('submit', function(e){
                        e.preventDefault();
                        var form = $(this);
                        var formData = new FormData(this);
                        $.ajax({
                            "url": form.attr('action'),
                            "type": form.attr('method'),
                            "data": formData,
                            processData: false,
                            contentType: false,
                            success: function(response){
                                $('#modal').modal('hide');
                                refreshTable();
                                Swal.fire({
                                    title: "Proceso exitoso!",
                                    text: response.message,
                                    icon: "success",
                                    draggable: true
                                });
                            }
                        });
                    });
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

                    $('#modal form').on('submit', function(e){
                        e.preventDefault();
                        var form = $(this);
                        var formData = new FormData(this);
                        $.ajax({
                            "url": form.attr('action'),
                            "type": form.attr('method'),
                            "data": formData,
                            processData: false,
                            contentType: false,
                            success: function(response){
                                $('#modal').modal('hide');
                                refreshTable();
                                Swal.fire({
                                    title: "Proceso exitoso!",
                                    text: response.message,
                                    icon: "success",
                                    draggable: true
                                });
                            }
                        });
                    });
                }
            });
        });

        $(document).ready(function() {
            $('#table').DataTable({
                "ajax":"{{ route('admin.models.index') }}",
                "columns": [
                    {
                        "data":"name",
                    },
                    {
                        "data":"brandname",
                    },
                    {
                        "data":"description",
                    },
                    {
                        "data":"created_at",
                    },
                    {
                        "data":"updated_at",
                    },
                    {
                        "data":"edit",
                        "orderable": false,
                        "searchable": false
                    },
                    {
                        "data":"delete",
                        "orderable": false,
                        "searchable": false
                    }
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                }
            });
        });

        function refreshTable() {
            var table = $('#table').DataTable();
            table.ajax.reload(null, false);
        }

    </script>
@endsection

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop
