<!doctype html>
<!DOCTYPE>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title>活動投票</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="apple-touch-icon" href="e7line/icon.png">
    <!-- Place favicon.ico in the root directory -->

    <link rel="stylesheet" href="e7line/css/reset.css">
    <link rel="stylesheet" href="e7line/css/layout.css">
    <link rel="stylesheet" href="e7line/css/vote.css">

    <meta name="theme-color" content="#fafafa">
</head>

<body>
<div class="container">

    <div class="search row" align-y="center">
        <form action="/vote" method="get">
            <button style="background-color: Transparent;border: none;cursor:pointer;overflow: hidden;outline:none;"
                    type="submit">
                <img src="e7line/img/search.svg" style="border: 0" alt=""></button>
            <input name="search_info" type="text" placeholder="請搜尋投票內容" value="{{$search_info}}">
        </form>
    </div>

    <h2 class="open">開放投票中</h2>
    <ul class="open column">
        @foreach($open_votes as $vote)
            <li>
                <a href="{{route('voting',$vote->id)}}" class="column">
                    <div class="row" align-x="space-between" align-y="center">
                        @php($vote_detail = \App\VoteDetail::where('email','=',Session::get('member')['Email'])
->where('vote_id','=',$vote->id)->first())
                        @if($vote_detail)
                            <span>【已投票】</span>
                        @else
                            <span>【未投票】</span>
                        @endif
                        <span>{{date('Y/m/d',strtotime($vote->deadline))}}</span>
                    </div>
                    <div class="row" align-x="space-between">
                        <h3>{{$vote->title}}</h3>
                        <img src="e7line/img/right.svg" alt="">
                    </div>
                </a>
            </li>
        @endforeach

    </ul>
    {{$open_votes->appends(request()->input())->links('vendor.pagination.e7line')}}


    <h2 class="close">已結束</h2>
    <ul class="close column">
        @foreach($close_votes as $vote)
            <li>
                <a href="" class="column">
                    <div class="row" align-y="center">
                        @php($vote_detail = \App\VoteDetail::where('email','=',Session::get('member')['Email'])
->where('vote_id','=',$vote->id)->first())
                        @if($vote_detail)
                            <span>【已投票】</span>
                        @else
                            <span>【未投票】</span>
                        @endif
                        <span>{{date('Y/m/d',strtotime($vote->deadline))}}</span>
                        <span class="center">
                            最高票
                        </span>
                        <span>{{$close_result[$vote->id]}}</span>
                    </div>
                    <div class="row" align-x="space-between">
                        <h3>{{$vote->title}}</h3>
                        <img src="e7line/img/right.svg" alt="">
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
    {{$close_votes->appends(request()->input())->links('vendor.pagination.e7line')}}
</div>


<header class="row" align-x="center" align-y="bottom">
    <a href="/" class="row" align-y="center">
        <img src="e7line/img/left.svg" alt="">
        返回
    </a>

    <h1><a href="/vote" style="text-decoration: none;color: inherit;all: inherit">活動投票 </a></h1>

    <img class="menu" src="e7line/img/menu.svg" alt="">
</header>
<nav class="close">
    <div class="mask"></div>
    <div class="menu">
        <ul>
            <li><a href="https://www.e7line.com/">好康商品</a></li>
            <li><a href="/announcement">福委公告</a></li>
            <li><a href="/vote">活動投票</a></li>
            <li><a href="/search">各式查詢</a></li>
        </ul>
        @if (session('member'))
            <button><a style="text-decoration: none;color: inherit" href="{{route('front_end.logout')}}">登出</a></button>
        @else
            <button><a style="text-decoration: none;color: inherit" href="{{route('front_end.login')}}">登入</a></button>

        @endif
        <img class="close" src="e7line/img/close.png" alt="">
    </div>
</nav>
</body>
<script>
    const menuButton = document.querySelector('header .menu');
    const close = document.querySelector('nav .close');
    const nav = document.querySelector('nav');
    const mask = document.querySelector('nav .mask');

    menuButton.addEventListener('click', () => {
        nav.classList.remove('close')
    });
    close.addEventListener('click', () => {
        nav.classList.add('close')
    });
    mask.addEventListener('click', () => {
        nav.classList.add('close')
    });
</script>
</html>
