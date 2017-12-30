<!-- Modal -->
<div class="modal fade" id="modalNotificacionEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="{{ route('notificaciones.update',0) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Editar Notificacion</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <label>Usuario</label>
              <input type="text" class="form-control" id="edit_name" disabled>
          </div>
          <div class="form-group">
              <label>Ruta</label>
              <input type="text" class="form-control" id="edit_ruta" name="ruta" placeholder="Ruta de la notificacion" required>
          </div>
          <div class="form-group">
              <label>Mensaje</label>
              <textarea id="edit_mensaje" name="mensaje" rows="5" class="form-control"></textarea>
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