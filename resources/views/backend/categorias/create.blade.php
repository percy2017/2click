<!-- Modal -->
<div class="modal fade" id="modal_create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="{{ route('categorias.store') }}">
        {{ csrf_field() }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">
            <i class="fa fa-th"></i>
            Nuevo Categoria
          </h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <label>Nombre</label>
              <input type="text" class="form-control" name="nombre" placeholder="Nombre de la Categoria" required>
          </div>
          <div class="form-group">
              <label>Descripcion</label>
              <textarea class="form-control" name="descripcion" rows="4" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>