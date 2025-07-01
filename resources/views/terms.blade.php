@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">
                Termos e Políticas
            </h1>
            <p class="mt-5 max-w-xl mx-auto text-xl text-gray-500">
                Conheça nossas políticas e termos de uso da plataforma
            </p>
        </div>

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <div class="p-8">
                <div class="prose prose-indigo prose-lg text-gray-500 mx-auto mb-12">
                    <p class="text-lg">
                        O HikariReader busca cumprir com todas as leis locais e internacionais. 
                        Você pode encontrar os documentos relacionados à conformidade abaixo. 
                        Em caso de divergência entre documentos, os Termos de Serviço serão considerados o documento oficial.
                    </p>
                    <p class="mt-4 text-lg">
                        Se precisar de esclarecimentos sobre alguma política publicada, entre em contato conosco.
                    </p>
                </div>

                <div class="grid gap-8 md:grid-cols-2">
                    <!-- Termos de Serviço -->
                    <div class="bg-gray-50 p-6 rounded-xl hover:bg-gray-100 transition duration-200">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 bg-indigo-100 p-3 rounded-lg">
                                <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="ml-4 text-xl font-bold text-gray-900">Termos de Serviço</h3>
                        </div>
                        <p class="text-gray-600 mb-6">
                            Nossos Termos de Serviço descrevem o uso aceitável do site. Ao utilizar a plataforma, você concorda em cumpri-los.
                        </p>
                        <a href="#" class="inline-flex items-center text-indigo-600 font-medium hover:text-indigo-800 transition duration-150 ease-in-out">
                            Ler mais
                            <svg class="ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>

                    <!-- Política de Conteúdo -->
                    <div class="bg-gray-50 p-6 rounded-xl hover:bg-gray-100 transition duration-200">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 bg-green-100 p-3 rounded-lg">
                                <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <h3 class="ml-4 text-xl font-bold text-gray-900">Política de Conteúdo</h3>
                        </div>
                        <p class="text-gray-600 mb-6">
                            Nossa Política de Conteúdo descreve o que é permitido compartilhar e contribuir no HikariReader.
                        </p>
                        <a href="#" class="inline-flex items-center text-green-600 font-medium hover:text-green-800 transition duration-150 ease-in-out">
                            Ler mais
                            <svg class="ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>

                    <!-- Política de Privacidade -->
                    <div class="bg-gray-50 p-6 rounded-xl hover:bg-gray-100 transition duration-200">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 bg-blue-100 p-3 rounded-lg">
                                <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h3 class="ml-4 text-xl font-bold text-gray-900">Política de Privacidade</h3>
                        </div>
                        <p class="text-gray-600 mb-6">
                            Saiba como protegemos seus dados e quais são seus direitos em relação às suas informações pessoais.
                        </p>
                        <a href="#" class="inline-flex items-center text-blue-600 font-medium hover:text-blue-800 transition duration-150 ease-in-out">
                            Ler mais
                            <svg class="ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>

                    <!-- Política de Direitos Autorais -->
                    <div class="bg-gray-50 p-6 rounded-xl hover:bg-gray-100 transition duration-200">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 bg-purple-100 p-3 rounded-lg">
                                <svg class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h3 class="ml-4 text-xl font-bold text-gray-900">Direitos Autorais</h3>
                        </div>
                        <p class="text-gray-600 mb-6">
                            Nossa política de direitos autorais e DMCA explica como denunciar conteúdo que infrinja seus direitos.
                        </p>
                        <a href="#" class="inline-flex items-center text-purple-600 font-medium hover:text-purple-800 transition duration-150 ease-in-out">
                            Ler mais
                            <svg class="ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-gray-200 text-center">
                    <div class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        <svg class="-ml-1 mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Entre em Contato Conosco
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
