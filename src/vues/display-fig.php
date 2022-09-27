<?php

    //disposition de l'affichage des minis
    foreach($args['Fig'] as $figs): ?>
        <ul>
            <li><?= htmlspecialchars($figs->name) ?></li>
            <li> <img src="../public/uploads/<?= htmlspecialchars( $figs->picture) ?>" alt= "picture" class="picture"/></li>
            <li><?= htmlspecialchars($figs->content) ?></li>
        </ul>
<?php var_dump($figs->picture);?>
<?php endforeach ?>


<?php
//disposition de l'affichage des peintures liées a la figurine
    $paints = Fig::getFigPaints($figs->ID);

    foreach($paints as $paint) {
        ?>
       <div >
           <div  class="displayPaint" >
                <div class="paint" ><?= $paint->color_picture ?> <?= $paint->color_name ?></div>

           </div>
       </div>
        <?php
    }
    ?>

<a href="https://thomascavelier.sites.3wa.io/GEARS_FINAL/update/<?= $figs->ID ?>">Update  <?= htmlspecialchars($figs->name) ?> </a>
</br>
<a href='https://thomascavelier.sites.3wa.io/GEARS_FINAL'>Back to selection</a>
</br>

