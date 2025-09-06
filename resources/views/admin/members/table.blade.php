<div class="table-responsive">
    <table class="table table-hover">
        <th>#</th>
        <th style="min-width: 180px;">Họ và tên</th>
        <th>Hệ</th>
        <th style="min-width: 90px;">Quan hệ</th>
        <th style="min-width: 180px;">Cha/Chồng</th>
        @if($myUser->role == 2)
        <th style="min-width: 40px;">Cao hệ</th>
        @endif
        <th style="width: 90px;">
            <div class="text-left">Thao tác</div>
        </th>

        @foreach ($records as $record)
        <?php
        $tableCounter++;
        //
        if ($record->gender == 1) {
            $relation = $record->couple_id ? 'Con rể' : 'Con trai';
            if ($record->pedigree == 1) $relation = 'Ông tổ';
        } else {
            $relation = $record->couple_id ? 'Con dâu' : 'Con gái';
        }
        //
        $viewLink = route('map') . '?view=' . $record->id;
        $editLink = route($resourceRoutesAlias . '.edit', $record->id);
        $deleteLink = route($resourceRoutesAlias . '.destroy', $record->id);
        $formDeleteId = 'formDestroyToggle_' . $record->id;

        $childs = App\Utils::getChildMembers($record->id);
        $hasChilds = count($childs);
        ?>
        <tr>
            <td>{{ $tableCounter }}</td>
            <td>{{ $record->name }}</td>
            <td>{{ $record->pedigree }}</td>
            <td>{{ $relation }}</td>
            <td>{{ $record->parent_name ? $record->parent_name : $record->couple_name }}</td>
            @if($myUser->role == 2)
            <td><i class="fas {{ $record->upperFlag ? 'fa-check text-success' : 'fa-times text-danger' }}"></i></td>
            @endif
            <!-- we will also add show, edit, and delete buttons -->
            <td>
                <div class="float-left input-group-append">
                    @if(!$record->upperFlag)
                    <a href="{{ $viewLink }}" class="btn btn-sm btn-warning"><i class="fas fa-sitemap"></i> Xem</a>
                    @endif
                    <button class="ml-1 btn btn-sm btn-primary btnEdit" data-url="{{ $editLink }}"><i class="fas fa-edit"></i> Sửa</button>
                    @if(!$hasChilds)
                    <button class="ml-1 btn btn-sm btn-danger btnDelete" data-form-id="{{ $formDeleteId }}" data-name="{{ $record->name }}"><i class="fas fa-trash-alt"></i> Xóa</button>
                    @endif
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