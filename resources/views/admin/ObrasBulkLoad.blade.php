
<div class="grid-bulkLoad">
    <div class="header col-sm-12">
        <div class="col-sm-6">
            <div class="control-label col-sm-1">Año</div>
            <div class="control-label col-sm-4">CPC</div>
            <div class="control-label col-sm-4">Barrio</div>
            <div class="control-label col-sm-3">Categoría</div>
        </div>
        <div class="col-sm-6">
            <div class="control-label col-sm-4">Título</div>
            <div class="control-label col-sm-4">Direccion</div>
            <div class="control-label col-sm-2">Presupuesto</div>
            <div class="control-label col-sm-2">Estado</div>
        </div>


    </div>
    @for($i=0; $i < count($obras); $i++)
    <div class="form-horizontal col-sm-12 {{$obras[$i]['isValidYear'] && $obras[$i]['isValidCpc'] && $obras[$i]['isValidBarrio'] && $obras[$i]['isValidCategory'] && $obras[$i]['isValidTitle'] && $obras[$i]['isValidAddress'] && $obras[$i]['isValidBudget'] && $obras[$i]['isValidStatus'] ? 'validated' : ''  }}">
        <div class="col-sm-6">
            <div class="col-sm-1"><input id="beYear_{{$i}}" class="form-control input-sm fullWidth {{ $obras[$i]['isValidYear'] ? '':'invalid'}}" type="text" name="beYear[{{$i}}]" value="{{$obras[$i]['ano']}}" data-validfield="{{$obras[$i]['isValidYear']}}"/></div>
            <div class="col-sm-4"><input id="beCpc_{{$i}}" class="form-control input-sm fullWidth {{ $obras[$i]['isValidCpc'] ? '':'invalid'}}" type="text" name="beCpc[{{$i}}]" value="{{$obras[$i]['cpc']}}" data-validfield="{{$obras[$i]['isValidCpc']}}" data-listvalues="{{ $cpcs }}"/></div>
            <div class="col-sm-4"><input id="beBarrio_{{$i}}" class="form-control input-sm fullWidth {{ $obras[$i]['isValidBarrio'] ? '':'invalid'}}" type="text" name="beBarrio[{{$i}}]" value="{{$obras[$i]['barrio']}}"  data-validfield="{{$obras[$i]['isValidBarrio']}}" data-listvalues="{{ $barrios }}"/></div>
            <div class="col-sm-3"><input id="beCategory_{{$i}}" class="form-control input-sm fullWidth {{ $obras[$i]['isValidCategory'] ? '':'invalid'}}" type="text" name="beCategory[{{$i}}]" value="{{$obras[$i]['categoria']}}"  data-validfield="{{$obras[$i]['isValidCategory']}}" data-listvalues="{{ $categories }}"/></div>
        </div>
        <div class="col-sm-6">
            <div class=" col-sm-4"><input id="beTitle_{{$i}}" class="form-control input-sm fullWidth {{ $obras[$i]['isValidTitle'] ? '':'invalid'}}" type="text" name="beTitle[{{$i}}]" value="{{$obras[$i]['titulo']}}"  data-validfield="{{$obras[$i]['isValidTitle']}}"/></div>
            <div class=" col-sm-4"><input id="beBudget_{{$i}}" class="form-control input-sm fullWidth {{ $obras[$i]['isValidAddress'] ? '':'invalid'}}" type="text" name="beBudget[{{$i}}]" value="{{$obras[$i]['ubicacion']}}"  data-validfield="{{$obras[$i]['isValidAddress']}}"/></div>
            <div class="col-sm-2"><input id="beAddress_{{$i}}"class="form-control input-sm fullWidth  {{ $obras[$i]['isValidBudget'] ? '':'invalid'}}" type="text" name="beAddress[{{$i}}]" value="{{$obras[$i]['presupuesto']}}"  data-validfield="{{$obras[$i]['isValidBudget']}}"/></div>
            <div class=" col-sm-2">
                <select id="beStatus_{{$i}}" class="form-control input-sm fullWidth {{ $obras[$i]['isValidStatus'] ? '':'invalid'}}" name="beStatus[{{$i}}]" value="{{$obras[$i]['estado']}}"  data-validfield="{{$obras[$i]['isValidStatus']}}">
                    @foreach( $statuses as $status )
                        <option {{ $obras[$i]['isValidStatus'] && $status->status == $obras[$i]['estado'] ?' selected ':'' }} value="{{$status->id}}">{{ $status->status }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <input type="hidden" id="beLocation_{{$i}}" name="beLocation[{{$i}}]" value="{{$obras[$i]['location']}}" />
    </div>
    @endfor

</div>