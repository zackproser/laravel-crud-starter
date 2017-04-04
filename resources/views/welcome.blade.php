@extends('layouts.app')

@section('title', 'Welcome')

@section('content')

<div class="content splash-page">

    <div class="row title">

      <h1>{{ $appName }}</h1>

      <h3>By <a href="mailto:{{ $adminEmail }}">{{ $appAuthor }}</a></h3>

      <div class="btn-group">
          <a class="btn btn-primary" href="/admin">Admin Only: Manage Items</a>
          <a class="btn btn-success" href="/items">View Items</a>
      </div>

    </div>

</div>

@endsection