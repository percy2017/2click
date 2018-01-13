
@foreach($productos as $item)
    <div class="media">
      <div class="media-left">
        <a href="#">
          <img class="media-object img-responsive img-thumbnail" src="{{ asset('imagenes/productos/'.$item->imagen) }}" alt="{{$item->nombre}}" style="height: 100px; width: 130px;">
        </a>
      </div>
      <div class="media-body">
        <h4 class="media-heading">{{$item->nombre}}</h4>
        
        <h5 class="text-justify">{{$item->descripcion}} <br> <small> <i class="fa fa-home"></i>  {{$item->nombre_comercial}}</small></h5>

        <h4>
            <strong>{{$item->precio}} Bs.</strong>
            <!-- <div class="pull-right"> -->
                <button onclick="add_carrito('{{route('carrito.agregar', array($item->id, ':cant')) }}','{{$item->cantidad}}')" class="btn btn-primary" role="button"><span class="fa fa-shopping-cart"></span> Pedir</button>
            <!-- </div> -->
        </h4>
      </div>
    </div>
    
@endforeach
<div class="text-center">
    {{$productos->links()}} 
</div>