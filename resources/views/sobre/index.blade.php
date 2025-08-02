@extends('layouts.app')

@section('title', 'Sobre - ' . config('app.name', 'HikariReader'))

@push('styles')
<style>
    .prose {
        color: #374151; /* gray-700 */
        line-height: 1.75;
    }
    
    .dark .prose {
        color: #ffffff; /* white - melhor contraste */
    }
    
    .prose h1, 
    .prose h2, 
    .prose h3, 
    .prose h4 {
        color: #1f2937; /* gray-800 */
        font-weight: 700;
        margin-top: 1.5em;
        margin-bottom: 0.75em;
        line-height: 1.375;
    }
    
    .dark .prose h1,
    .dark .prose h2,
    .dark .prose h3,
    .dark .prose h4 {
        color: #ffffff; /* white */
    }
    
    .prose p {
        margin-bottom: 1.25em;
        line-height: 1.75;
    }
    
    .prose a {
        color: #4f46e5; /* indigo-600 */
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }
    
    .dark .prose a {
        color: #6366f1; /* indigo-500 - mais visível no escuro */
    }
    
    .prose a:hover {
        text-decoration: underline;
        color: #4338ca; /* indigo-700 */
    }
    
    .dark .prose a:hover {
        color: #818cf8; /* indigo-400 */
    }
    
    .prose strong {
        font-weight: 600;
    }
    
    /* Caixas de destaque */
    .prose .highlight-box {
        border-left-width: 4px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border-radius: 0 0.375rem 0.375rem 0;
    }
    
    .prose .bg-blue-50 {
        background-color: #eff6ff; /* blue-50 */
        border-color: #3b82f6; /* blue-500 */
    }
    
    .dark .prose .bg-blue-50 {
        background-color: rgba(30, 58, 138, 0.3); /* blue-900 com transparência */
        border-color: #60a5fa; /* blue-400 */
    }
    
    .prose .bg-green-50 {
        background-color: #f0fdf4; /* green-50 */
        border-color: #10b981; /* green-500 */
    }
    
    .dark .prose .bg-green-50 {
        background-color: rgba(5, 46, 22, 0.3); /* green-900 com transparência */
        border-color: #34d399; /* green-400 */
    }
    
    .prose .bg-amber-50 {
        background-color: #fffbeb; /* amber-50 */
        border-color: #f59e0b; /* amber-500 */
    }
    
    .dark .prose .bg-amber-50 {
        background-color: rgba(69, 26, 3, 0.3); /* amber-900 com transparência */
        border-color: #fbbf24; /* amber-400 */
    }
    
    .prose .bg-emerald-50 {
        background-color: #ecfdf5; /* emerald-50 */
        border-color: #10b981; /* emerald-500 */
    }
    
    .dark .prose .bg-emerald-50 {
        background-color: rgba(6, 78, 59, 0.3); /* emerald-900 com transparência */
        border-color: #34d399; /* emerald-400 */
    }
    
    /* Container principal */
    .content-container {
        background-color: #ffffff; /* white */
    }
    
    .dark .content-container {
        background-color: #1f2937; /* gray-800 - mais escuro que o padrão */
    }
    
    /* Sombra no modo escuro */
    .dark .shadow-md {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2), 0 2px 4px -1px rgba(0, 0, 0, 0.1);
    }
    
    /* Transições suaves */
    .dark .prose,
    .dark .prose h1,
    .dark .prose h2,
    .dark .prose h3,
    .dark .prose h4,
    .dark .prose p,
    .dark .prose a,
    .dark .highlight-box {
        transition: color 0.3s ease, background-color 0.3s ease;
    }
</style>
@endpush

@section('content')
<div class="w-full bg-white dark:bg-gray-900 py-12">

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="content-container rounded-lg shadow-md p-6 transition-colors duration-300">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6">Sobre o Hikari Reader</h1>
            
            <div class="prose max-w-none dark:prose-invert">
                <p class="text-gray-700 dark:text-white mb-6">
                    O Hikari Reader é uma plataforma de leitura online de mangás que abrange diversos idiomas. 
                    Nosso objetivo é fornecer uma experiência de leitura agradável e acessível para fãs de mangá em todo o mundo.
                </p>
                
                <div class="mb-6">
                    <p class="text-blue-700 dark:text-blue-300">
                        <strong>Importante:</strong> Todo o conteúdo em nosso site é postado por usuários e grupos de fãs. 
                        Respeitamos os direitos autorais e incentivamos o suporte às versões oficiais sempre que possível.
                    </p>
                </div>
                
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mt-8 mb-4">Nossa Missão</h2>
                <p class="text-gray-700 dark:text-white mb-6">
                    Acreditamos que a cultura dos mangás deve ser acessível a todos. Nosso objetivo é criar uma comunidade 
                    onde os fãs possam desfrutar de suas histórias favoritas, descobrir novos títulos e se conectar com outros 
                    entusiastas de mangá.
                </p>
                
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mt-8 mb-4">Suporte</h2>
                <p class="text-gray-700 dark:text-white mb-4">
                    Se você tiver alguma dúvida, sugestão ou precisar de ajuda, não hesite em entrar em contato conosco através 
                    do nosso servidor do Discord ou pelo formulário de contato.
                </p>
                
                <div class="highlight-box bg-amber-50 dark:bg-amber-900/30 mt-8">
                    <h3 class="text-xl font-semibold text-amber-900 dark:text-white mb-4">Aviso Importante</h3>
                    <p class="text-amber-800 dark:text-white">
                        Os membros da nossa equipe <strong>NUNCA</strong> irão pedir sua senha ou informações financeiras. 
                        Se alguém entrar em contato com você alegando ser da equipe do Hikari Reader solicitando esses dados, 
                        por favor, não responda e nos avise imediatamente.
                    </p>
                </div>
                
                <div class="highlight-box bg-emerald-50 dark:bg-emerald-900/30 mt-8">
                    <h3 class="text-xl font-semibold text-emerald-900 dark:text-white mb-3">Apoie os Criadores</h3>
                    <p class="text-emerald-800 dark:text-white">
                        O Hikari Reader é financiado por meio de programas afiliados e doações. Se você gosta da nossa plataforma, 
                        considere apoiar os criadores comprando os volumes oficiais dos seus mangás favoritos sempre que possível.
                    </p>
                </div>
            </div>
        </div>
    </main>

</div>
@endsection