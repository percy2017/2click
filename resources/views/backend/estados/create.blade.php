<!-- Modal -->
<div class="modal fade" id="modal_estado_create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="{{ route('estados.store') }}">
        {{ csrf_field() }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Nuevo Estado</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <label>Nombre</label>
              <input type="text" class="form-control" name="nombre" required>
          </div>
          <div class="form-group">
              <label>Descripcion</label>
              <textarea name="descripcion" rows="5" class="form-control" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>