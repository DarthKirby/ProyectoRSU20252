<div class="form-group">
    {!! Form::label('name', 'nombre') !!}
    {!! Form::text('name', null, ['class'=>'form-control','placeholder'=>'Hiunday','required']) !!}
</div>
<div class="form-group">
    {!! Form::label('description', 'Descripción') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Descripción']) !!}
</div>