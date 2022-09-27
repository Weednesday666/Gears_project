pick a mini and see what you need to paint it :
<!--affichage de la liste des mini -->
<ul>
    <?php foreach($args['figs'] as $fig): ?>
    <li>
    <a href="display/<?= $fig->ID ?>"><?= $fig->name ?></a>
    <button><a href="delete/<?= $fig->ID ?>"> delete</a></button>
    </li>
    <?php endforeach ?>
</ul>


