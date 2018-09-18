<?php $title = 'List of Posts'; ?>

<?php ob_start(); ?>

<h1>List of Posts</h1>
<a href="index.php/create">Create Post</a>
<input type="search" value="" title="Search Post" placeholder="Search" id="search-post" onkeydown="saveSearch(this.value, event);"/>
<input type="button" onclick="searchPost();" value="Search">
<div id="list-post">
    <ul>
        <?php foreach ($posts as $post) { ?>
        <li>
            <a href="index.php/show?id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a>
        </li><?php
        }?>
    </ul>
</div>

<?php $content = ob_get_clean(); ?>

<?php include 'layout.php'; ?>
