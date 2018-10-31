<?
// вместо хедера
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

//print_r($_POST);
Cmodule::IncludeModule('iblock');
switch($_POST['stars']){
    case 1: $stars = 1007; break;
    case 2: $stars = 1008; break;
    case 3: $stars = 1009; break;
    case 4: $stars = 1010; break;
    case 5: $stars = 1011; break;
}

    $el = new CIBlockElement;

   $fields = array(
            'IBLOCK_ID' => 42,
            'NAME' => $_POST['rand'],
            'ACTIVE' => "Y",
            'CREATED_BY' => '1',
            'MODIFIED_BY' => '1',
            'DATE_CREATE' => $arFields['DATE_CREATE'],
      );

      if ($PRODUCT_ID = $el->Add($fields)) {
         echo 'Добавлен элемент, ID: ' . $PRODUCT_ID;
CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "text", array("VALUE"=>array("TEXT"=>htmlspecialchars($_POST['comment']), "TYPE"=>"text")));
CIBlockElement::SetPropertyValues($PRODUCT_ID,42, date("m.d.Y"), "date");
CIBlockElement::SetPropertyValues($PRODUCT_ID,42, $stars, "stars");
CIBlockElement::SetPropertyValues($PRODUCT_ID,42, 1006, "public");
CIBlockElement::SetPropertyValues($PRODUCT_ID,42, $_POST["name"], "name");
CIBlockElement::SetPropertyValues($PRODUCT_ID,42, $_POST["mail"], "mail");
   } else {
      echo "Error[" . $PRODUCT_ID . "]: " . $el->LAST_ERROR . '<br />';
   }
// вместо футера
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');
?>
