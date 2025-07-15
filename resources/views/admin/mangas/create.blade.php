@extends('admin.layouts.app')

@section('title', 'Adicionar Novo Mangá')

@section('header', 'Adicionar Novo Mangá')

@section('content')
<div class="bg-white shadow rounded-lg overflow-hidden">
    <form action="{{ route('admin.mangas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                <!-- Título -->
                <div class="sm:col-span-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Título *</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Título em Inglês -->
                <div class="sm:col-span-4">
                    <label for="english_title" class="block text-sm font-medium text-gray-700">Título em Inglês</label>
                    <input type="text" name="english_title" id="english_title" value="{{ old('english_title') }}"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    @error('english_title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Autor -->
                <div class="sm:col-span-4">
                    <label for="author" class="block text-sm font-medium text-gray-700">Autor *</label>
                    <input type="text" name="author" id="author" value="{{ old('author') }}" required
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    @error('author')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Artista -->
                <div class="sm:col-span-4">
                    <label for="artist" class="block text-sm font-medium text-gray-700">Artista</label>
                    <input type="text" name="artist" id="artist" value="{{ old('artist') }}"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    @error('artist')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Capa -->
                <div class="sm:col-span-6">
                    <label class="block text-sm font-medium text-gray-700">Capa</label>
                    <div class="mt-1 flex items-center">
                        <span class="inline-block h-40 w-32 rounded overflow-hidden bg-gray-100">
                            <img id="cover-preview" src="https://via.placeholder.com/200x300?text=Sem+Imagem" alt="Pré-visualização da capa" class="h-full w-full object-cover">
                        </span>
                        <input type="file" name="cover" id="cover" accept="image/*" class="ml-5 block text-sm text-gray-500" onchange="previewCover(this)">
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Imagem em formato JPG, PNG ou GIF (máx. 2MB)</p>
                    @error('cover')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descrição -->
                <div class="sm:col-span-6">
                    <label for="description" class="block text-sm font-medium text-gray-700">Descrição *</label>
                    <div class="mt-1">
                        <textarea id="description" name="description" rows="6" required
                                  class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('description') }}</textarea>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Forneça uma descrição detalhada do mangá.</p>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="sm:col-span-3">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                    <select id="status" name="status" required
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="" disabled selected>Selecione um status</option>
                        <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Em andamento</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completo</option>
                        <option value="hiatus" {{ old('status') == 'hiatus' ? 'selected' : '' }}>Em hiato</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                        <option value="not_yet_published" {{ old('status') == 'not_yet_published' ? 'selected' : '' }}>Não publicado</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Demografia -->
                <div class="sm:col-span-3">
                    <label for="demographic" class="block text-sm font-medium text-gray-700">Demografia</label>
                    <input type="text" name="demographic" id="demographic" value="{{ old('demographic') }}"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    <p class="mt-1 text-sm text-gray-500">Ex: Shounen, Seinen, Shoujo, Josei</p>
                    @error('demographic')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Serialização -->
                <div class="sm:col-span-3">
                    <label for="serialization" class="block text-sm font-medium text-gray-700">Serialização</label>
                    <input type="text" name="serialization" id="serialization" value="{{ old('serialization') }}"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    @error('serialization')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Data de Publicação -->
                <div class="sm:col-span-3">
                    <label for="published_date" class="block text-sm font-medium text-gray-700">Data de Publicação</label>
                    <input type="date" name="published_date" id="published_date" value="{{ old('published_date') }}"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    @error('published_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gêneros -->
                <div class="sm:col-span-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gêneros</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2">
                        @php
                            $genres = [
                                'Ação', 'Aventura', 'Comédia', 'Drama', 'Fantasia', 'Horror',
                                'Mistério', 'Romance', 'Sci-Fi', 'Sobrenatural', 'Esportes', 'Suspense',
                                'Slice of Life', 'Comédia Romântica', 'Artes Marciais', 'Escolar', 'Vida Diária'
                            ];
                            $selectedGenres = old('genres', []);
                        @endphp
                        
                        @foreach($genres as $genre)
                            <div class="flex items-center">
                                <input id="genre-{{ Str::slug($genre) }}" name="genres[]" type="checkbox" value="{{ $genre }}"
                                       {{ in_array($genre, $selectedGenres) ? 'checked' : '' }}
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="genre-{{ Str::slug($genre) }}" class="ml-2 block text-sm text-gray-700">
                                    {{ $genre }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('genres')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Temas -->
                <div class="sm:col-span-6">
                    <label for="themes" class="block text-sm font-medium text-gray-700">Temas (separados por vírgula)</label>
                    <input type="text" name="themes" id="themes" value="{{ old('themes') }}"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    <p class="mt-1 text-sm text-gray-500">Ex: Ação, Aventura, Comédia, Drama, Fantasia</p>
                    @error('themes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Títulos Alternativos -->
                <div class="sm:col-span-6">
                    <label for="alt_titles" class="block text-sm font-medium text-gray-700">Títulos Alternativos (um por linha)</label>
                    <textarea id="alt_titles" name="alt_titles" rows="3"
                              class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('alt_titles') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">Um título por linha</p>
                    @error('alt_titles')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Opções -->
                <div class="sm:col-span-6">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="is_adult" name="is_adult" type="checkbox" value="1" {{ old('is_adult') ? 'checked' : '' }}
                                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="is_adult" class="font-medium text-gray-700">Conteúdo Adulto (+18)</label>
                            <p class="text-gray-500">Marque se o mangá contém conteúdo adulto.</p>
                        </div>
                    </div>
                    @error('is_adult')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-6">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="is_suggestive" name="is_suggestive" type="checkbox" value="1" {{ old('is_suggestive') ? 'checked' : '' }}
                                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="is_suggestive" class="font-medium text-gray-700">Conteúdo Sugestivo</label>
                            <p class="text-gray-500">Marque se o mangá contém conteúdo sugestivo ou ecchi.</p>
                        </div>
                    </div>
                    @error('is_suggestive')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <a href="{{ route('admin.mangas.index') }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
                Cancelar
            </a>
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Salvar Mangá
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function previewCover(input) {
        const preview = document.getElementById('cover-preview');
        const file = input.files[0];
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            
            reader.readAsDataURL(file);
        }
    }
    
    // Initialize select2 for better multiple select experience
    document.addEventListener('DOMContentLoaded', function() {
        // This would be used if you're using select2 for better UI
        // You'll need to include select2 CSS and JS in your layout
        // $('.select2-multiple').select2({
        //     placeholder: 'Selecione os gêneros',
        //     allowClear: true,
        //     tags: true
        // });
    });
</script>
@endpush
@endsection
