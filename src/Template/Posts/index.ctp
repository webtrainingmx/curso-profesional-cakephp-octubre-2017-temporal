<h1>
    Mis posts
</h1>

<?= $this->Html->link('Agregar post', ['action', 'add']) ?>

<table>
    <thead>
    <tr>
        <th>Título</th>
        <th>Fecha de creación</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($posts as $post): ?>

        <tr>
            <td>
                <?=
                $this->Html->link($post->title, ['action' => 'view', $post->slug])
                ?>
            </td>
            <td>
                <?= $post->created->format(DATE_RFC850) ?>
            </td>
            <td>
                <?= $this->Html->link('Editar', ['action' => 'edit', $post->slug]) ?>
                <?=
                    $this->Form->postLink('Eliminar',
                        ['action' => 'delete', $post->slug],
                        ['confirm' =>
                            'Estás seguro de eliminar el post' . $post->title .'?'
                        ]
                    )
                ?>
            </td>
        </tr>
    <?php endforeach; ?>

    </tbody>

</table>