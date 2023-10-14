@extends ('layouts.app')
@section ('header')
<link rel="stylesheet" href="{{ URL('/storage/css/rank.css') }}" />
@endsection
@section ('content')

<div class="editRank">
    <div class="currentRank">
        Hiện đang chỉnh sửa rank: <b>{{ $rank->displayRank }}</b>
    </div>
    <div class="rank">
        <div>
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Permissions</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < $permissions->count(); $i++)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $permissions[$i]->displayName }}</td>
                            <td>
                                <form method="POST" action="{{ URL("/admin/rank/$rank->id/toggle/" . $permissions[$i]->permId) }}">
                                    @csrf
                                    <button class="rankToggleBtn">@if (in_array($permissions[$i]->permId, $unusedPermissionIds))
                                        Thêm
                                    @else
                                        Xóa
                                    @endif</button>
                                </form>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
    <form method="POST" action="{{ URL("/admin/rank/$rank->id/delete/" ) }}">
        @csrf
        <button class="delete">Xóa rank này</button>
    </form>
</div>

@endsection