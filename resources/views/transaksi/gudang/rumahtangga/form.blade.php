<div class="form-group {{ $errors->has('keterangan') ? 'has-errors' : ''}}">
    <label for="keterangan" class="control-label">{{ 'Keterangan' }}</label>
    <input class="form-control" name="keterangan" type="text" id="keterangan" value="{{ isset($uraian->keterangan) ? $uraian->keterangan : ''}}" >
    {!! $errors->first('keterangan', '<p class="help-block">:message</p>') !!}
</div>  

 <div class="form-group {{ $errors->has('satuan') ? 'has-errors' : ''}}">
    <label for="satuan" class="control-label">{{ 'Satuan' }}</label>
    <input class="form-control" name="satuan" type="text" id="satuan" value="{{ isset($uraian->satuan) ? $uraian->satuan : ''}}" >
    {!! $errors->first('satuan', '<p class="help-block">:message</p>') !!}
</div> 

<div class="form-group {{ $errors->has('stok') ? 'has-errors' : ''}}">
    <label for="stok" class="control-label">{{ 'Stok' }}</label>
    <input class="form-control" name="stok" type="text" id="stok" value="{{ isset($uraian->stok) ? $uraian->stok : ''}}" >
    {!! $errors->first('stok', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('harga') ? 'has-errors' : ''}}">
    <label for="harga" class="control-label">{{ 'Harga' }}</label>
    <input class="form-control" name="harga" type="text" id="harga" value="{{ isset($uraian->harga) ? $uraian->harga : ''}}" >
    {!! $errors->first('harga', '<p class="help-block">:message</p>') !!}
</div>

<div class="box-footer">
    <input class="btn btn-{{ $formMode === 'edit' ? 'primary' : 'success' }} pull-right" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">