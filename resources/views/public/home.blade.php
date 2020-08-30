@extends('layouts.public')
@section('css') 
    
@endsection
@section('content')
<div class="w-100 mx-0 px-1 mx-auto w-100 position-relative" style="top: 100px; max-height: 540px; overflow-y: auto;">
    <div class="m-0 w-100 p-2 bg-linear-official-180 border">
        <home-container></home-container>
    </div>
    <div class="m-0 w-100 p-0 mt-1">
    	<home-footer></home-footer>
    </div>
</div>
@section('js')
          
@endsection
@endsection