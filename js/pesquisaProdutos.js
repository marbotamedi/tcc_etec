$(document).ready(function () {
    $('#formPesquisa').on('submit', function (e) {
        e.preventDefault();

        var termoPesquisa = $('#campo-Pesquisa').val();

            $.ajax({
                url: 'pesquisa.php',
                method: 'POST',
                data: { campoPesquisa: termoPesquisa },
                success: function (response) {
                    $('#tabelaProdutos tbody').html(response);
                },
                error: function () {
                    $('#tabelaProdutos tbody').html('<tr><td colspan="5">Erro ao realizar a pesquisa.</td></tr>');
                }
            });


    });
    $('#btn-clear').on('click', function () {
        $('#campo-Pesquisa').val('');
            $.ajax({
                url: 'pesquisa.php',
                method: 'POST',
                data: { campoPesquisa: '' },
                success: function (response) {
                    $('#tabelaProdutos tbody').html(response);
                },
                error: function () {
                    $('#tabelaProdutos tbody').html('<tr><td colspan="5">Erro ao realizar a pesquisa.</td></tr>');
                }
            });


    });

    function testar(oi){
        console.log(oi);
    }
    testar();
});