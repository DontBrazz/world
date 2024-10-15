function changePage(page) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'index2.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('pagina=' + encodeURIComponent(page));
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            //document.open();
            //document.write(xhr.responseText);
            //document.close();
            document.getElementById('content').innerHTML = xhr.responseText;
            console.log('pagina trocada');
        } else {
            console.error('Erro na solicitação:', xhr.statusText);
        }
    };
    xhr.onerror = function() {
        console.error('Erro na solicitação.');
    };
    xhr.send();
}