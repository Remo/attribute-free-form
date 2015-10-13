<?php defined('C5_EXECUTE') or die('Access Denied.') ?>
<fieldset>
    <legend><?= t('Edit Form') ?></legend>
    <div>
        <div id="edit-html-value"><?= h($formCode) ?></div>
        <textarea style="display: none" id="edit-html-value-textarea" name="formCode"></textarea>
    </div>

    <legend><?= t('View Screen') ?></legend>
    <div>
        <div id="view-html-value"><?= h($viewCode) ?></div>
        <textarea style="display: none" id="view-html-value-textarea" name="viewCode"></textarea>
    </div>
</fieldset>

<style type="text/css">
    #edit-html-value, #view-html-value {
        width: 100%;
        border: 1px solid #eee;
        height: 490px;
    }
</style>

<script type="text/javascript">
    $(function () {
        var editors = ['edit-html-value', 'view-html-value'];
        for (var i in editors) {
            var editorName = editors[i];
            initEditor(editorName);
        }
    });

    function initEditor(editorName)
    {
        var editor = ace.edit(editorName);
        editor.setTheme("ace/theme/eclipse");
        editor.getSession().setMode("ace/mode/html");
        refreshTextarea(editorName + "-textarea", editor.getValue());
        editor.getSession().on('change', function () {
            refreshTextarea(editorName + "-textarea", editor.getValue());
        });
    }

    function refreshTextarea(id, contents) {
        $('#' + id).val(contents);
    }
</script>
