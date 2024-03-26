<h1>Articles</h1>
<table>
    <tr>
        <th>Title</th>
        <th>Created</th>
    </tr>

    <?php foreach ($articles as $article) : ?>
        <tr>
            <td>
                <?= $this->Html->link($article->title, ['action' => 'view', $article->slug]) ?>
            </td>
            <td>
                <?= isset($article->created_at) ? $article['created_at'] : 'N/A' ?>
            </td>
        </tr>
    <?php endforeach; ?>




</table>