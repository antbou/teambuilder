<div class="container">
    <h2>Liste des modo</h2>
    <?php foreach ($modo as $member) : ?>
        <?= $member->name; ?>

        <?php if (end($modo) !== $member) : ?>
            ,
        <?php endif ?>
    <?php endforeach; ?>
</div>