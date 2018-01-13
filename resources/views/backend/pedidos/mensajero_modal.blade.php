<!-- Modal -->
<div class="modal fade" id="mensajero_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">
            <i class="fa fa-rocket"></i>
            Mensajeros del Pedido
          </h4>
        </div>
        <div class="modal-body">
          <div id="cargando_mensajero" class="text-center">
              <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 150px; height: 150px;">
          </div>
          <div id="mensajero_detalle"></div>
          <!-- <hr> -->
          <div id="mensajero_all"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <!-- <button type="submit" class="btn btn-primary">Guardar</button> -->
        </div>
    </div>
  </div>
</div>