$(function(){
    $("#cadastrar").click(function(){
        var email = $("#email").val();
        var senha = $("#password").val();

        if(email != '' && senha != ''){
            $.post("funcoes/funcoes.php", {
                funcao: 'cadastro',
                email: email,
                senha: senha
            }, function(retorno){
                if(retorno == 1){
                    document.getElementById('retorno').style.color = 'green';
                    document.getElementById('retorno').innerHTML = 'Usuário cadastrado!<br>';
                }else{
                    document.getElementById('retorno').style.color = 'red';
                    document.getElementById('retorno').innerHTML = 'Usuário não disponível!';
                }
            });
        }else{
            document.getElementById('retorno').innerHTML = ('Preencha todos os campos!');
        }
    });

    $("#login").click(function(){
        var email = $("#email_login").val();
        var senha = $("#password_login").val();

        if(email != '' && senha != ''){
            $.post("funcoes/funcoes.php", {
                funcao: 'login',
                email: email,
                senha: senha
            }, function(retorno){
                if(retorno == 1){
                    window.location = 'index.php';
                }else{
                    document.getElementById('retorno').innerHTML = retorno;
                }
            });
        }else{
            document.getElementById('retorno').innerHTML = ('Preencha todos os campos!');
        }
    });

    $("#email").keyup(function(){
        var email = $("#email").val();
        $("#email").removeClass();
        if (email.length < 3) {
            $("#email").addClass('nao_valido');
        }else{
            $.post("funcoes/funcoes.php", {
                funcao: 'verificar_usuario',
                email: email,
            }, function(retorno){
                if(retorno == 1){
                    $("#email").addClass('valido');
                }else{
                    $("#email").addClass('nao_valido');
                }
            });
        }
    });

    $("#password").keyup(function(){
        var password = $("#password").val();
        $("#password").removeClass();
        if (password.length < 6) {
            $("#password").addClass('nao_valido');
        }else{
            $("#password").addClass('valido');
        }
    });
});
