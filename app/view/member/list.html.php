<div class="container">
    <?php foreach ($members as $member) : ?>
        <b> <?= $member->name; ?></b>
        <?php foreach ($member->teams() as $team) : ?>
            <i><?= $team->name; ?></i>

            <?= (end($member->teams())->id !== $team->id) ? ', ' : '' ?>
        <?php endforeach; ?>
        <br>
    <?php endforeach; ?>
</div>