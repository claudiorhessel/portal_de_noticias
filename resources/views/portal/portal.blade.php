@extends('layouts.default')
@section('content')
<header>
    <div class="center">
        <div class="wraper-header">
            <div class="logo"></div>
            <div class="header-menu">
                <nav>
                    <ul class="menu">
                        <li><a href="/portal/news/insert">Cadastrar Notícias</a></li>
                        <li><a href="/portal">Exibir Notícias</a></li>
                    </ul>
                </nav>
            </div>
            <div class="search">
                <form action={{ url("/portal/search") }} method="GET" class="wraper-search">
                    <input type="search" id="search" name="search" class="header-input-search" value="{{ $search }}"/>
                    <button class="button-search" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
</header>
<footer>
    <div class="center">
        <div class="wraper-footer">
            <span class="footer">Desenvolvido por <a href="https://curriculo.claudiorhessel.com.br">Cláudio Rocumback Hessel</a></span>
        </div>
    </div>
</footer>
@include('flash-message')
@switch($origin)
    @case('index')
        @include('portal.news')
        @break
    @case('show')
        @include('news.show')
        @break
    @case('edit')
        @include('news.edit')
        @break
    @case('insert')
        @include('news.insert')
        @break
    @case('update')
        @include('news.update')
        @break
    @default
        @include('portal.news')
        @break
@endswitch
@endsection

