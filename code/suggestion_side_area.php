<p class="suggestion-text">Other users</p>

<?php include("get_suggestion.php"); ?>

<!--showing others users except the current user-->
<?php foreach ($suggestions as $suggestion) { ?>

    <?php if ($suggestion["id"] != $_SESSION["id"]) { ?>

        <div class="suggestion-card">
            <div class="suggestion-pic">
                <form action="other_user_profile.php" id="suggestion_form<?php echo $suggestion["id"]; ?>" method="post">
                    <input type="hidden" value="<?php echo $suggestion['id']; ?>" name="other_user_id">
                    <img onclick="document.getElementById('suggestion_form' + <?php echo $suggestion['id']; ?>).submit();"
                        src="<?php echo $suggestion["image"]; ?>" alt="" />
                </form>
            </div>
            <div>
                <p class="username">
                    <?php echo $suggestion['username']; ?>
                </p>
            </div>
        </div>

    <?php } ?>

<?php } ?>