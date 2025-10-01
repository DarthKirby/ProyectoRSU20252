{!! Form::model($brand, ['route' => ['admin.brands.update', $brand], 'method'=>'PUT', 'files'=>true]) !!}
@include('admin.brands.template.form')
<button type="submit" class="btn btn-success"><i class="fas fa-save"></i>Actualizar</button>
<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i>Cancelar</button>
{!! Form::close() !!}