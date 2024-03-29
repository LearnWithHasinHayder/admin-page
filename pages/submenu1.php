<?php
include_once ('header.php');
?>
<h1 class='text-red-700'>Welcome to Submenu Page 1</h1>
<form method="post">
    <?php wp_nonce_field('save_name', 'save_name_nonce'); ?>
    <label for="name">Name</label>
    <input type="hidden" name="action" value="save_name">
    <input type="text" name="user_name" placeholder="Enter your name" value="<?php echo esc_attr(get_option('user_name'));?>">
    <input type="submit" value="Submit">
</form>
<?php
include_once ('footer.php');
