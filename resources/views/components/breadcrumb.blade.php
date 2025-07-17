@props(['items'])

<nav class="flex mb-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        @foreach($items as $index => $item)
            @if($loop->last)
                <li aria-current="page">
                    <div class="flex items-center">
                        @if($index > 0)
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        @endif
                        <span class="text-sm font-medium text-gray-500 md:ml-2">{{ $item['label'] }}</span>
                    </div>
                </li>
            @else
                <li>
                    <div class="flex items-center">
                        @if($index > 0)
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        @endif
                        <a href="{{ $item['url'] }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600 md:ml-2">
                            {{ $item['label'] }}
                        </a>
                    </div>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
