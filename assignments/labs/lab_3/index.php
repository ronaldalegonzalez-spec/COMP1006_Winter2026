<?php require "includes/header.php" ?>
<main>
  <h2> Contact us - Bake it till you make it! 🧁</h2>
  <form action="process.php" method="post">
<!-- STEP ONE - Add Client Side Validation with HTML -->
    <!-- Customer Information -->
    <fieldset>
      <legend>Customer Information</legend>
        <label for="first_name">First name</label>
        <input type="text" id="first_name" name="first_name" required>
        <label for="last_name">Last name</label>
        <input type="text" id="last_name" name="last_name" required>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
    </fieldset>

    <fieldset>
      <legend>Additional Comments</legend>

      <p>
        <label for="comments">Comments (optional)</label><br>
        <textarea id="comments" name="comments" rows="4"
          placeholder="enter your message here"></textarea>
      </p>
    </fieldset>

    <p>
      <button type="submit">Send Message</button>
    </p>

  </form>
</main>
</body>

</html>

<?php require "includes/footer.php" ?>