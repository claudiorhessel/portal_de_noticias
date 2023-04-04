<section class="news">
    <div class="center">
        <div class="wraper-news">
            <h3>Editar Notícia</h3>
            <div class="single-news-show">
                <form action={{ route('news.update') }}  method="POST" id="save-content-form">
                    @method('patch')
                    @csrf
                    <input type="hidden" name="author_id" value="{{ $news->author_id }}"/>
                    <input type="hidden" name="id" value="{{ $news->id }}"/>
                    <div class="mb-3">
                        <label for="title" class="form-label">Título</label>
                        <input type="text" name="title" value="{{ $news->title }}"/>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Categoria</label>
                        <select name="category_id">
                            @foreach ($categories as $category)
                            <option @selected($category->id == $news->category_id) value="{{ $category->id }}"
                                @class([
                                'bg-purple-600 text-white' => $category->id == $news->category_id
                                ])>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="body" class="form-label">Notícia</label>
                        <textarea class="form-control" id="wysiwyg_content" name="wysiwyg_content">{{ $news->wysiwyg_content }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ url("/portal/$news->id") }}" class="btn btn-default">Voltar</a>
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
