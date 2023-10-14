<div class="navbarParent">
    <nav class="navbar">
        <div>
            <a href="{{ URL('/') }}"><div class="logo">
                <img src="{{ asset('/storage/image/logo.png') }}" alt="logo" />
            </div></a>
        </div>
        <div>
        </div>
        <ul>
            <div class="navbarHeader">
                <div class="title"><h3>Server Title</h3></div>
                <div class="close">X</div>
            </div>
            <li><a class='{{(isset($select) && $select == "home") ? 'active' : '' }}' href="{{ URL("/") }}">Trang chủ</a></li>
            <li><a class='{{(isset($select) && $select == "blog") ? 'active' : '' }}' href="{{ URL("/blog") }}">Blog</a></li>
            <li><a class='{{(isset($select) && $select == "rules") ? 'active' : '' }}' href="{{ URL("/rules") }}">Luật chung</a></li>
            <li><a class='{{(isset($select) && $select == "about") ? 'active' : '' }}' href="{{ URL("/about") }}">Về chúng tôi</a></li>
            <li><a class='{{(isset($select) && $select == "profile") ? 'active' : '' }}' href="{{ URL("/profile") }}">Tài khoản</a></li>
        </ul>
        <div class="overlay"></div>
        <i class="fa-solid fa-bars hamburger"></i>
    </nav>
</div>
