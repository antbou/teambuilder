<div class="container">
    <?php foreach ($teams as $team) :
        $i = 0;
    ?>
        <b> <?= $team->name; ?></b>

        <?= count($team->members()) ?>

        <br>
    <?php endforeach; ?>
</div>