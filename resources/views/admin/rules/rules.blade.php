@extends ('layouts.app')
@section('header')
<link rel="stylesheet" href="{{ asset("/storage/css/rules.css") }}" />
@endsection
@section('content')
<div class="rulesContainer">
    <h1>Những luật hiện tại</h1>
    <div style="margin: 20px 0;">
        @if($errors->any()) <div class="message error">{{ $errors->first() }}</div> @endif
        @if(Session::has('success')) <div class="message success">{{ Session::get('success') }}</div> @endif
    </div>
    <table class="table-default">
        <thead>
            <tr>
                <th>STT</th>
                <th>Nội dung</th>
                <th>Có hiệu lực vào</th>
                @if ($admin) <th>Action</th> @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($rules as $index => $rule)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $rule->content }}</td>
                    <td>{{ $rule->created_at }}</td>
                    @if ($admin)
                    <td>
                        <form method="POST" action="{{ URL("/admin/rules/{$rule->id}/delete") }}">
                            @csrf
                            <button class="btn btn-success">Xóa luật này</button>
                        </form>
                    </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    @if ($admin)
        <div class="rulesForm">
            <form method="POST" action="{{ URL("/admin/rules/add") }}">
                @csrf
                <textarea placeholder="Nội dung điều luật" class="input-default" name="content"></textarea>
                <div>
                    <button class="btn btn-success">Thêm luật này</button>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection