<section class="news">
    <div class="center">
        <div class="wraper-news">
            @foreach ($news->data as $newsData)
            <div class="single-news">
                <h3>{{ $newsData->title }}</h3>
                {{ $teste = '' }}
                @if(strlen($newsData->wysiwyg_content > 200))
                    <p>{!! substr($newsData->wysiwyg_content, 0,  200) . ' ...' !!}</p>
                @else
                    <p>{!! $newsData->wysiwyg_content !!}</p>
                @endif
                <div class="news-button">
                    <a href="/portal/{{ $newsData->id }}">Acessar</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
