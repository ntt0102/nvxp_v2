@if(!($myUser->role == 1 && $classifies['constant'] != 4))
<div class=" table-responsive">
    <table class="table table-hover">
        <th>#</th>
        @if($myUser->role == 2)
        <th style="min-width: 180px;">Thuộc nhóm</th>
        @endif
        <th style="min-width: 180px;">Tên hiển thị</th>
        <th style="min-width: 100px;">Giá trị</th>
        <th style="min-width: 100px;">Thứ tự</th>
        @if($myUser->role == 2)
        <th style="min-width: 180px;">Người cập nhật</th>
        @endif
        <th style="min-width: 100px;">
            <div class="text-right">Thao tác</div>
        </th>

        @foreach ($records as $record)
        <?php
        $tableCounter++;
        //
        $editLink = route($resourceRoutesAlias . '.edit', $record->id);
        $deleteLink = route($resourceRoutesAlias . '.destroy', $record->id);
        $formDeleteId = 'formDestroyToggle_' . $record->id;
        $modifiedLink = route('admin::members.index', ['id' => $record->modified_by]);
        ?>
        <tr>
            <td>{{ $tableCounter }}</td>
            @if($myUser->role == 2)
            <td>{{ $record->constant_name }}</td>
            @endif
            <td>{{ $record->name }}</td>
            <td>{{ $record->value }}</td>
            <td>{{ $record->display_no }}</td>
            @if($myUser->role == 2)
            <td><a href="{{ $modifiedLink }}">{{ $record->modified_name }}</a></td>
            @endif
            <td>
                <div class="float-right input-group-append">
                    <button class="ml-1 btn btn-sm btn-primary btnEdit" data-url="{{ $editLink }}"><i class="fas fa-edit"></i> Sửa</button>
                    <button class="ml-1 btn btn-sm btn-danger btnDelete" data-form-id="{{ $formDeleteId }}" data-name="{{ $record->name }}"><i class="fas fa-trash-alt"></i> Xóa</button>
                </div>
                <form id="{{ $formDeleteId }}" action="{{ $deleteLink }}" method="POST" class="hide form-inline">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <input type="hidden" name="classifies" />
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endif