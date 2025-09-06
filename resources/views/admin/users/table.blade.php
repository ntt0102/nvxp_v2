<div class="table-responsive">
    <table class="table table-hover">
        <th>#</th>
        <th style="min-width: 180px;">Họ và tên</th>
        <th>Hệ</th>
        <th style="min-width: 90px;">Email</th>
        <th style="min-width: 40px;">Vai trò</th>
        <th style="width: 90px;">
            <div class="text-left">Thao tác</div>
        </th>

        @foreach ($records as $record)
        <?php
        $tableCounter++;
        //
        $viewLink = route('map') . '?view=' . $record->id;
        $editLink = route($resourceRoutesAlias . '.edit', $record->id);
        $deleteLink = route($resourceRoutesAlias . '.destroy', $record->id);
        $formDeleteId = 'formDestroyToggle_' . $record->id;
        ?>
        <tr>
            <td>{{ $tableCounter }}</td>
            <td>{{ $record->name }}</td>
            <td>{{ $record->pedigree }}</td>
            <td>{{ $record->email }}</td>
            <td>{{ $record->role_name }}</td>
            <!-- we will also add show, edit, and delete buttons -->
            <td>
                <div class="float-left input-group-append">
                    <button class="ml-1 btn btn-sm btn-primary btnEdit" data-url="{{ $editLink }}"><i class="fas fa-edit"></i> Sửa</button>
                    @if(Auth::user()->id != $record->id)
                    <button class="ml-1 btn btn-sm btn-danger btnDelete" data-form-id="{{ $formDeleteId }}" data-name="{{ $record->name }}"><i class="fas fa-trash-alt"></i> Xóa</button>
                    @endif
                </div>
                @if(Auth::user()->id != $record->id)
                <form id="{{ $formDeleteId }}" action="{{ $deleteLink }}" method="POST" class="hide form-inline">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <input type="hidden" name="classifies" />
                </form>
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>