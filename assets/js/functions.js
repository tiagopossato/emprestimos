(function ($) {
    function removeCampo() {
        $(".removerCampo").unbind("click");
        $(".removerCampo").bind("click", function () {
            i = 0;
            $("#materiais tr").each(function () {
                i++;
            });
            if (i > 2) {
                $(this).parent().parent().remove();
            }
        });
    }
    removeCampo();

    $(".adicionarCampo").click(function () {
        novoCampo = $("#materiais tr:last").clone();
        novoCampo.find("quantidade").val("1");
        novoCampo.insertAfter("#materiais tr:last");
        removeCampo();
    });
//http://www.vivaolinux.com.br/topico/jQuery/Adicionar-e-Remover-linhas-de-uma-tabela
})(jQuery);
