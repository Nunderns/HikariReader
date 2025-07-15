// Configurações globais para requisições AJAX
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Configuração do SweetAlert2
window.Swal = require('sweetalert2');

// Configuração do Alpine.js
document.addEventListener('alpine:init', () => {
    // Adicione aqui qualquer inicialização global do Alpine.js
});

// Gerenciamento de loading global
const Loading = {
    show: function(text = 'Processando...') {
        const loadingElement = document.getElementById('global-loading');
        const textElement = loadingElement.querySelector('p');
        if (textElement) {
            textElement.textContent = text;
        }
        loadingElement.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    },
    
    hide: function() {
        const loadingElement = document.getElementById('global-loading');
        loadingElement.classList.add('hidden');
        document.body.style.overflow = '';
    }
};

// Configuração global de erros do Axios
window.axios.interceptors.request.use(
    config => {
        if (!config.headers['X-Loading-Ignore']) {
            Loading.show(config.loadingText || 'Enviando dados...');
        }
        return config;
    },
    error => {
        Loading.hide();
        return Promise.reject(error);
    }
);

window.axios.interceptors.response.use(
    response => {
        Loading.hide();
        return response;
    },
    error => {
        Loading.hide();
        
        if (error.response) {
            // Erros de validação
            if (error.response.status === 422) {
                const errors = error.response.data.errors;
                let errorMessage = 'Por favor, corrija os seguintes erros:\n\n';
                
                for (const field in errors) {
                    errorMessage += `- ${errors[field].join('\n- ')}`;
                }
                
                window.Swal.fire({
                    icon: 'error',
                    title: 'Erro de validação',
                    text: errorMessage,
                    confirmButtonText: 'Entendi',
                    confirmButtonColor: '#4f46e5',
                });
            } 
            // Erro 403 - Acesso negado
            else if (error.response.status === 403) {
                window.Swal.fire({
                    icon: 'warning',
                    title: 'Acesso negado',
                    text: 'Você não tem permissão para realizar esta ação.',
                    confirmButtonText: 'Entendi',
                    confirmButtonColor: '#4f46e5',
                });
            } 
            // Erro 404 - Não encontrado
            else if (error.response.status === 404) {
                window.Swal.fire({
                    icon: 'error',
                    title: 'Não encontrado',
                    text: 'O recurso solicitado não foi encontrado.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#4f46e5',
                }).then(() => {
                    window.location.href = '/admin';
                });
            } 
            // Erro 500 - Erro interno do servidor
            else if (error.response.status >= 500) {
                window.Swal.fire({
                    icon: 'error',
                    title: 'Erro no servidor',
                    text: 'Ocorreu um erro inesperado. Por favor, tente novamente mais tarde.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#4f46e5',
                });
            }
        } else if (error.request) {
            // A requisição foi feita mas não houve resposta
            window.Swal.fire({
                icon: 'error',
                title: 'Sem resposta do servidor',
                text: 'Não foi possível conectar ao servidor. Verifique sua conexão com a internet.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#4f46e5',
            });
        } else {
            // Algo aconteceu na configuração da requisição
            console.error('Erro na requisição:', error.message);
        }
        
        return Promise.reject(error);
    }
);

// Função para confirmar exclusão
window.confirmDelete = function(formId, title = 'Tem certeza?', text = 'Esta ação não pode ser desfeita!', confirmButtonText = 'Sim, excluir!') {
    return new Promise((resolve) => {
        window.Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b7280',
            confirmButtonText: confirmButtonText,
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                if (formId) {
                    document.getElementById(formId).submit();
                }
                resolve(true);
            } else {
                resolve(false);
            }
        });
    });
};

// Inicialização quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', function() {
    // Adiciona classe ao body para indicar que o JavaScript está ativo
    document.body.classList.add('js-enabled');
    
    // Adiciona classe ao body para indicar que o usuário está logado como admin
    document.body.classList.add('admin-logged-in');
    
    // Inicializa tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new window.bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Inicializa popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new window.bootstrap.Popover(popoverTriggerEl);
    });
});

// Exporta as funções globais
window.Loading = Loading;
