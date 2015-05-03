<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<div class="col-sm-4">
    <ul class="list-group">
        <?php foreach ($snapshot->getItems() as $item): ?>
            <li class="list-group-item">
                <h4 class="list-group-item-heading"><?= $item['class']; ?> <?= $item['function'] ?></h4>
                <?php if ( ! empty($item['file'])): ?>
                    <p><?= $item['file'] ?>:<?= $item['line'] ?></p>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<div class="col-sm-8">
    <?php foreach ($snapshot->getItems() as $item): ?>

    <?php endforeach; ?>
</div>