@extends('layouts.app')
@section ('header')
<link rel="stylesheet" href="{{ asset('/storage/css/profile.css') }}"/>
@endsection
@section ('content')
@if ($user)
<div class="profileHeader">
    <h1 class="username">{{ $user->username }}</h1>
    <div class="email">{{ $user->email }}</div>
</div>
<div class="profileMessage">
    @if ($errors->any()) <div class="message error">{{ $errors->first() }}</div> @endif
    @if (Session::get('success')) <div class="message success">{{ Session::get('success') }}</div> @endif
</div>
<div class="profileContainer">
        <div class="mainProfile">
            <div class="contentWDescription">
                <div class="description">
                    <div>
                        <h3>Giới thiệu @if (!$other) bản thân @endif</h3>
                        <div>
                            <span>{{ $user->description == '' ? 'Không có mô tả' : $user->description }}</span>
                        </div>
                    </div>
                    <div>
                        <h3>Thông tin khác</h3>
                        <div>
                            <p>Rank: {{ $user->getRank?->displayRank }}</p>
                            <p>Độ ưu tiên: {{ $user->weight }}</p>
                            <p>Ngày đăng ký: {{ $user->created_at }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @if ($edit)
                <div class="contentWDescription">
                    <div class="description">
                        @if (!$other)
                            <div>
                                <h3>Cài đặt</h3>
                                <div class="settings">
                                    <form method="POST" action="/logout">
                                        @csrf
                                        <button>Đăng xuất</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                        <div>
                            <h3>Các quyền của @if($other) {{ $user->username }} @else bạn @endif</h3>
                            <div>
                                @if ($user->getRank?->permissions->count())
                                    @foreach ($user->getRank->permissions as $permissions)
                                        <p>{{ $permissions->displayName }}</p>
                                    @endforeach
                                @else
                                    <p>{{ $other ? $user->username : "Bạn" }} không có quyền gì</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @if ($edit)
            <div class="profileEdit">
                <h3>Chỉnh sửa trang cá nhân</h3>
                <div class="profileEditBody">
                    <form method="POST" action="{{ URL("/user/{$user->username}/update/") }}">
                        @csrf
                        <div class="editForm">
                            <div>
                                <div>Email</div>
                                <div><input value="{{ $user->email }}" name="email" placeholder="Email"/></div>
                            </div>
                            <div>
                                <div>Giới thiệu bản thân</div>
                                <div><textarea name="description" placeholder="Giới thiểu bản thân">{{ $user->description }}</textarea></div>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-success">Cập nhật</button>
                        </div>
                    </form>
                </div>
                @if ($admin)
                    <h3>Thay đổi người dùng (Admin)</h3>
                    <form method="POST" action="{{ URL("/admin/user/{$user->username}/update/") }}">
                        @csrf
                        <div class="editForm">
                            <div>
                                <div>Độ ưu tiên</div>
                                <div><input type="number" min="0" max="999" value="{{ $user->weight }}" name="weight" placeholder="Độ ưu tiên"/></div>
                            </div>
                            <div>
                                <div>Rank</div>
                                <div>
                                    <select name="rank" title="Rank">
                                        @foreach($ranks as $rank)
                                            <option @if ($user->rank == $rank->id) @selected(true) @endif value="{{ $rank->id }}">{{ $rank->displayRank }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-success">Cập nhật</button>
                        </div>
                    </form>
                @endif
            </div>
        @endif
    @else
        <div class="message error">Không tìm thấy người chơi này</div>
    @endif
</div>
@endsection