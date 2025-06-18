@extends('layouts.error')

@section('content')
<div class="flex flex-col items-center justify-center w-full h-screen p-6">
    <div class="w-full max-w-2xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="p-8 text-center">
            <!-- Cat SVG -->
            <div class="mb-8 mx-auto w-64
                transition-all duration-500 transform hover:scale-105">
                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Cat body -->
                    <path d="M40 120C40 92.3858 62.3858 70 90 70H110C137.614 70 160 92.3858 160 120V150C160 157.732 153.732 164 146 164H54C46.268 164 40 157.732 40 150V120Z" fill="#FCD34D" class="text-yellow-300"/>
                    
                    <!-- Books -->
                    <rect x="45" y="130" width="10" height="30" rx="2" fill="#4F46E5" class="text-indigo-600"/>
                    <rect x="60" y="125" width="10" height="35" rx="2" fill="#10B981" class="text-emerald-500"/>
                    <rect x="75" y="120" width="10" height="40" rx="2" fill="#EC4899" class="text-pink-500"/>
                    <rect x="90" y="115" width="10" height="45" rx="2" fill="#8B5CF6" class="text-violet-500"/>
                    <rect x="105" y="120" width="10" height="40" rx="2" fill="#3B82F6" class="text-blue-500"/>
                    <rect x="120" y="125" width="10" height="35" rx="2" fill="#F59E0B" class="text-amber-500"/>
                    <rect x="135" y="130" width="10" height="30" rx="2" fill="#EF4444" class="text-red-500"/>
                    
                    <!-- Cat sleeping on books -->
                    <circle cx="80" cy="105" r="20" fill="#FCD34D" class="text-yellow-300"/>
                    <circle cx="80" cy="105" r="12" fill="#1F2937" class="text-gray-800"/>
                    <path d="M70 100C71.1046 100 72 100.895 72 102C72 103.105 71.1046 104 70 104C68.8954 104 68 103.105 68 102C68 100.895 68.8954 100 70 100Z" fill="white"/>
                    <path d="M90 100C91.1046 100 92 100.895 92 102C92 103.105 91.1046 104 90 104C88.8954 104 88 103.105 88 102C88 100.895 88.8954 100 90 100Z" fill="white"/>
                    <path d="M75 110C75 108.895 77.6863 108 81 108C84.3137 108 87 108.895 87 110" stroke="#1F2937" stroke-width="2" stroke-linecap="round"/>
                    
                    <!-- Cat ears -->
                    <path d="M65 80L75 95H75.5L65 80Z" fill="#FCD34D" class="text-yellow-300"/>
                    <path d="M95 80L85 95H84.5L95 80Z" fill="#FCD34D" class="text-yellow-300"/>
                    
                    <!-- Zzz -->
                    <text x="110" y="90" font-family="Arial" font-size="12" fill="#1F2937" class="opacity-75">ZzZz</text>
                </svg>
            </div>
            
            <!-- Error message -->
            <h1 class="text-6xl font-bold text-gray-800 mb-4">404</h1>
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Página não encontrada</h2>
            <p class="text-gray-600 mb-8">
                @if(isset($exception) && $exception->getMessage())
                    {{ $exception->getMessage() }}
                @else
                    A página que você está procurando não existe ou foi movida.
                @endif
            </p>
            
            <!-- Back to home button -->
            <a href="{{ url('/') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Voltar para a página inicial
            </a>
        </div>
    </div>
    
    <!-- Floating home button -->
    <div class="absolute bottom-8 right-8">
        <a href="{{ url('/') }}" class="flex items-center justify-center w-12 h-12 rounded-full bg-indigo-600 text-white shadow-lg hover:bg-indigo-700 transition-colors" 
           title="Voltar para a página inicial">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
        </a>
    </div>
</div>
@endsection
