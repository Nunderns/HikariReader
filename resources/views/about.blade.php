@extends('layouts.app')

@section('content')
<div class="w-full bg-white py-12">
    <div class="w-full max-w-none px-0">
        <div class="px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Sobre o Hikari Reader</h1>
            
            <div class="prose max-w-none">
                <p class="text-gray-700 mb-6">
                    O Hikari Reader é uma plataforma de leitura online de mangás que abrange diversos idiomas. 
                    Nosso objetivo é fornecer uma experiência de leitura agradável e acessível para fãs de mangá em todo o mundo.
                </p>
                
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded">
                    <p class="text-blue-700">
                        <strong>Importante:</strong> Todo o conteúdo em nosso site é postado por usuários e grupos de fãs. 
                        Respeitamos os direitos autorais e incentivamos o suporte às versões oficiais sempre que possível.
                    </p>
                </div>
                
                <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">Nossa Missão</h2>
                <p class="text-gray-700 mb-6">
                    Acreditamos que a cultura dos mangás deve ser acessível a todos. Nosso objetivo é criar uma comunidade 
                    onde os fãs possam desfrutar de suas histórias favoritas, descobrir novos títulos e se conectar com outros 
                    entusiastas de mangá.
                </p>
                
                <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">Suporte</h2>
                <p class="text-gray-700 mb-4">
                    Se você tiver alguma dúvida, sugestão ou precisar de ajuda, não hesite em entrar em contato conosco através 
                    do nosso servidor do Discord ou pelo formulário de contato.
                </p>
                
                <div class="mt-8 p-6 bg-gray-50 rounded-lg">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Aviso Importante</h3>
                    <p class="text-gray-700">
                        Os membros da nossa equipe <strong>NUNCA</strong> irão pedir sua senha ou informações financeiras. 
                        Se alguém entrar em contato com você alegando ser da equipe do Hikari Reader solicitando esses dados, 
                        por favor, não responda e nos avise imediatamente.
                    </p>
                </div>
                
                <div class="mt-8 p-6 bg-green-50 border-l-4 border-green-500 rounded">
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Apoie os Criadores</h3>
                    <p class="text-gray-700">
                        O Hikari Reader é financiado por meio de programas afiliados e doações. Se você gosta da nossa plataforma, 
                        considere apoiar os criadores comprando os volumes oficiais dos seus mangás favoritos sempre que possível.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
