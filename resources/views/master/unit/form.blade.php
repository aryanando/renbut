<div class="form-group {{ $errors->has('keterangan') ? 'has-error' : ''}}">
    <label for="keterangan" class="control-label">{{ 'Keterangan' }}</label>
    <input class="form-control" name="keterangan" type="text" id="keterangan" value="{{ isset($unit->keterangan) ? $unit->keterangan : ''}}" >
    {!! $errors->first('keterangan', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('remun') ? 'has-error' : ''}}">
    <label for="remun" class="control-label">{{ 'remun' }}</label>
    <input class="form-control" name="remun" type="text" id="remun" value="{{ isset($unit->remun) ? $unit->remun : ''}}" >
    {!! $errors->first('remun', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('target') ? 'has-error' : ''}}">
    <label for="target" class="control-label">{{ 'target' }}</label>
    <input class="form-control" name="target" type="text" id="target" value="{{ isset($unit->target) ? $unit->target : ''}}" >
    {!! $errors->first('target', '<p class="help-block">:message</p>') !!}
</div>


<div class="box-footer">
    <input class="btn btn-{{ $formMode === 'edit' ? 'primary' : 'success' }} pull-right" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">