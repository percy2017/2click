@extends('backend.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default text-center">
                <div class="panel-heading">
                    <h3>
                        Panel de Principal
                    </h3>
                    
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                </div>
                <div class="panel-footer text-center">
                    {{ config('app.myfooter') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
