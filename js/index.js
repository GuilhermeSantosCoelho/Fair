$(function(){

    $('#nome_evento').focus(function(){ /* Limpa o retorno caso o input seja clicado */
        document.getElementById('retorno_evento').innerHTML = '';
    });

    $('#nome_produto').focus(function(){ /* Limpa o retorno caso o input seja clicado */
        document.getElementById('retorno_produto').innerHTML = '';
    });

    $('#nome_pessoa').focus(function(){ /* Limpa o retorno caso o input seja clicado */
        document.getElementById('retorno_pessoa').innerHTML = '';
    });

    $("#btn_add_evento").click(function(){ /* Função caso o botão de adicionar evento seja clicado */
        /* Obtendo o nome que o usuário digitou */
        var nome_evento = $("#nome_evento").val();
        /* Limpa o input */
        $("#nome_evento").val("");

        if (nome_evento != '') { /* Verificando se o nome do evento está em branco */
            $.post("funcoes/funcoes.php", { /* Fazendo requisição via POST para cadastrar o evento */
                funcao: 'cadastrar_evento',
                nome_evento: nome_evento
            }, function(retorno){ 
                if(retorno == 1){ /* Verificando se o evento foi cadastrado */
                    document.getElementById('retorno_evento').style.color = 'green';
                    document.getElementById('retorno_evento').innerHTML = 'Evento cadastrado!';
                }else{ /* Verificando se o evento não foi cadastrado */
                    document.getElementById('retorno_evento').style.color = 'red';
                    document.getElementById('retorno_evento').innerHTML = 'Você já possui um evento com esse nome!<br>Que tal tentar outro?';
                }
            });
        }else{ /* Verificando se o nome está em branco */
            document.getElementById('retorno_evento').style.color = 'red';
            document.getElementById('retorno_evento').innerHTML = 'O nome não pode ficar em branco!';
        }
        exibir_eventos(); /* Atualizando a lista de eventos */
    });

    $("#btn_add_produto").click(function(){
        var nome_produto = $("#nome_produto").val();
        var id_evento = $("#evento_id").val();
        $("#nome_produto").val("");

        if (nome_produto != '') {
            $.post("funcoes/funcoes.php", {
                funcao: 'cadastrar_produto',
                produto_nome: nome_produto,
                evento_id: id_evento
            }, function(retorno){
                if(retorno == 1){
                    document.getElementById('retorno_produto').style.color = 'green';
                    document.getElementById('retorno_produto').innerHTML = 'Produto cadastrado!';
                }else{
                    document.getElementById('retorno_produto').style.color = 'red';
                    document.getElementById('retorno_produto').innerHTML = 'Você já possui um produto com esse nome cadastrado nesse evento!<br>Que tal tentar outro?';
                }
            });
        }else{
            document.getElementById('retorno_produto').style.color = 'red';
            document.getElementById('retorno_produto').innerHTML = 'O nome não pode ficar em branco!';
        }
        exibir_produtos();
    });

    $("#btn_add_pessoa").click(function(){
        var nome_pessoa = $("#nome_pessoa").val();
        var produto_id = $("#produto_id").val();
        $("#nome_pessoa").val("");

        if (nome_pessoa != '') {
            $.post("funcoes/funcoes.php", {
                funcao: 'cadastrar_pessoa',
                pessoa_nome: nome_pessoa,
                produto_id: produto_id
            }, function(retorno){
                if(retorno == 1){
                    document.getElementById('retorno_pessoa').style.color = 'green';
                    document.getElementById('retorno_pessoa').innerHTML = 'Pessoa cadastrada!';
                }else{
                    document.getElementById('retorno_pessoa').style.color = 'red';
                    document.getElementById('retorno_pessoa').innerHTML = 'Essa pessoa já está cadastrada nesse produto!<br>Que tal tentar outro?';
                }
            });
        }else{
            document.getElementById('retorno_pessoa').style.color = 'red';
            document.getElementById('retorno_pessoa').innerHTML = 'O nome não pode ficar em branco!';
        }
        exibir_pessoas();
    });

    carousel();

    $("#voltar_evento").click(function(){
        document.getElementById('meus_produtos').style.display = 'none';
        document.getElementById('meus_eventos').style.display = 'block';
        myIndex = 1;
    });

    $("#voltar_produto").click(function(){
        document.getElementById('produto_pessoas').style.display = 'none';
        document.getElementById('meus_produtos').style.display = 'block';
        myIndex = 1;
    });

});

exibir_eventos();
var myIndex = 0;

$(document).on('click', '.evento', function() {
    document.getElementById("evento_id").value = $('.evento_id',this).val();
    document.getElementById("titulo_evento").innerHTML = ('Produtos do evento: ' + $('.evento_nome',this).html());
    exibir_produtos();
    carousel();
});

$(document).on('click', '.produto', function() {
    document.getElementById("produto_id").value = $('.produto_id',this).val();
    document.getElementById("titulo_produto").innerHTML = ('Pessoas que vão consumir ' + $('.produto_nome',this).val());
    exibir_pessoas();
    myIndex = 2;
    carousel();
});

function exibir_produtos(){
    var evento_id = document.getElementById("evento_id").value;
    $.get( "funcoes/funcoes.php?funcao=obter_produtos&evento_id="+evento_id, function( data ) {
        var array = data.split('|');
        if(array.length == 1){
            $(".produtos").html("<hr>");
            $(".produtos").append("<h4>Você não adicionou nenhum produto a este evento!</h4>");
        }else{
            $(".produtos").html("");
        }
        array.forEach(function (produtos, index) {
            if (index != array.length - 1) {
                var produto = JSON.parse(produtos);
                $(".produtos").append(
                    "<hr><label class='produto'>"+
                    "<h4 class='produto_nome'>"+
                    produto.nome+
                    "<input type='hidden' class='produto_nome' value='"+produto.nome+"'>"+
                    "</h4>"+
                    "<i class='far fa-play fa-2x simbolo'></i><br>"+
                    "<input type='hidden' class='produto_id' value='"+produto.id+"'>"+
                    "</label>"
                    );
            }
        });
    });        
}

function exibir_eventos(){
    $.get( "funcoes/funcoes.php?funcao=obter_eventos", function( data ) {
        var array = data.split('|');
        if(array.length == 1){
            $(".eventos").html("<hr>");
            $(".eventos").append("<h4>Você ainda não possui nenhum evento!</h4>");
        }else{
            $(".eventos").html("");
        }
        array.forEach(function (eventos, index) {
            if (index != array.length - 1) {
                var evento = JSON.parse(eventos);
                $(".eventos").append(
                    "<hr><label class='evento'>"+
                    "<h4 class='evento_nome'>"+
                    evento.nome+
                    "</h4>"+
                    "<i class='far fa-play fa-2x simbolo'></i><br>"+
                    "<input type='hidden' class='evento_id' value='"+evento.id+"'>"+
                    "</label>"
                    );
            }
        });
    });
}

function exibir_pessoas(){
    var produto_id = document.getElementById("produto_id").value;
    $.get( "funcoes/funcoes.php?funcao=obter_pessoas&produto_id="+produto_id, function( data ) {
        var array = data.split('|');
        if(array.length == 1){
            $(".pessoas").html("<hr>");
            $(".pessoas").append("<h4>Você ainda não adicionou nenhuma pessoa nesse produto!</h4>");
            $(".pessoas").append("<hr>");
        }else{
            $(".pessoas").html("");
        }
        array.forEach(function (pessoas, index) {
            if (index != array.length - 1) {
                var pessoa = JSON.parse(pessoas);
                $(".pessoas").append(
                    "<hr><label class='pessoa'>"+
                    "<h4 class='pessoa_nome'>"+
                    pessoa.nome+
                    "<input type='hidden' class='pessoa_nome' value='"+pessoa.nome+"'>"+
                    "</h4>"+
                    "<i class='far fa-play fa-2x simbolo'></i><br>"+
                    "<input type='hidden' class='pessoa_id' value='"+pessoa.id+"'>"+
                    "</label>"
                    );
            }
        });
    });
}

function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
      x[i].style.display = "none";  
  }
  myIndex++;
  if (myIndex > x.length) {myIndex = 1}    
    x[myIndex-1].style.display = "block";           
}


