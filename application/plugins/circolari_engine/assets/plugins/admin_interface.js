$(document).ready(function () {
    var CurrentItem;
    if ($('#is-new').length > 0) {
        var is_new_unsaved = $('#is-new').text() === 'true';
        // We are in editing mode, try to start CKEditor
        CKEDITOR.config.baseHref = window.vbcknd.base_url;
        CKEDITOR.config.contentsCss = [
            window.vbcknd.base_url + 'assets/third_party/bootstrap/css/bootstrap-custom.min.css',
            window.vbcknd.base_url + 'assets/third_party/fontawesome/css/font-awesome.min.css',
            window.vbcknd.base_url + 'assets/third_party/ckeditor/contents.css'];
        //Allow empty span tags for Font Awesome icons!
        CKEDITOR.dtd.$removeEmpty['span'] = false;
        CKEDITOR.replace('gui_editor', {
            height: '250px',
            on: {
                instanceReady: function () {
                    this.dataProcessor.htmlFilter.addRules({
                        elements: {
                            img: function (el) {
                                el.addClass('img-responsive');
                            }
                        }
                    });
                }
            }
        });
        $('#input-type').selectpicker('val', $('#type-hidden').text());

        $('#insert-2-columns').click(function () {
            CKEDITOR.instances.gui_editor.insertHtml('<div class="row"><div class="col-md-6"><p>Colonna 1</p></div><div class="col-md-6"><p>Colonna 2</p></div></div>');
        });

        $('#insert-3-columns').click(function () {
            CKEDITOR.instances.gui_editor.insertHtml('<div class="row"><div class="col-md-4"><p>Colonna 1</p></div><div class="col-md-4"><p>Colonna 2</p></div><div class="col-md-4"><p>Colonna 3</p></div></div>');
        });

        $('.export-document').click(function () {
            window.vbcknd.services.file_conversion.export_from_text(CKEDITOR.instances.gui_editor.getData(), 'html', $(this).data('format'), $('#f-id').text());
        });

        $('.import-document').click(function () {
            window.vbcknd.services.file_conversion.import_to_html($(this).data('format'), FileImportCallback);
        });

        function FileImportCallback(html) {
            CKEDITOR.instances.gui_editor.insertHtml(html);
        }

        $('#close-edit').click(function () {
            window.location.href = window.vbcknd.base_url + 'admin/circolari_engine/list_cats/' + $('#f-category').text();
        });

        function getData(content) {
            var data = {};
            data.id = $('#f-id').text();
            data.category = $('#f-category').text();
            data.title = encodeURIComponent($('#i-title').val());
            data.number = $('#i-number').val();
            data.suffix = encodeURIComponent($('#i-suffix').val());
            data.content = encodeURIComponent(content);
            return data;
        }

        $('#save-circolare').click(function () {
            ExecuteSave(CKEDITOR.instances.gui_editor.getData());
        });

        $('#edit-code').click(function () {
            window.vbcknd.start_code_editor('html', CKEDITOR.instances.gui_editor.getData(), ExecuteSave);
        });

        function ExecuteSave(html) {
            $('.alert').addClass('hidden');
            $('#spinner').removeClass('hidden');
            $.post(window.vbcknd.base_url + 'ajax/admin/circolari_engine/save', getData(html), SaveEditDone);
        }

        function SaveEditDone(data) {
            $('.alert').addClass('hidden');
            if (data == "success") {
                if (is_new_unsaved) {
                    var id = $('#f-id').text();
                    history.replaceState({}, '', window.vbcknd.base_url + 'admin/circolari_engine/edit/' + id);
                    is_new_unsaved = false;
                }
                $('#success-alert').removeClass('hidden')
            } else {
                $('#error-msg').html("Si è verificato un errore durante il salvataggio della circolare. I dati inseriti potrebbero essere non validi" +
                    " (errore: " + data.replace(/(<([^>]+)>)/ig, "") + ")");
                $('#error-alert').removeClass('hidden');
            }
        }
    }

    $('.close').click(function () {
        $(this).closest('.alert-dismissible').addClass('hidden');
    });

    $('#go-back-index').click(function () {
        window.location.href = window.vbcknd.base_url + 'admin/circolari_engine'
    });

    $('#refresh').click(function () {
        window.location.reload(true);
    });

    $('#new-circolare-flist').click(function () {
        window.location.href = window.vbcknd.base_url + 'admin/circolari_engine/new_circolare/' + $('#f-category').text();
    });

    $('.delete-article').click(function () {
        CurrentItem = $(this).closest('tr');
        $('#delete-modal').modal();
    });

    $('#delete-modal-confirm').click(function () {
        $('.alert').addClass('hidden');
        $('#circolare-deletion-spinner').removeClass('hidden');
        $.post(window.vbcknd.base_url + 'ajax/admin/circolari_engine/delete_article', 'id=' + CurrentItem.find('.f-id').text(), DeleteCircolare);
    });

    $('.delete-category').click(function () {
        CurrentItem = $(this).closest('tr');
        $('#delete-cat-modal').modal();
    });

    $('#delete-cat-modal-confirm').click(function () {
        $('.alert').addClass('hidden');
        $('#circolare-deletion-spinner').removeClass('hidden');
        $.post(window.vbcknd.base_url + 'ajax/admin/circolari_engine/delete_category', 'name=' + CurrentItem.find('.f-name').text(), DeleteCircolare);
    });

    function DeleteCircolare(data) {
        $('.alert').addClass('hidden');
        if (data === 'success') {
            CurrentItem.remove();
            $('#circolare-deletion-success').removeClass('hidden');
        } else {
            $('#circolare-deletion-error').removeClass('hidden');
        }
    }

    $('#new-circolare-fcat').click(function () {
        $('#new-circolare-modal').modal();
    });

    $('#new-circolare-modal-confirm').click(function () {
        window.location.href = window.vbcknd.base_url + 'admin/circolari_engine/new_circolare/' + $('#i-category').val();
    });


});