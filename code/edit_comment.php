<?php include("includes/header.php")?>

<?php 

include("db/connection.php");

if (isset($_GET['comment_id']) && isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $comment_id = $_GET['comment_id'];
    $stmt = $conn->prepare("SELECT * FROM comments WHERE id = ?");
    $stmt->bind_param('i', $comment_id);
    $stmt->execute();
    $comment_array = $stmt->get_result();
} else {
    header("location: index.php");
    exit();
}
?>


<!--show success message-->
<?php if (isset($_GET['success_message'])) { ?>

<p class="text-center alert-success mt-4" id="success_message" style="color:green">
  <?php echo $_GET['success_message']; ?>
</p>

<?php } ?>

<div class="camera-container">

    <!--show error message-->
    <?php if (isset($_GET['error_message'])) { ?>

    <p class="text-center alert-danger mt-4" id="error_message" style="color:red">
    <?php echo $_GET['error_message']; ?>
    </p>

    <?php } ?>

    <?php foreach ($comment_array as $comment){ ?>

        <div class="camera">
            <div class="camera-image">

                <form action="update_comment.php" method="post" class="camera-form">
                
                <div class="form-group">
                    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>"/>
                    <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>"/>
                </div>
                <div class="form-group">
                    <input type="text" name="commet_text" class="form-control" value="<?php echo $comment['comment_text']; ?>"/>
                </div>
                <div class="form-group">
                    <button type="submit" name="update_comment-btn" class="upload-btn" style="width:100%;">
                        Update comment
                    </button>
                </div>
                </form>
            </div>
        </div>
    
    <?php }?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/5d47e6cf8c.js"></script>
</body>

</html>