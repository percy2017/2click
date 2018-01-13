<!-- Modal -->
<div class="modal fade" id="modal_cupon_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="{{ route('cupones.update',0) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <input type="text" id="id" name="id" hidden>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Editar Cupon</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <label>Codigo</label>
              <input type="text" class="form-control" id="codigo" name="codigo" required>
          </div>
          <div class="form-group">
              <label>Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre" required>
          </div>
          <div class="form-group">
              <label>descripcion</label>
              <textarea name="descripcion" class="form-control" id="descripcion" rows="3" required></textarea>
          </div>
          <div class="form-group">
              <label>Descuento en %</label>
              <input type="number" class="form-control" id="descuento" name="descuento" required>
          </div>
          <div class="form-group">
            <label for="">Habilitado</label>
            <br>
            <!-- <input type="checkbox" checked id="habilitado" name="habilitado" data-toggle="toggle" data-off="NO"> -->
            <input type="checkbox" checked id="habilitado" name="habilitado" data-toggle="toggle" data-on="SI" data-on="NO"> 
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Actulizar</button>
        </div>
      </form>
    </div>
  </div>
</div>