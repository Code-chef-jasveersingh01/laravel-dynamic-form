@extends('layout.app')
@section('content')
<div class="col-12">
    <div class="border p-3">
    <a href="{{route('form.create')}}" class="float-end"><button class="btn btn-primary">Create</button></a>
    {{ $dataTable->table(['class' => 'table table-bordered w-100'], true) }}
    </div>
</div>
@endsection
