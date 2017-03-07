@extends('shared.layout2')


@section('head')



@stop


@section('content')

    @include('admin.ObrasPresupuestoGrid')

    @include('admin.obraPresupuestoDetail')



@endsection
@push('cssCustom')


{!! Html::style('assets/css/Custom/obras-admin.css') !!}
{!! Html::style('assets/css/Custom/modal-obra-detail.css') !!}


@endpush

@push('scripts')


@endpush