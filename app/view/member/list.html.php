<div class="container">
    <?php foreach ($members as $member) :
        $i = 0;
    ?>
        <b> <?= $member->name; ?></b>
        <?php foreach ($member->teams() as $team) :
            $i++;
        ?>
            <i><?= $team->name; ?></i>

            <?php if ($i != count($member->teams())) : ?>
                ,
            <?php endif; ?>
        <?php endforeach; ?>
        <br>
    <?php endforeach; ?>
</div>