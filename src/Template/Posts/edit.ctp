<h1>Editar post</h1>

<?php
echo $this->Form->create($post);

echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]);
echo $this->Form->control('title');
echo $this->Form->control('body', ['rows' => 10]);

echo $this->Form->control('categories._ids', ['options' => $categories]);

echo $this->Form->button('Guardar');

echo $this->Form->end();
?>