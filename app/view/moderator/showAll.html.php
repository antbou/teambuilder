<div class="container">
    <h2>Liste des modo</h2>
    <?php foreach ($modo as $member) : ?>
        <?= $member->name; ?>

        <?= (end($modo) !== $member) ? ', ' : '' ?>
    <?php endforeach; ?>
</div>