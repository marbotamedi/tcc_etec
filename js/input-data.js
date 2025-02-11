// Função para alternar os campos de data com base na seleção do tipo
function toggleDateFields() {
    var dateType = document.getElementById('date-type').value;
    var dateRange = document.getElementById('date-range');
    var specificDate = document.getElementById('specific-date');

    if (dateType === 'range') {
        dateRange.style.display = 'block';
        specificDate.style.display = 'none';
    } else if (dateType === 'specific') {
        dateRange.style.display = 'none';
        specificDate.style.display = 'block';
    }
}

// Função para gerar a impressão do relatório


// Função para exibir a data atual no formato desejado
function updateDate() {
    var date = new Date();
    var formattedDate = date.toLocaleDateString('pt-BR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        weekday: 'long'
    });
    var dateSpan = document.querySelector(".date-span");
    if (dateSpan) {
        dateSpan.textContent = formattedDate;
    }
    
}

// Atualiza a data ao carregar a página
window.onload = updateDate;

// Evento para chamar a função de alternância de campos de data
document.getElementById('date-type').addEventListener('change', toggleDateFields);
