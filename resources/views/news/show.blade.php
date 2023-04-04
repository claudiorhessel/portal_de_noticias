<section class="news">
    <div class="center">
        <div class="wraper-news">
            <div class="single-news-show">
                <h3>{{ $news->title }}</h3>
                <div>{!! $news->wysiwyg_content !!}</div>
                <div class="news-show-button">
                    <a href="/portal">Voltar</a>
                    <a href="/portal/news/edit/{{ $news->id }}">Editar</a>
                    <a href="/portal/news/delete/{{ $news->id }}">Excluir</a>
                </div>
            </div>
        </div>
    </div>
</section>
