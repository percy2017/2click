<!-- Modal -->
<div class="modal fade" id="modal_mapa_create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="{{ route('mapa.guardar') }}">
        {{ csrf_field() }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">
            <i class="fa fa-map-marker"></i>
            Nueva ubicacion para recibir tus pedidos
          </h4>
        </div>
        <div class="modal-body">
          <div id="cargando_map" class="text-center">
              <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
              <p>Esperando tu ubicacion..</p>
          </div>
          <div id="cargado_map" class="" style="display: none;">
            <div class="form-group">
              <label for="">Refencia</label>
              <select name="referencia_id" class="form-control myselector">
                  @foreach($referencias as $item)
                      <option value="{{$item->id}}">{{$item->nombre}}</option>
                  @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="">Direccion</label>
              <input type="text" class="form-control" name="direccion" placeholder="Escriba su direccion completa con numero de casa">
            </div>

            <label>Agarre y arrastre el marcador para mejorar su ubicacion!</label>
            <div id="map" style="width: 100%; height: 300px;"></div>
            <input type="text" id="latitud" name="latitud" hidden="false">
            <input type="text" id="longitud" name="longitud" hidden="false">
            <div class="input-group">
              <input type="search" id="buscar_mapa" class="form-control" placeholder="Encuentra tu localidad.. (Ejemplo: Trinidad, Beni)">
              <span class="input-group-btn">
                <button class="btn btn-default" onclick="buscarMapa()" type="button">Ir</button>
              </span>
            </div><!-- /input-group -->
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-reply"></i> Cerrar</button>
          
        </div>
      </form>
    </div>
  </div>
</div>
