<?php foreach ($members as $member) : ?>
    <?= $member->name; ?>
    <?php foreach ($member->teams() as $team) : ?>
        <?= $team->name; ?>
    <?php endforeach; ?>
    <br>
<?php endforeach; ?>