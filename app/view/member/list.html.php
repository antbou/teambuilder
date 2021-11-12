<div class="container">
    <?php foreach ($members as $member) : ?>
        <?php if ($isModo) : ?>
            <a href="?controller=member&task=profile&id=<?= $member->id ?>"><b> <?= $member->name; ?></b></a>
        <?php else : ?>
            <b> <?= $member->name; ?></b>
        <?php endif; ?>

        <?php
        $teams = $member->teams();
        foreach ($teams as $team) :
        ?>
            <i><?= $team->name; ?></i>
            <?= (end($teams) !== $team) ? ', ' : '' ?>
        <?php endforeach; ?>
        <br>
    <?php endforeach; ?>
</div>