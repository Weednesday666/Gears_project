<!--formulaire de creation de la figurine -->

<!--creation du nom et du lore-->

declaim the name , picture(2mb max ) and story of your mini
<form method="post" action ="" enctype="multipart/form-data">
    <input type="text" name="name" value="" required="required" placeholder="mini name here (required) "/>
    <input type="file" name="picture" action"" accept="image/png, image/jpeg, image/jpg"/>

    <textarea name="content" value=""  rows='5' cols= '40'  placeholder ="your fluff here (can be declaim later ) "></textarea>
    <input type="submit" name="button" value="Submit"/>
    <br>



    <!--section selection de la peinture-->
    Now , select the paint you'll need to apply to your mini : <br>
    <?php
    $paints = Paint::getPaints();
    ?>

    <?php

    foreach($paints as $paint) {
        ?>
        <div class="check">
            <input type="checkbox" name="paintChecker[]" value="<?= $paint->ID ?>"/>
                <label  for="paint" >
                    <div class="paint"><?= $paint->color_picture ?> <?= $paint->color_name ?>
                    </div>
                </label>
        </div>
        <br>
        <?php
    }
    ?>

</form>



<!--SET YOUR FIELD PICTURE IN FILE TYPE AND MAKE IT WORK !!!! -->