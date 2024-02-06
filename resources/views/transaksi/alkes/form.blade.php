{{-- <div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
    <label for="user_id" class="control-label">{{ 'User Id' }}</label>
    <input class="form-control" name="user_id" type="number" id="user_id" value="{{ isset($alkes->user_id) ? $alkes->user_id : ''}}" >
    {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
</div> --}}
<div class="form-group {{ $errors->has('periode') ? 'has-error' : ''}}">
    <label for="periode" class="control-label">{{ 'Periode' }}</label>
    <input class="form-control" name="periode" type="month" id="periode" value="{{ isset($alkes->periode) ? substr($alkes->periode,0,7) : date("Y-m")}}" >
    {!! $errors->first('periode', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('uraian') ? 'has-error' : ''}}">
    <label for="uraian" class="control-label">{{ 'Uraian' }}</label>
    <input type="hidden" name="uraian" type="text" id="uraian" value="{{ isset($alkes->uraian) ? $alkes->uraian : ''}}" data-tags="true">
    <select class="form-control select2" style="width: 100%;" name="uraian_json" type="text" id="uraian_json" value="" data-tags="true">
        <option>--pilih uraian--</option>
        @foreach($uraian as $key => $item)
            <option value="{{ $item }}">{{ ucfirst($item->keterangan) }}</option>        
        @endforeach
    </select>
    {!! $errors->first('uraian', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('satuan') ? 'has-error' : ''}}">
    <label for="satuan" class="control-label">{{ 'satuan' }}</label>
    <input type="hidden" name="satuan" type="text" id="satuan" value="{{ isset($alkes->satuan) ? $alkes->satuan : ''}}" data-tags="true">
    <select class="form-control select2" style="width: 100%;" name="satuan_json" type="text" id="satuan_json" value="" data-tags="true">
        <option>--pilih satuan--</option>
        @foreach($satuan as $key => $item)
            <option value="{{ $item->keterangan }}">{{ ucfirst($item->keterangan) }}</option>        
        @endforeach
    </select>
    {!! $errors->first('uraian', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('jumlah') ? 'has-error' : ''}}">
    <label for="jumlah" class="control-label">{{ 'Jumlah' }}</label>
    <input class="form-control" name="jumlah" type="number" id="jumlah" value="{{ isset($alkes->jumlah) ? $alkes->jumlah : ''}}" >
    {!! $errors->first('jumlah', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('harga') ? 'has-error' : ''}}">
    <label for="harga" class="control-label">{{ 'Harga' }}</label>
    <input class="form-control" name="harga" type="number" id="harga" value="{{ isset($alkes->harga) ? $alkes->harga : ''}}" >
    {!! $errors->first('harga', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('total') ? 'has-error' : ''}}">
    <label for="total" class="control-label">{{ 'Total' }}</label>
    <input class="form-control" type="number" id="total" value="{{ isset($alkes->total) ? $alkes->total : ''}}" readonly>
    {!! $errors->first('total', '<p class="help-block">:message</p>') !!}
</div>


<div class="box-footer">
    <input class="btn btn-{{ $formMode === 'edit' ? 'primary' : 'success' }} pull-right" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">