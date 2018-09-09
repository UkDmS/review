<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Отзывы");
?>
	<h1><?$APPLICATION->ShowTitle(false)?></h1>

<?php
/* 1.09 */
?>
<? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/fontawesome-all.css"); ?>
<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.validate.js");?>
<div style="min-height: 500px;">
<div class="col-left col-xs-12 col-md-6">
<?
    $IBLOCK_ID = 42;
    $arSelect = Array("ID","NAME");
    $arFilter = Array(
        "IBLOCK_ID"     =>  $IBLOCK_ID,
        "ACTIVE_DATE"   =>  "Y",
        "ACTIVE"        =>  "Y",
        "PROPERTY_PUBLIC"        =>  1005
    );
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
    $i = 0;
    while($ob = $res->GetNextElement()){
        $arFields = $ob->GetFields();
        $db_props = CIBlockElement::GetProperty($IBLOCK_ID , $arFields['ID'], "sort", "asc", array());
        while($ar_props = $db_props->Fetch()) {
            if(isset($ar_props['VALUE']['TEXT'])) {
                $arr[$i][$ar_props['CODE']]=$ar_props['VALUE']['TEXT'];
            }
            else {
                if($ar_props['CODE']=='stars' || $ar_props['CODE']=='public') {
                    $arr[$i][$ar_props['CODE']]=$ar_props['VALUE_ENUM'];
                }
                else $arr[$i][$ar_props['CODE']]=$ar_props['VALUE'];
            }
        }
        $i++;
    }
    $arr = array_reverse($arr);

foreach($arr as $item) {
?>
<div class="review-item">
    <div>
         <div class="review-left"><?=$item["name"] ?></div>
         <div class="review-right">
            <div class="raiting">
            	<div id="star">
                <?
                    for($i=1;$i<=5;$i++) {
                        if($i<=$item["stars"]) {
                ?>
                    	    <label class="fill">
                    	    	<i class="fas fa-star"></i>
                    	    </label>
                <?php
                        }
                        else {
                ?>
                    	    <label>
                    	    	<i class="fas fa-star"></i>
                    	    </label>
                <?php
                        }
                    }
                ?>
	</div>
            </div>
            <div class="review-date"><?=$item["date"] ?></div>
         </div>
    </div>
    <div class="clear"></div>
    <div class="review-text"><?=$item["text"] ?></div>
</div>
<?php
}
?>
<style>

.raiting label.fill{
  color:#ec9801;
}
.raiting label{
  color:#ccc;
}





.review-item {
  border: 2px solid #e6e6e6;
    border-bottom: 2px solid #b9babc;
    padding: 20px;
    margin: 0 20px 20px 0;
}
.review-left {
  font-weight: bold;
  float: left;
}
.review-right {
  font-weight: bold;
  float: right;
}
 .review-text {
   padding: 10px;
 }

</style>
</div>
<div class="col-right col-xs-12 col-md-6">
<?
function generatePassword($length = 8){
    $chars = 'abcdefghijklmnoprstuywxzqABCDEFGHIJKLMNOPRSTUYWXZQ123456789';
    $numChars = strlen($chars);
    $string = '';
    for ($i = 0; $i < $length; $i++) {
        $string .= substr($chars, rand(1, $numChars) - 1, 1);
    }
    return $string;
}
$id = generatePassword(12);
?>
<p class="reviews_title">Оставить отзыв:</p>
<form action="" class="form-review text-about" method="post">
    <div class="form-group"><p>Так Вы поможете пользователям определиться с выбором товара и стать нам немного лучше.</p>
   <p>Отзыв будет опубликован после проверки модератором. Ваш e-mail не будет размещен в отзыве, он необходим для возможности ответить Вам нашими менеджерами.</p>
    </div>
    <div id="form-body">
    <div class="form-group validate has-success">
    	<input type="text" class="form-control" name="name_reviews" id="name_reviews" placeholder="Ваше имя*">
        <div class="error-box"></div>
    </div>
    <div class="form-group validate has-error">
    	<input type="text" class="form-control" name="email_reviews" id="email_reviews" placeholder="Ваш e-mail*">
        <div class="error-box"></div>
    </div>
    <div class="form-group">
    	<textarea placeholder="Ваш отзыв*" class="form-control" id="comment_reviews" name="comment_reviews" cols="30"></textarea>
        <div class="error-box"></div>
    </div>
    <div class="form-group reviews_stars_group">
    Ваша оценка:
    <div class="review_stars_wrap">
	<div id="review_stars">
	    <input id="star-4" type="radio" name="stars" data-review="5"/>
	    <label title="Отлично" for="star-4">
	    	<i class="fas fa-star"></i>
	    </label>
	    <input id="star-3" type="radio" name="stars" data-review="4"/>
	    <label title="Хорошо" for="star-3">
	    	<i class="fas fa-star"></i>
	    </label>
	    <input id="star-2" type="radio" name="stars"  data-review="3"/>
	    <label title="Нормально" for="star-2">
	    	<i class="fas fa-star"></i>
	    </label>
	    <input id="star-1" type="radio" name="stars" data-review="2"/>
	    <label title="Плохо" for="star-1">
	    	<i class="fas fa-star"></i>
	    </label>
	    <input id="star-0" type="radio" name="stars" data-review="1"/>
	    <label title="Ужасно" for="star-0">
	    	<i class="fas fa-star"></i>
	    </label>
	</div>
    </div>
    </div>
    <div id="required_field"><span>*</span> - Поля, отмеченные звездочкой, обязательны для заполнения</div>
    <input type="hidden" name="rand" class="rand" value='<? echo $id ?>'/>
    <div>
    	<button type="submit" class="btn btn-purple" id="button_form" disabled="disabled">Опубликовать отзыв</button>
    </div>
    </div>
</form>
</div>
</div>


<style>
.text-about p {
    font-size: 12px;
    text-align: justify;
    text-indent: 2em;
    margin-bottom: 0;
}
.text-about p:last-child {
    margin-bottom: 10px;
}

.col-right {
  border: 2px solid #e6e6e6;
    border-bottom: 2px solid #b9babc;
    padding: 20px;

    margin: 0 auto;
    float: right;
}
.col-left {
  float: left;

}
.reviews_title {
font-weight: bold;
    font-size: 20px;
}

.reviews_stars_group {
    display: flex;
    flex-direction: row;
}

.review_stars_wrap{
    overflow: hidden;
    margin-left: 10px;
}
#review_stars {
  overflow: hidden;
  position: relative;
  float: left;
}
#review_stars input {
  opacity: 0;
  position: absolute;
  top: 0;
  z-index: 0;
}
#review_stars input ~ label i{
  color:#ccc;
}
#review_stars input:checked ~ label i{
  color: #ec9801;
}
#review_stars label {
  float: right;
  cursor: pointer;
  position: relative;
  z-index: 1;
}
#review_stars label:hover i, #review_stars label:hover ~ label i{
  color: #ec9801;
}
#required_field {
    margin-top: 10px;
        display: block;
}
#required_field span{
    color: red;
}
#button_form {
width: 250px;
    margin: 10px 0;
    background-color: #d41052;
    color: #fff;
    padding: 8px;
    box-sizing: content-box;
}
button#button_form[disabled] {
  background-color: #e6aec1;
}
.error-box {
      color: red;
    padding-left: 5px;
    font-size: 12px;
    padding-bottom: 5px;
}
.success-review{
    text-align: center;
    padding: 15px;
    color: green;
    font-size: 18px;
}

</style>
<script>
$(document).ready(function(){
    $("#review_stars input").on("click", function() {
        //alert( this.getAttribute('data-review'));
    });

    $('input#name_reviews, input#email_reviews, textarea#comment_reviews').unbind().blur(function(){
        var id = $(this).attr('id'),
            val = $(this).val(),
            rv_name = /^[a-zA-Zа-яА-Я\s]+$/,
            rv_email = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
        switch(id) {
            case 'name_reviews':
                if(val.length > 2 && val != '' && rv_name.test(val)) {
                    $(this).addClass('not_error');
                    $(this).css('border','green solid 2px');
                    $(this).next('.error-box').empty();
                }
                else {
                    $(this).removeClass('not_error').addClass('error');
                    $(this).css('border','red solid 2px');
                    $(this).next('.error-box').html('Длина имени должна составлять не менее 2 символов,<br> поле должно содержать только русские или латинские буквы');
                }
                break;

            case 'email_reviews':
                if(val != '' && rv_email.test(val)) {
                    $(this).addClass('not_error');
                    $(this).css('border','green solid 2px');
                    $(this).next('.error-box').empty();
                }
                else {
                    $(this).removeClass('not_error').addClass('error');
                    $(this).css('border','red solid 2px');
                    $(this).next('.error-box').html('Поле должно содержать правильный email-адрес');
                }
                break;

            case 'comment_reviews':
                if(val != '' && val.length < 5000) {
                    $(this).addClass('not_error');
                    $(this).css('border','green solid 2px');
                    $(this).next('.error-box').empty();
                }
                else {
                    $(this).removeClass('not_error').addClass('error');
                    $(this).css('border','red solid 2px');
                    $(this).next('.error-box').html('Поле обязательно для заполнения');
                }
                break;

        } // end switch(...)
         if($('.not_error').length == 3) {
            $("#button_form").removeProp("disabled");
            }
    }); // end blur()




    $('form.form-review').submit(function(e) {
        e.preventDefault();
            $.ajax({
                url: '../send_review.php',
                type: 'post',
                data: "name="+$("#name_reviews").val()+"&mail="+$("#email_reviews").val()+"&comment="+$("#comment_reviews").val()+"&stars="+$("#review_stars input").attr('data-review')+"&rand="+jQuery(".rand").val(),

                beforeSend: function(xhr, textStatus){
                    $('.button_form').attr('disabled','disabled');
                },

                success: function(response){
                   $("#form-body").empty();
                    $("#form-body").html("<div class='success-review'>Ваш отзыв отправлен</div>");
                }
            }); // end ajax({...})

    }); // end submit()


}); // end script
</script>
<div class="clear"></div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>
