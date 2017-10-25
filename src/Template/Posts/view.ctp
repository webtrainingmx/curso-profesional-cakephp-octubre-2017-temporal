<h1><?= $post->title ?></h1>

<p>
    <?= $post->body ?>
</p>

<p>
    <strong>Creado el:</strong>
    <span><?= $post->created->format(DATE_ISO8601) ?></span>
</p>

