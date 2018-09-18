<?php $title = 'Create Post'; ?>

<?php ob_start(); ?>

<h1>Create Post</h1>

<form id="form-submit" novalidate="true">
    <label for="title">Title</label>
    <p><input type="text" name="title" id="title"/></p>
    <select id="title-select" name="title-select"></select>
    <p><input type="submit" value="Submit" id="submit"/></p>
</form>

<?php $content = ob_get_clean(); ?>

<?php include 'layout.php'; ?>