@if($myUser->role == 2)
    <div class="col-md-9">
        <form id="formImport" role="form" method="POST" action="{{ $importLink }}" accept-charset="UTF-8" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="table" class="form-control-label">Bảng</label>
                        <select id="table" name="table" class="form-control{{ $errors->has('table') ? ' is-invalid' : '' }}">
                            <option value="">&nbsp;</option>
                            @foreach ($tables as $table)
                                <option value="{{ $table->value }}" {{ old('table') == $table->value ? 'selected' : '' }}>{{ $table->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('table'))
                            <div class="invalid-feedback">Bảng {{ $errors->first('table') }}</div>
                        @endif
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- col-md-6 -->
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="file" class="form-control-label">Tệp CSV</i></label>
                        <input id="file" type="file" class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}" name="file" accept=".csv">
                        @if ($errors->has('file'))
                            <div class="invalid-feedback">Tệp CSV {{ $errors->first('file') }}</div>
                        @endif
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- col-md-6 -->
            </div>
            <!-- row -->
        </form>
    </div>
    <!-- /.col-md-9 -->
@else
    <p>Không được phép truy cập</p>
@endif
