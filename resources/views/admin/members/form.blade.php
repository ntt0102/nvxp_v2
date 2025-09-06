@if(!($myUser->role == 1 && $record->upperFlag))
<div class="col-md-12">
    <div class="row">
        @if (!($record->id || $classifies['upperFlag'] || isset($classifies['parent']) || isset($classifies['couple'])))
        <div class="col-md-5">
            <div class="form-group">
                <label for="branch" class="form-control-label">
                    Chi phái
                    <i class="far fa-question-circle" title="Chọn chi phái gần nhất để tải dữ liệu nhanh hơn"></i>
                    <a target="_blank" class="load-none" href="{{ route('admin::classifies.index').'?constant=4' }}" style="font-style: italic;" title="Tải lại trang sau khi chỉnh sửa">
                        (Chỉnh sửa)
                    </a>
                </label>
                <select id="branch" name="branch" class="form-control{{ $errors->has('branch') ? ' is-invalid' : '' }}">
                    <option value="">&nbsp;</option>
                    <?php
                    if (!isset($classifies['branch']) && count($classifies['branches']) == 1) {
                        $classifies['branch'] = $classifies['branches'][0]->id;
                    }
                    ?>
                    @foreach ($classifies['branches'] as $branch)
                    <option value="{{ $branch->id }}" {{ old('branch', isset($classifies['branch']) ? $classifies['branch'] : "" ) == $branch->id ? 'selected' : '' }}>{{ $branch->name.' (Hệ '.$branch->pedigree.')' }}</option>
                    @endforeach
                </select>
                @if ($errors->has('branch'))
                <div class="invalid-feedback">Chi phái {{ $errors->first('branch') }}</div>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <!-- col-md-5 -->
        @endif
        @if($record->id)
        <div class="col-md-5">
            <div class="form-group">
                <label for="id" class="form-control-label">ID</label>
                <div class="form-control"><span id="id">{{ $record->id }}</span>
                    @if(!$record->upperFlag)
                    <a class="float-right" href=" {{ route('map').'?view='.$record->id }}"><i class="fas fa-sitemap"></i> Xem</a>
                    @endif
                </div>
            </div>
            <!-- /.form-group -->
        </div>
        <!-- col-md-5 -->
        @endif
        @if($myUser->role == 2)
        <div class="col-md-2">
            <div class="form-group">
                <label for="upperFlag" class="form-control-label d-none d-md-block">&nbsp;</label>
                <div class="custom-control custom-checkbox dead-flag">
                    <input type="checkbox" class="custom-control-input" id="upperFlag" name="upperFlag" {{ old('upperFlag', isset($classifies['upperFlag']) ? $classifies['upperFlag'] : ($record->id ? $record->upperFlag : '')) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="upperFlag">Cao hệ</label>
                </div>
                <!-- /.custom-control -->
            </div>
            <!-- /.form-group -->
        </div>
        <!-- col-md-5 -->
        @endif
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label for="pedigree" class="form-control-label">Hệ</label>
                <select id="pedigree" name="pedigree" class="form-control{{ $errors->has('pedigree') ? ' is-invalid' : '' }}">
                    <option value="">&nbsp;</option>
                    @for ($i = $classifies['pedigrees'][0]; $i <= $classifies['pedigrees'][1]; $i++) <option value="{{ $i }}" {{ old('periods', isset($classifies['pedigree']) ? $classifies['pedigree'] : $record->pedigree ) == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                </select>
                @if ($errors->has('pedigree'))
                <div class="invalid-feedback">Hệ {{ $errors->first('pedigree') }}</div>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <!-- col-md-5 -->
        <div class="col-md-5">
            <div class="form-group">
                <label for="relation" class="form-control-label">Quan hệ gia phả</label>
                <select id="relation" name="relation" class="form-control{{ $errors->has('relation') ? ' is-invalid' : '' }}">
                    <option value="">&nbsp;</option>
                    @foreach ($classifies['relations'] as $relation)
                    <option value="{{ $relation->value }}" {{ old('relation', isset($classifies['relation']) ? $classifies['relation'] : $record->relation ) == $relation->value ? 'selected' : '' }}>{{ $relation->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('relation'))
                <div class="invalid-feedback">Quan hệ gia phả {{ $errors->first('relation') }}</div>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <!-- col-md-5 -->
    </div>
    <!-- ./row -->
    @if(isset($classifies['relation']))
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label for="name" class="form-control-label">Họ tên</label>
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $record->name) }}" required autofocus onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">
                @if ($errors->has('name'))
                <div class="invalid-feedback">Họ tên {{ $errors->first('name') }}</div>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <!-- col-md-5 -->
        <div class="col-md-5 hide">
            <div class="form-group">
                <label for="gender" class="form-control-label">Giới tính</label>
                <select id="gender" name="gender" class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}">
                    <option value="">&nbsp;</option>
                    @foreach ($classifies['genders'] as $gender)
                    <option value="{{ $gender->value }}" {{ old('gender', isset($classifies['gender']) ? $classifies['gender'] : $record->gender ) == $gender->value ? 'selected' : '' }}>{{ $gender->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('gender'))
                <div class="invalid-feedback">Giới tính {{ $errors->first('gender') }}</div>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <!-- col-md-5 -->
    </div>
    <!-- row -->
    <div class="row">
        @if(isset($classifies['parents']))
        <div class="col-md-5">
            <div class="form-group">
                <label for="parent" class="form-control-label">Cha <i class="far fa-question-circle" title="Nếu không tìm thấy cha hãy chọn Chi phái"></i></label>
                <select id="parent" name="parent" class="form-control{{ $errors->has('parent') ? ' is-invalid' : '' }}">
                    <option value="">&nbsp;</option>
                    <?php
                    if (!isset($classifies['parent']) && count($classifies['parents']) == 1) {
                        $classifies['parent'] = $classifies['parents'][0]->id;
                    }
                    ?>
                    @foreach ($classifies['parents'] as $parent)
                    <option value="{{ $parent->id }}" {{ old('parent', isset($classifies['parent']) ? $classifies['parent'] : $record->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->name.($parent->parent_name ? ' ('.$parent->parent_name.')' : '') }}</option>
                    @endforeach
                </select>
                @if ($errors->has('parent'))
                <div class="invalid-feedback">Cha {{ $errors->first('parent') }}</div>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <!-- col-md-5 -->
        <div class="col-md-5">
            <div class="form-group">
                <label for="ordinal_brother" class="form-control-label">Thứ tự anh em</label>
                <input id="ordinal_brother" type="number" class="form-control{{ $errors->has('ordinal_brother') ? ' is-invalid' : '' }}" name="ordinal_brother" value="{{ old('ordinal_brother', $record->ordinal_brother) }}">
                @if ($errors->has('ordinal_brother'))
                <div class="invalid-feedback">Thứ tự anh em {{ $errors->first('ordinal_brother') }}</div>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <!-- col-md-5 -->
        @endif

        @if($classifies['pedigree'] != 1)
        @if(isset($classifies['couples']))
        <div class="col-md-5">
            <div class="form-group">
                <label for="couple" class="form-control-label">{{ $classifies['gender']%2 ? 'Vợ' : 'Chồng' }} <i class="far fa-question-circle" title="Nếu không tìm thấy {{ $classifies['gender']%2 ? 'vợ' : 'chồng' }} hãy chọn Chi phái"></i></label>
                <select id="couple" name="couple" class="form-control{{ $errors->has('couple') ? ' is-invalid' : '' }}">
                    <option value="">&nbsp;</option>
                    @foreach ($classifies['couples'] as $couple)
                    <option value="{{ $couple->id }}" {{ old('couple', isset($classifies['couple']) ? $classifies['couple'] : $record->couple_id) == $couple->id ? 'selected' : '' }}>{{ $couple->name.($couple->parent_name ? ' (Cha '.$couple->parent_name.')' : '') }}</option>
                    @endforeach
                </select>
                @if ($errors->has('couple'))
                <div class="invalid-feedback">{{ $classifies['gender']%2 ? 'Vợ' : 'Chồng' }} {{ $errors->first('couple') }}</div>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <!-- col-md-5 -->
        @endif
        <div class="col-md-5">
            <div class="form-group">
                <label for="marriage_step" class="form-control-label">Đời {{ isset($classifies['parents']) ? 'mẹ' : ($classifies['gender']%2 ? 'chồng' : 'vợ') }} <i class="far fa-question-circle" title="Nếu chỉ có một đời thì không cần nhập"></i></label>
                <input id="marriage_step" type="number" class="form-control{{ $errors->has('marriage_step') ? ' is-invalid' : '' }}" name="marriage_step" value="{{ old('marriage_step', $record->marriage_step) }}">
                @if ($errors->has('marriage_step'))
                <div class="invalid-feedback">Đời {{ isset($classifies['parents']) ? 'mẹ' : ($classifies['gender']%2 ? 'chồng' : 'vợ') }} {{ $errors->first('marriage_step') }}</div>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <!-- col-md-5 -->
        @endif
    </div>
    <!-- ./row -->
    <!-- row -->
    <div class="row">
        <div class="col-md-10">
            <div class="form-group">
                <label for="note" class="form-control-label">Ghi chú</label>
                <textarea id="note" name="note" class="form-control{{ $errors->has('note') ? ' is-invalid' : '' }}" rows="3">{{ old('note', $record->note) }}</textarea>
                @if ($errors->has('note'))
                <div class="invalid-feedback">Ghi chú {{ $errors->first('note') }}</div>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <!-- col-md-5 -->
    </div>
    <!-- row -->
    @endif
</div>
<!-- /.col-md-12 -->
<input type="hidden" name="classifies" />
<input type="hidden" id="page" value="{{ $classifies['page'] }}" />
<?php
$hasChilds = 0;
if ($record->id) {
    $childs = App\Utils::getChildMembers($record->id);
    $hasChilds = count($childs);
}
?>
@if(isset($hasChilds) && $hasChilds > 0)
<input type="hidden" id="isDelete" value="{{ $hasChilds }}" />
@endif

@else
<p>Không được phép truy cập</p>
@endif