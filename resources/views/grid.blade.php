@extends('layouts.app')

@section('title', 'Grid View')

@section('content')

  <div class="content">

    <h1 class="grid-title">{{ $gridTitle }}</h1>
    {{-- Split items into groups of 3 to facilitate simple looping into rows  --}}
    {{-- @See: https://laravel.com/docs/5.4/collections#method-chunk --}}
    @foreach ($itemsCollection->chunk(3) as $items)
      <div class="row">

        @foreach($items as $item)
          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="thumbnail item-profile">
              <img class="img-responsive" src="{{ $item->image_url }}" />
              <div class="caption">
                <div class="row">
                  <div class="col-sm-7 col-md-7 col-sm-offset-1 col-md-offset-1">
                    <h3 class="item-name">{{ $item->name }}</h3>
                  </div>
                  <div class="col-sm-3 col-md-3 col-sm-offset-1 col-md-offset-1">
                    {{-- Reusable icon generator --}}
                    {{-- @See: AppServiceProvider.php --}}
                    @itembadge($item->type)
                  </div>
                  <div class="col-sm-11 col-md-11 col-sm-offset-1 col-md-offset-1">
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach

      </div>
    @endforeach

  </div>

@endsection
