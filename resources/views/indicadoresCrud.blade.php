@extends('inicio')
@section('content')
      
<div class="card">
    <div class="card-header">
    <h1 text-align: center>CRUD Indicadores</h1>
    </div>
    <div class="card-body">
    <a class="btn btn-success" href="javascript:void(0)" id="createNewIndicador"> Crear Nuevo Indicador</a>
    <br></br>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Código</th>
                <th>Unidad de Medida</th>
                <th>Valor</th>
                <th>Fecha</th>
                <th>Tiempo</th>
                <th>Origen</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
</div>
     
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="formularioIndicador" name="formularioIndicador" class="form-horizontal">
                   <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="nombreIndicador" class="col-sm-2 control-label">Nombre</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nombreIndicador" name="nombreIndicador" placeholder="Ingrese Nombre" value="" maxlength="50" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="codigoIndicador" class="col-sm-2 control-label">Código</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="codigoIndicador" name="codigoIndicador" placeholder="Ingrese Código" value="" maxlength="50" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="unidadMedidaIndicador" class="col-sm-6 control-label">Unidad de Medida</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="unidadMedidaIndicador" name="unidadMedidaIndicador" placeholder="Ingrese Unidad de Medida" value="" maxlength="50" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="valorIndicador" class="col-sm-2 control-label">Valor</label>
                        <div class="col-sm-12">
                            <input type="number" step="any" class="form-control" id="valorIndicador" name="valorIndicador" placeholder="Ingrese Valor" value="" maxlength="50" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="fechaIndicador" class="col-sm-2 control-label">Fecha</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="fechaIndicador" name="fechaIndicador" placeholder="Ingrese Fecha" value="" maxlength="50" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tiempoIndicador" class="col-sm-2 control-label">Tiempo</label>
                        <div class="col-sm-12">
                            <input type="time" class="form-control" id="tiempoIndicador" name="tiempoIndicador" placeholder="Ingrese Tiempo" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="origenIndicador" class="col-sm-2 control-label">Origen</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="origenIndicador" name="origenIndicador" placeholder="Ingrese Origen" value="" maxlength="50" required>
                        </div>
                    </div>
        
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Guardar Cambios
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
      
@endsection
      
@section('scripts')
@parent
<script type="text/javascript">
  $(function () {
      
    /* Header Token */ 
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
      
    /* Datatable */
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('indicadores-crud.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nombreIndicador', name: 'nombreIndicador'},
            {data: 'codigoIndicador', name: 'codigoIndicador'},
            {data: 'unidadMedidaIndicador', name: 'unidadMedidaIndicador'},
            {data: 'valorIndicador', name: 'valorIndicador'},
            {data: 'fechaIndicador', name: 'fechaIndicador'},
            {data: 'tiempoIndicador', name: 'tiempoIndicador'},
            {data: 'origenIndicador', name: 'origenIndicador'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
      
    /* Click crear indicador  */
    $('#createNewIndicador').click(function () {
        $('#saveBtn').val("create-indicador");
        $('#id').val('');
        $('#formularioIndicador').trigger("reset");
        $('#modelHeading').html("Crear Nuevo Indicador");
        $('#ajaxModel').modal('show');
    });
      
    /* Click Editar indicador */
    $('body').on('click', '.editIndicador', function () {
      var id = $(this).data('id');
      $.get("{{ route('indicadores-crud.index') }}" +'/' + id +'/edit', function (data) {
          $('#modelHeading').html("Editar Indicador");
          $('#saveBtn').val("edit-indicador");
          $('#ajaxModel').modal('show');
          $('#id').val(data.id);
          $('#nombreIndicador').val(data.nombreIndicador);
          $('#codigoIndicador').val(data.codigoIndicador);
          $('#unidadMedidaIndicador').val(data.unidadMedidaIndicador);
          $('#valorIndicador').val(data.valorIndicador);
          $('#fechaIndicador').val(data.fechaIndicador);
          $('#tiempoIndicador').val(data.tiempoIndicador);
          $('#origenIndicador').val(data.origenIndicador);
      })
    });
      
    //* Crear indicador */
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
      
        $.ajax({
          data: $('#formularioIndicador').serialize(),
          url: "{{ route('indicadores-crud.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
       
              $('#formularioIndicador').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Guardar Cambios');
          }
      });
    });
      
    /* Eliminar indicador */
    $('body').on('click', '.deleteIndicador', function () {
     
        var id = $(this).data("id");
        if(confirm("Seguro que quiere eliminar el indicador?")){
            $.ajax({
            type: "DELETE",
            url: "{{ route('indicadores-crud.store') }}"+'/'+id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
            });
            alert("Indicador eliminado correctamente");
        }else{
            alert("No se ha eliminado el indicador");
        }
        
        
        
    });
       
  });
</script>
@stop