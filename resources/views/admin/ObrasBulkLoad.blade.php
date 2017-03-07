
<div class="grid-bulkLoad">
    <div class="header col-sm-12">
        <div class="col-sm-6">
            <div class="control-label col-sm-1"></div>
            <div class="control-label col-sm-1">Año</div>
            <div class="control-label col-sm-4">CPC</div>
            <div class="control-label col-sm-3">Barrio</div>
            <div class="control-label col-sm-3">Categoría</div>
        </div>
        <div class="col-sm-6">
            <div class="control-label col-sm-3">Título</div>
            <div class="control-label col-sm-3">Direccion</div>
            <div class="control-label col-sm-2">Presupuesto</div>
            <div class="control-label col-sm-2">Nro Exp</div>
            <div class="control-label col-sm-2">Estado</div>
        </div>

    </div>

    @for($i=0; $i < count($obras); $i++)
    <div class="form-horizontal col-sm-12 {{$obras[$i]['isValid'] ? 'validated' : ''  }}">
        <div class="col-sm-6">
            <div class="col-sm-1" style="text-align: center; vertical-align: middle">
                @if($obras[$i]['created'] == 2 )
                    <span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>
                @endif
                <input id="addObraChk_{{$i}}" name="addObraChk[{{$i}}]" type="checkbox" {{ $obras[$i]['created'] == 0 && $obras[$i]['isValid']  ? 'checked' : ''  }} class="{{ $obras[$i]['created'] == 1 ? 'hidden':''}}" />
                @if( $obras[$i]['created'] == 1)
                    <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>
                @endif

            </div>
            <div class="col-sm-1">
                <input id="beYear_{{$i}}" {{ $obras[$i]['created'] == 1 ? ' readonly ':''  }} class="form-control input-sm fullWidth {{ $obras[$i]['isValidYear'] ? '':'invalid'}}" type="text" name="beYear[{{$i}}]" value="{{$obras[$i]['ano']}}" data-validfield="{{$obras[$i]['isValidYear']}}"/>
            </div>
            <div class="col-sm-4"><input {{ $obras[$i]['created'] == 1 ? ' readonly ':''  }} id="beCpc_{{$i}}" class="form-control input-sm fullWidth {{ $obras[$i]['isValidCpc'] ? '':'invalid'}}" type="text" name="beCpc[{{$i}}]" value="{{$obras[$i]['cpc']}}" data-validfield="{{$obras[$i]['isValidCpc']}}" data-listvalues="{{ $cpcs }}"/></div>
            <div class="col-sm-3"><input {{ $obras[$i]['created'] == 1 ? ' readonly ':''  }} id="beBarrio_{{$i}}" class="form-control input-sm fullWidth {{ $obras[$i]['isValidBarrio'] ? '':'invalid'}}" type="text" name="beBarrio[{{$i}}]" value="{{$obras[$i]['barrio']}}"  data-validfield="{{$obras[$i]['isValidBarrio']}}" data-listvalues="{{ $barrios }}"/></div>
            <div class="col-sm-3"><input {{ $obras[$i]['created'] == 1 ? ' readonly ':''  }} id="beCategory_{{$i}}" class="form-control input-sm fullWidth {{ $obras[$i]['isValidCategory'] ? '':'invalid'}}" type="text" name="beCategory[{{$i}}]" value="{{$obras[$i]['categoria']}}"  data-validfield="{{$obras[$i]['isValidCategory']}}" data-listvalues="{{ $categories }}"/></div>
        </div>
        <div class="col-sm-6">
            <div class=" col-sm-3"><input {{ $obras[$i]['created'] == 1 ? ' readonly ':''  }} id="beTitle_{{$i}}" class="form-control input-sm fullWidth {{ $obras[$i]['isValidTitle'] ? '':'invalid'}}" type="text" name="beTitle[{{$i}}]" value="{{$obras[$i]['titulo']}}"  data-validfield="{{$obras[$i]['isValidTitle']}}"/></div>
            <div class=" col-sm-3 ">
                <div class="input-group">
                    <input readonly id="beAddress_{{$i}}" class="form-control input-sm fullWidth {{ $obras[$i]['isValidAddress'] ? '':'invalid'}}" type="text" name="beAddress[{{$i}}]" value="{{$obras[$i]['ubicacion']}}"  data-validfield="{{$obras[$i]['isValidAddress']}}"/>
                    @if($obras[$i]['created'] != 1 )
                    <span class="input-group-btn" >
                        <span id="editAddress_{{$i}}" class="btn btn-primary input-sm btn-sm fullWidth" data-toggle="modal" data-target="#popUpLocation">
                                        <span class="fa fa-map-marker"></span>
                        </span>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-2"><input {{ $obras[$i]['created'] == 1 ? ' readonly ':''  }} id="beBudget_{{$i}}" style="text-align: right" class="form-control input-sm fullWidth  {{ $obras[$i]['isValidBudget'] ? '':'invalid'}}" type="number" name="beBudget[{{$i}}]" value="{{$obras[$i]['presupuesto']}}"  data-validfield="{{$obras[$i]['isValidBudget']}}"/></div>
            <div class=" col-sm-2"><input {{ $obras[$i]['created'] == 1 ? ' readonly ':''  }} id="beNroExpediente_{{$i}}" class="form-control input-sm fullWidth " type="text" name="beNroExpediente[{{$i}}]" value="{{$obras[$i]['nro_expediente']}}"  data-validfield="1"/></div>
            <div class=" col-sm-2">
                <select id="beStatus_{{$i}}" {{ $obras[$i]['created'] == 1 ? ' readonly ':''  }} class="form-control input-sm fullWidth {{ $obras[$i]['isValidStatus'] ? '':'invalid'}}" name="beStatus[{{$i}}]" value="{{$obras[$i]['estado']}}"  data-validfield="{{$obras[$i]['isValidStatus']}}">
                    <option {{ $obras[$i]['isValidStatus'] == 0 ?' selected ':'' }} value="-1"></option>
                    @foreach( $statuses as $status )
                        <option {{ $obras[$i]['isValidStatus'] == 1 ?  $status->status == $obras[$i]['estado'] ?' selected ':'' : $status->status == 'Comprometido' ? ' selected ':''  }} value="{{$status->status}}">{{ $status->status }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <input type="hidden" id="beLocation_{{$i}}" name="beLocation[{{$i}}]" value="{{$obras[$i]['location']}}" />
        <input type="hidden" id="beCreated_{{$i}}" name="beCreated[{{$i}}]" value="{{$obras[$i]['created']}}" />
    </div>
    @endfor

</div>
