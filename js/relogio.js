function obterDataHoraAtual() {
    const agora = new Date();

    // Obter os nomes dos dias da semana e meses
    const diasSemana = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];
    const meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

    // Formatar data
    const diaSemana = diasSemana[agora.getDay()];
    const dia = agora.getDate();
    const mes = meses[agora.getMonth()];
    const ano = agora.getFullYear();

    return `${diaSemana}, ${dia} de ${mes} de ${ano}`;
}

// Inserir a data no HTML
function atualizarData() {
    const divDate = document.querySelector('.date-span');
    if (divDate) {
        divDate.textContent = obterDataHoraAtual();
    }
}

// Atualizar a data ao carregar a página
document.addEventListener('DOMContentLoaded', atualizarData);
