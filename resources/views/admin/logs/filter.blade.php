<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="type" class="form-control-label">Loại thao tác</label>
            <select id="type" class="form-control load">
                <option value="">&nbsp;</option>
                @foreach ($classifies['types'] as $type)
                    <option value="{{ $type->value }}" {{ $classifies['type'] == $type->value ? 'selected' : '' }}>{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
        <!-- form-group -->
    </div>
    <!-- col-md-3 -->
</div>
<!-- row -->