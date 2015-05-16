<?php
CAdminMessage::ShowNote("Загрузка файла завершена");
?>
<input type="hidden" name="ACTION" value="PARSE"/>
<input type="hidden" name="FILE_ID" value="<?= $arResult['FILE_ID']?>"/>

<script>
    setTimeout(function () {
        $('#parser-form').find('[type="submit"]').trigger("click");
    }, 1000);
</script>
<?php
