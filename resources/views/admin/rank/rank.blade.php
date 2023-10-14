@extends ('layouts.app')
@section ('header')
<link rel="stylesheet" href="{{ URL('/storage/css/rank.css') }}" />
@endsection
@section ('content')

<div class="rank">
    <div>
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Permissions ID</td>
                    <th>Permissions Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permissions as $index => $permission)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $permission->permId }}</td>
                        <td>{{ $permission->displayName }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Rank</th>
                    <th>Permissions</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ranks as $index => $rank)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $rank->displayRank }}</td>
                        <td class="permissions">
                            @foreach ($rank->permissions as $permission)
                                <div>{{ $permission->displayName }}</div>
                            @endforeach
                        </td>
                        <td class="linkEdit"><a href="{{ URL("/admin/rank/{$rank->id}") }}">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<div class="rankForm">
    <h3>Tạo rank mới</h3>
    <div>
        <form method="POST" action="/admin/rank/create">
            @csrf
            <input name="rankname" placeholder="Tên rank" />
            <button>Tạo rank mới</button>
        </form>
    </div>
</div>

@endsection