
    @foreach($productos as $item)
    <!-- <div class="row"> -->
    <div class="col-sm-6 col-md-4 col-xs-12">
        <div class="thumbnail">
            <h5>
                <a href="#" onclick="mostrar_imagen('{{asset('imagenes/proveedores/'.$item->logo)}}','{{ $item->direccion }}')">
                    <!-- <img src="{{ asset('imagenes/proveedores/'.$item->logo) }}" alt="{{$item->nombre_comercial}}" class="img-responsive img-circle" style="height: 20px; width: 20px;"> -->
                    <i class="fa fa-home"></i>
                    {{$item->nombre_comercial}}

                </a>
            </h5>
            <img src="{{ asset('imagenes/productos/'.$item->imagen) }}" alt="{{$item->nombre}}" style="height: 150px; width: 100%;" class="img-responsive img-thumbnail">
            <div class="caption">                                    
                <h4>
                    <strong>{{$item->nombre}}</strong>
                    <br><small><i class="fa fa-unlink"></i> {{$item->categoria}}</small>
                </h4>
                <p>{{$item->descripcion}}</p> 
                <hr>
                <div>
                    <h3>
                        <strong>{{$item->precio}} Bs.</strong>
                        <div class="pull-right">
                            <button onclick="add_carrito('{{route('carrito.agregar', array($item->id, ':cant')) }}','{{$item->cantidad}}')" class="btn btn-primary" role="button"><span class="fa fa-shopping-cart"></span> Pedir</button>
                        </div>
                    </h3>
                    
                </div>                                                                  
            </div>
        </div>
    </div>
    <!-- </div> -->
    @endforeach
    <div class="text-center">
        {{$productos->links()}} 
    </div> 