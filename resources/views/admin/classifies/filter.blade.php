<div class="row {{ $myUser->role == 2 ? '' : 'hide' }}">
    <div class="col-md-3">
        <div class="form-group">
            <label for="constant" class="form-control-label">Nhóm danh mục</label>
            <select id="constant" name="constant" class="form-control load">
                <option value="">&nbsp;</option>
                @foreach ($classifies['constants'] as $constant)
                    <option value="{{ $constant->id }}" {{ $classifies['constant'] == $constant->id ? 'selected' : '' }}>{{ $constant->name }}</option>
                @endforeach
            </select>
        </div>
        <!-- form-group -->
    </div>
    <!-- col-md-3 -->
</div>
<!-- row -->
