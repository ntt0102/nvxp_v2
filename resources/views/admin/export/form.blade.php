@if($myUser->role == 2)
    <div class="col-md-9">
        <form id="formExport" role="form" method="POST" action="{{ $exportLink }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="table" class="form-control-label">Bảng</label>
                        <div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="all-table">
                                <label class="custom-control-label" for="all-table">Tất cả</label>
                            </div>
                        </br>
                            @foreach ($tables as $table)
                                <div class="custom-control custom-checkbox table">
                                    <input type="checkbox" class="custom-control-input" id="{{ $table->value }}">
                                    <label class="custom-control-label" for="{{ $table->value }}">{{ $table->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        @if ($errors->has('table'))
                            <div class="invalid-feedback">Bảng {{ $errors->first('table') }}</div>
                        @endif
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- col-md-6 -->
            </div>
            <!-- row -->
            <input type="hidden" id="hidTable" name="tables" />
        </form>
    </div>
    <!-- /.col-md-9 -->
@else
    <p>Không được phép truy cập</p>
@endif
