<?php
/**
 * array $arParams
 */

CJSCore::Init("jquery");

/** @var array $arResult */
$template = $arResult['TEMPLATE'];

$tabControl = new CAdminTabControl('parser', array(
    array(
        "DIV" => "tab1",
        "TAB" => "Парсер CSV",
        "TITLE" => "Парсер CSV",
    )
));

?>
<form action="" id="parser-form" name="parser" method="post" enctype="multipart/form-data">
<?php
$tabControl->Begin();
$tabControl->BeginNextTab();

require __DIR__ . "/{$template}.php";

$tabControl->EndTab();
$tabControl->Buttons();
?>
    <input type="submit"
           name="SUBMIT"
           value="Отправить"
           class="adm-btn-save" />
<?php
$tabControl->End();
?>
</form>
<?php
