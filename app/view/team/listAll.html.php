<div class="container">
    <?php foreach ($teams as $team) : ?>
        <a href='/?controller=team&task=show&id=<?= $team->id ?>'><b> <?= $team->name; ?></b></a>

        <?= count($team->members()) ?>

        <?= (isset($team->captain()->name)) ? $team->captain()->name : '' ?>

        <br>
    <?php endforeach; ?>
</div>