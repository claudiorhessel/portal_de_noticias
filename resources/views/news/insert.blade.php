<section class="news">
    <div class="center">
        <div class="wraper-news">
            <h3>Inserir Notícia</h3>
            <div class="single-news-show">
                <form action={{ route('news.store') }}  method="POST" id="save-content-form">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Título</label>
                        <input type="text" name="title" value="{{ old("title") }}"/>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Categoria</label>
                        <select name="category_id">
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="author_id" class="form-label">Autor</label>
                        <select name="author_id">
                            @foreach ($authors as $author)
                            <option value="{{ $author->id }}">
                                {{ $author->nickname }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="body" class="form-label">Body</label>
                        <textarea class="form-control" id="wysiwyg_content" name="wysiwyg_content">
                            {{ old("wysiwyg_content") }}
                        </textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ url("/portal") }}" class="btn btn-default">Voltar</a>
                </form>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    tinymce.init({
        selector: 'textarea#wysiwyg_content',
        height: 600
    });
</script>
