function deleteQuestion(id) {
    const data = {
        idQuestion: id
    };

    $.ajax({
        url: '',
        type: 'POST',
        data: data,
        success: function(response) {
            setTimeout(function() {
                location.reload();
            },500);
        },
        error: function(xhr, status, error) {
            alert('Erro ao excluir a pergunta: ' + error);
        }
    });
}

function finalize() {
    var final = "final";
    const data = {
        final: final
    };

    $.ajax({
        url: '',
        type: 'POST',
        data: data,
        success: function(response) {
            console.log('sucess');
        },
        error: function(xhr, status, error) {
            alert('Erro ao finalizar ' + error);
        }
    });
}

function addQuestion() {
    var question = $('#question').val();
    var resposta1 = $('#resposta1').val();
    var resposta2 = $('#resposta2').val();
    var resposta3 = $('#resposta3').val();
    var respostaCorreta = $('#respostaCorreta').val();
    $.ajax({
        url: '',
        type: 'POST',
        data: {
            question: question,
            resposta1: resposta1,
            resposta2: resposta2,
            resposta3: resposta3,
            respostaCorreta: respostaCorreta,
        },
        success: function(response) {
            setTimeout(function() {
                location.reload();
            }, 1000);
        },
        error: function(xhr, status, error) {
            alert('Erro ao excluir a pergunta: ' + error);
        }
    });
}