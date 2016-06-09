<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<style>
    li.list-group-item p {
        word-wrap: break-word;
        word-break: break-word;
    }
    .list-group {
        word-wrap:break-word;
    }
    h4.list-group-item-heading {
        word-wrap: break-word;
        word-break: break-word;
    }
</style>
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
    <?php $additionalData = $snapshot->getAdditionalData(); ?>
    <?php if(!empty($additionalData)): ?>
        <h3>Additional Data</h3>
        <table class="table">
            <?php foreach($additionalData as $variable => $value): ?>
                <tr>
                    <td><?= $variable ?></td>
                    <td><?= $value ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <h3>Server</h3>
    <table class="table">
        <?php foreach ($snapshot->getServer() as $variable => $value): ?>
            <tr>
                <td><?= $variable ?></td>
                <td><?= $value ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>Post</h3>
    <table class="table">
        <?php if ($snapshot->hasPost()): ?>
            <?php foreach ($snapshot->getPost() as $variable => $value): ?>
                <tr>
                    <td><?= $variable ?></td>
                    <td><?= $value ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <em>Empty</em>
        <?php endif; ?>
    </table>

    <h3>Get</h3>
    <table class="table">
        <?php if ($snapshot->getGet()): ?>
            <?php foreach ($snapshot->getGet() as $variable => $value): ?>
                <tr>
                    <td><?= $variable ?></td>
                    <td><?= $value ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <em>Empty</em>
        <?php endif; ?>
    </table>

    <h3>Files</h3>
    <table class="table">
        <?php if ($snapshot->getFiles()): ?>
            <?php foreach ($snapshot->getFiles() as $variable => $value): ?>
                <tr>
                    <td><?= $variable ?></td>
                    <td><?= $value ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <em>Empty</em>
        <?php endif; ?>
    </table>

    <h3>Cookies</h3>
    <table class="table">
        <?php if ($snapshot->getCookies()): ?>
            <?php foreach ($snapshot->getCookies() as $variable => $value): ?>
                <tr>
                    <td><?= $variable ?></td>
                    <td><?= $value ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <em>Empty</em>
        <?php endif; ?>
    </table>

    <h3>Session</h3>
    <table class="table">
        <?php if ($snapshot->getSession()): ?>
            <?php foreach ($snapshot->getSession() as $variable => $value): ?>
                <tr>
                    <td><?= $variable ?></td>
                    <td><?= $value ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <em>Empty</em>
        <?php endif; ?>
    </table>

    <h3>Environment</h3>
    <table class="table">
        <?php if ($snapshot->getEnvironment()): ?>
            <?php foreach ($snapshot->getEnvironment() as $variable => $value): ?>
                <tr>
                    <td><?= $variable ?></td>
                    <td><?= $value ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <em>Empty</em>
        <?php endif; ?>
    </table>
</div>
