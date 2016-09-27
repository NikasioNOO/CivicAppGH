@extends('shared.layout2')

@section('head')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/4.0.1/ekko-lightbox.min.css" />

@stop
@section('content')
    <div class="container-fluid filter-seccion">
        <div class="row">
            <div class="label">AYUDA A MONITORAR LAS OBRAS DEL PRESUPUESTO PARTICIPATIVO DE TU BARRIO</div>
        </div>
        <div class="row">
            <div class="label BuscadorSec">BUSCADOR DE OBRAS</div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2 row-filter-label">
                <div class="col-md-2">
                    <div class="label">AÑO</div>
                </div>
                <div class="col-md-4">
                    <div class="label">CATEGORÍA</div>
                </div>
                <div class="col-md-5">
                    <div class="label">BARRIO</div>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2 row-filter-label" >
                <div class="col-md-2">
                    <select id="yearSearch" name="yearSearch" class="custom-select">
                        <option value="-1"></option>
                        @foreach($years as $year)
                            <option value="{{$year}}">{{ $year}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="custom-select" id="categorySearch">
                        <option value="-1"></option>
                        @foreach($categoriesArray as $category)
                            <option value="{{$category->id}}">{{ $category->category}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <select class="custom-select" id="barrioSearch">
                        <option value="-1"></option>
                        @foreach($barriosArray as $barrio)
                            <option value="{{$barrio->id}}">{{ $barrio->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <button class="btn custom-bottom btn-sm" id="searchObrasBtn">
                        BUSCAR
                    </button>
                </div>
            </div>
        </div>

    </div>
    <input type="text" style="width: 25%;" name="autocompleteMap" id="autocompleteMap" data-idGeoPoint="0" class="form-control input-sm" placeholder="Buscar"  autofocus>
    <div id="map" class="" style="width:100%;height: 100px">
    </div>
    <div class=" divGuide">
        <span class="point">1.</span>SELECCIONÁ UN PROYECTO.
        <span class="point">2.</span>COMENTÁ EN QUÉ ESTADO SE ENCUENTRA.
        <span class="point">3.</span>SUBÍ UNA FOTO.
    </div>

    @include('obraDetail')

@endsection
@push('cssCustom')

    {!! Html::style('assets/css/Custom/custom-select.css') !!}
    {!! Html::style('assets/css/Custom/infowindows-map.css') !!}
    {!! Html::style('assets/css/Custom/modal-obra-detail.css') !!}
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/4.0.1/ekko-lightbox.min.css') !!}

@endpush
@push('scripts')

<script type="text/javascript">

    var ENV_MAPICONS_PATH = "{{ env('MAPICONS_PATH')  }}";
    var ENV_DEFAULT_ICON = "{{ env('ICON_DEFAULT')  }}";
    var ENV_WITHOUT_PHOTO_IMG = "{{ env('WITHOUT_PHOTO_IMG')  }}";
 /*  'https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/4.0.1/ekko-lightbox.min.js') */
</script>
    {!! Html::script('assets/js/markerclusterer.js') !!}
    {!! Html::script('assets/js/Custom/gmaphelper2.js') !!}
    {!! Html::script('assets/js/Custom/obras-social.js') !!}

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/4.0.1/ekko-lightbox.js"></script>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKekXfhDy5EcVFpKfifb4eKgc3wRy3GgE&libraries=places&callback=CivicApp.ObrasSocial.InitMap">
</script>

@endpush