$(document).ready(function() {

    $('#rebase-after').change(function(){
        $('#rebase-url-label').text("Inserire l'URL precedente del sito (l'URL utilizzato prima dello spostamento)");
        $('#rebase-url').val('');
    });

    $('#rebase-before').change(function(){
        $('#rebase-url-label').text("Inserire il nuovo URL del sito (l'URL effettivo dopo lo spostamento)");
        $('#rebase-url').val('');
    });

    $('#execute-filter-html').click(function(){
        $.ajax({
            type: 'GET',
            url: window.vbcknd.base_url + 'ajax/admin/sysdiag/filter_html',
            success: diagDone,
            error: diagFailed
        });
       $('#diag-run-modal').modal();
    });

    $('#execute-rebase').click(function(){
        var data = {};
        data.url = $('#rebase-url').val();
        data.mode = $('#rebase-before').prop('checked') ? 'before' : 'after';
        if(data.url=='')
        {
            alert('Inserire un URL valido per spostare il sito');
            return;
        }
        $.ajax({
            type: 'POST',
            data: data,
            url: window.vbcknd.base_url + 'ajax/admin/sysdiag/rebase_site',
            success: diagDone,
            error: diagFailed
        });
        $('#diag-run-modal').modal();
    });

    function diagDone(data){
        $('#diag-run-modal').modal('hide');
        $('#diag-results-box').html(data);
        $('#diag-results-modal').modal();
    }

    function diagFailed(jqXHR){
        var html = '<p>Il server ha inviato la risposta <code>'+jqXHR.status+' '+jqXHR.statusText+'</code>. I dati inviati dal server sono:</p>'+'<div class="well">'+jqXHR.responseText+'</div>';
        $('#diag-error-box').collapse('hide').html(html);
        $('#diag-run-modal').modal('hide');
        $('#diag-error-modal').modal();
    }
});