<?php
session_start();
$isLoggedIn = isset($_SESSION['user']);
$user = $isLoggedIn ? $_SESSION['user'] : null;
?>

<!-- Simpan navigasi yang akan dimasukkan ke HTML utama -->
<div id="nav-from-php" style="display:none">
  <li><a href="homepage.html">Home</a></li>
  <li><a href="DaftarBuku.php">Books</a></li>
  <?php if ($isLoggedIn): ?>
    <li><a href="#profile">Profile (<?= htmlspecialchars($user['name']) ?>)</a></li>
    <li><a href="logout.php">Logout</a></li>
  <?php else: ?>
    <li><a href="UserLogin.html">Login</a></li>
  <?php endif; ?>
</div>

<?php if ($isLoggedIn): ?>
  <section class="profile" id="profile">
    <h2>Edit Profil</h2>
    <form method="POST" action="update_profile.php">
      <input type="hidden" name="id" value="<?= $user['id'] ?>">
      <label for="name">Nama:</label>
      <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required><br>

      <label for="old_password">Password Lama:</label>
      <input type="password" name="old_password" required><br>

      <label for="new_password">Password Baru:</label>
      <input type="password" name="new_password"><br>

      <button type="submit">Update Profil</button>
    </form>
  </section>
<?php endif; ?>
