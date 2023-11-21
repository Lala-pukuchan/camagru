<?php include("includes/header.php"); ?>


<?php

include("db/connection.php");

if (isset($_POST['other_user_id'])) {

    $other_user_id = $_POST['other_user_id'];
    $stmt->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->bind_param('i', $other_user_id);

    if ($stmt->execute()) {
        $user_array = $stmt->get_result();
    } else {
        header('location: index.php');
    }

} else {
    header('location: index.php');
    exit();
}

?>

<header class="profile-header">
    <header class="profile-container">
        <?php foreach ($user_array as $user) { ?>

            <div class="profile">
                <div class="profile-image">
                    <img src="<?php echo "assets/images/" . $user['image']; ?>" alt="" />
                </div>
                <div class="profile-user-setting">
                    <h1 class="profile-user-name">
                        <?php echo $user['username']; ?>
                    </h1>
                </div>
                <div class="profile-stats">
                    <ul>
                        <li><span class="profile-stat-count">
                                <?php echo $user['post']; ?>
                            </span> posts</li>
                        <li><span class="profile-stat-count">
                                <?php echo $user['followers']; ?>
                            </span> followers</li>
                        <li><span class="profile-stat-count">
                                <?php echo $user['following']; ?>
                            </span> following</li>
                    </ul>
                </div>
                <div class="profile-bio">
                    <p>
                        <span class="profile-real-name">
                            <?php echo $user['username']; ?>
                        </span>
                        <?php echo $user['bio']; ?>
                    </p>
                </div>
            </div>

        <?php } ?>
    </header>
</header>

<main>
    <div class="profile-container">
        <div class="gallery">

            <?php include("get_other_post.php"); ?>

            <?php foreach ($posts as $post) { ?>

                <div class="gallery-item">
                    <img src="<?php echo "assets/images/" . $post['image']; ?>" class="gallery-image" alt="" />
                    <div class="gallery-item-info">
                        <ul>
                            <li class="gallery-item-likes">
                                <span class="hide-gallery-element">
                                    Likes:
                                    <?php echo $post['likes']; ?>
                                </span>
                                <i class="fas fa-heart"></i>
                            </li>
                            <li class="gallery-item-comments">
                                <span class="hide-gallery-element">Comments:</span>
                                <i class="fas fa-comment"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</main>

<!--script-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/5d47e6cf8c.js"></script>

</body>

</html>