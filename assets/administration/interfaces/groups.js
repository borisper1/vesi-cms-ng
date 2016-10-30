$(document).ready(function() {
    var CurrentItem;

    var mode = $('#page-mode').text();
    var is_ldap_enabled = $('#ldapgrp-editor-gui').length;

    if (mode == 'list') {
        $('.vcms-select-group').change(function () {
            if ($('.vcms-select-group:checked').length > 0) {
                $('#group-actions').removeClass('hidden');
            } else {
                $('#group-actions').addClass('hidden');
            }
        });
    }

    if (is_ldap_enabled) {
        var temp_builtin_groups_dom;

        $('#ldapgrp-gui-add').click(function () {
            $('#new-ldap-group-modal').modal();
        });

        $('#hide-builtin-ldap-groups').change(function () {
            var ldap_select = $('#i-ldap-group');
            if ($(this).prop('checked')) {
                temp_builtin_groups_dom = "";
                ldap_select.children('option').each(function () {
                    if ($(this).text().indexOf('CN=Builtin') !== -1) {
                        temp_builtin_groups_dom += $(this)[0].outerHTML;
                        $(this).remove();
                    }
                });
                ldap_select.selectpicker('refresh');
            } else {
                ldap_select.append(temp_builtin_groups_dom);
                ldap_select.selectpicker('refresh');
            }
        });

        $('#new-ldap-group-modal-confirm').click(function () {
            var $item = $('#ldap-group-template').children().clone();
            $item.find('.ldap-element').text($('#i-ldap-group').val());
            $('#gui-ldap-editor-area').append($item[0].outerHTML + '&nbsp;');
        });

        $('#gui-ldap-editor-area').on('click', '.delete-ldap-element', function () {
            $(this).closest('.ldap-group-element').remove();
        });

        function generate_ldap_json() {
            var ldap_groups = {};
            ldap_groups.ldap_groups = [];
            $('#gui-ldap-editor-area').find('.ldap-group-element').each(function () {
                ldap_groups.ldap_groups.push($(this).find('.ldap-element').text());
            });
            return JSON.stringify(ldap_groups);
        }

    }

    //CONTENT FILTER CODE
    if (mode == 'edit_admin') {
        //CONTENT FILTER CONTROL CODE ----------------------------------------------------------------------------------
        //Initialization code
        if ($('#onload_cfilter_status').text() === 'false') {
            $('#filter-whitelist, #filter-blacklist, #cfilter-gui-add-container, #cfilter-gui-add-page, #cfilter-code-expression').prop('disabled', true);
            $('#cfilter-edit-gui, #cfilter-edit-code').prop('disabled', true).closest('.btn').addClass('disabled');
        }

        if ($('#onload_cfilter_mode').text() === 'blacklist') {
            $('#filter-blacklist').prop('checked', true);
        } else {
            $('#filter-whitelist').prop('checked', true);
        }
        cfilter_CSV_to_GUI($('#cfilter-code-expression').val());
        //END Initialization code

        $('#enable-content-filter').change(function () {
            if ($(this).prop('checked')) {
                $('#filter-whitelist, #filter-blacklist, #cfilter-gui-add-container, #cfilter-gui-add-page, #cfilter-code-expression').prop('disabled', false);
                $('#cfilter-edit-gui, #cfilter-edit-code').prop('disabled', false).closest('.btn').removeClass('disabled');
            } else {
                $('#filter-whitelist, #filter-blacklist, #cfilter-gui-add-container, #cfilter-gui-add-page, #cfilter-code-expression').prop('disabled', true);
                $('#cfilter-edit-gui, #cfilter-edit-code').prop('disabled', true).closest('.btn').addClass('disabled');
            }
        });

        $('#cfilter-edit-gui').change(function () {
            if ($('#cfilter-code-expression').prop('disabled') === false) {
                $('#cfilter-editor-gui').removeClass('hidden');
                $('#cfilter-editor-code').addClass('hidden');
                cfilter_CSV_to_GUI($('#cfilter-code-expression').val());

            }
        });

        $('#cfilter-edit-code').change(function () {
            if ($('#cfilter-code-expression').prop('disabled') === false) {
                $('#cfilter-editor-gui').addClass('hidden');
                $('#cfilter-editor-code').removeClass('hidden');
                $('#cfilter-code-expression').text(cfilter_GUI_to_CSV());
            }
        });

        $('#gui-editor-area').on('click', '.delete-filter-element', function () {
            if ($('#cfilter-code-expression').prop('disabled') === false) {
                $(this).closest('.filter-element').remove();
            }
        });

        $('#cfilter-gui-add-container').click(function () {
            $('#new-content-filter-modal').modal();
            $('#i-container-filter-container').val('');
        });

        $('#new-container-filter-modal-confirm').click(function () {
            var $item = $('#container-filter-template').children().clone();
            $item.find('.container-name').text($('#i-container-filter-container').val());
            $("#gui-editor-area").append($item[0].outerHTML + '&nbsp;');
        });

        $('#cfilter-gui-add-page').click(function () {
            $('#new-page-filter-modal').modal();
            $('#i-page-filter-container').val('');
            $('#i-page-filter-page').val('');
            $('#cscope-pages').empty();
        });

        $('#new-page-filter-modal-confirm').click(function () {
            var $item = $('#page-filter-template').children().clone();
            $item.find('.page-container').text($('#i-page-filter-container').val());
            $item.find('.page-name').text($('#i-page-filter-page').val());
            $("#gui-editor-area").append($item[0].outerHTML + '&nbsp;');
        });

        $('#i-page-filter-container').focusout(function () {
            $.post(window.vbcknd.base_url + 'ajax/admin/groups/get_pages', 'container=' + $(this).val(), LoadCurrentScopePages);
        });

        function LoadCurrentScopePages(data) {
            var cscope_pages = $('#cscope-pages');
            cscope_pages.empty();
            if (!data.startsWith('failed - ')) {
                var pages = data.split(',');
                $.each(pages, function () {
                    cscope_pages.append('<option value="' + this + '">');
                });
            } else {
                console.log(data + ' - loading page autocomplete datalist')
            }
        }


        function cfilter_CSV_to_GUI(csv) {
            var allowed_contents = csv.replace(/\r?\n|\r/g, "").split(",");
            $("#gui-editor-area").empty();
            if (csv !== '') {
                allowed_contents.forEach(function (entry) {
                    if (entry.indexOf('::') === -1) {
                        var $item = $('#container-filter-template').children().clone();
                        $item.find('.container-name').text(entry);
                        $("#gui-editor-area").append($item[0].outerHTML + '&nbsp;');
                    } else {
                        var strings = entry.split('::');
                        var $item = $('#page-filter-template').children().clone();
                        $item.find('.page-container').text(strings[0]);
                        $item.find('.page-name').text(strings[1]);
                        $("#gui-editor-area").append($item[0].outerHTML + '&nbsp;');
                    }
                });
            }
        }

        function cfilter_GUI_to_CSV() {
            var array_prototype = [];
            $('#gui-editor-area').find('.filter-element').each(function () {
                if ($(this).hasClass('filter-container')) {
                    array_prototype.push($(this).find('.container-name').text());
                } else if ($(this).hasClass('filter-page')) {
                    array_prototype.push($(this).find('.page-container').text() + '::' + $(this).find('.page-name').text());
                }
            });
            return array_prototype.join(',');
        }

        function generate_cfilter_obj() {
            var json = {};
            json.use_content_filter = document.getElementById('enable-content-filter').checked;
            if (document.getElementById('filter-blacklist').checked) {
                json.content_filter_mode = 'blacklist';
            } else {
                json.content_filter_mode = 'whitelist';
            }
            if ($('#cfilter-edit-gui').prop('checked')) {
                json.content_filter_directives = cfilter_GUI_to_CSV().split(",");
            } else {
                json.content_filter_directives = $("#cfilter-expression").val().replace(/\r?\n|\r/g, "").split(",");
            }
            return json;
        }

        //END CONTENT FILTER CONTROL CODE ------------------------------------------------------------------------------
    }

    if (mode.indexOf('edit') >= 0) {
        var is_new_unsaved = $('#is-new').text() === 'true';
        var allowed_permissions = $('#onload_allowed_permissions').text().split(",");
        allowed_permissions.forEach(function (entry) {
            $(".select-permission-item[value='" + entry + "']").prop("checked", true);
        });

        $('#refresh').click(function () {
            window.location.reload(true);
        });

        $('#close-edit').click(function () {
            window.location.href = window.vbcknd.base_url + 'admin/groups';
        });

        $('#save-edit').click(function () {
            if (is_new_unsaved) {
                ClearAllValidationErrors();
                $('#new-group-modal').modal();
            } else {
                DoSave();
            }
        });

        function DoSave() {
            var json = {};
            var data = {};
            if (mode == 'edit_admin') {
                json.allowed_interfaces = [];
                $('.select-permission-item:checked').each(function () {
                    json.allowed_interfaces.push($(this).val());
                });
                cfilter_obj = generate_cfilter_obj();
                json.use_content_filter = cfilter_obj.use_content_filter;
                json.content_filter_mode = cfilter_obj.content_filter_mode;
                json.content_filter_directives = cfilter_obj.content_filter_directives;
                data.type = 'admin';
            } else if (mode == 'edit_frontend') {
                json.allowed_permissions = [];
                $('.select-permission-item:checked').each(function () {
                    json.allowed_permissions.push($(this).val());
                });
                data.type = 'frontend';
            }
            data.name = $('#group-name').text();
            data.description = encodeURIComponent($('#group-description').text());
            data.code = encodeURIComponent(JSON.stringify(json, null, '\t'));
            if (is_ldap_enabled) {
                data.ldap_groups = encodeURIComponent(generate_ldap_json());
            } else {
                data.ldap_groups = encodeURIComponent('{}');
            }
            $('.alert').addClass('hidden');
            $('#spinner').removeClass('hidden');
            $.post(window.vbcknd.base_url + 'ajax/admin/groups/save', data, SaveEditDone);
        }

        function SaveEditDone(data) {
            $('.alert').addClass('hidden');
            if (data == "success") {
                if (is_new_unsaved) {
                    var name = $('#group-name').text();
                    history.replaceState({}, '', window.vbcknd.base_url + 'admin/groups/edit/' + name);
                    is_new_unsaved = false;
                }
                $('#success-alert').removeClass('hidden')
            } else {
                $('#error-msg').html("Si è verificato un errore durante il salvataggio del gruppo. I dati inseriti potrebbero essere non validi" +
                    " (errore: " + data.replace(/(<([^>]+)>)/ig, "") + ")");
                $('#error-alert').removeClass('hidden');
            }
        }

    }

});