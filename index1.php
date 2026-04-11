<?php
require "db.php";
// Add task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['task'])) {
$task = htmlspecialchars(trim($_POST['task']));
$stmt = $pdo->prepare('INSERT INTO todos (task) VALUES (?)');
$stmt->execute([$task]);
header('Location: index1.php');
exit;
}
// Delete task
if (isset($_GET['delete'])) {
$stmt = $pdo->prepare('DELETE FROM todos WHERE id = ?');
$stmt->execute([(int)$_GET['delete']]);
header('Location: index1.php');
exit;
}
// Fetch all tasks
$todos = $pdo->query('SELECT * FROM todos ORDER BY created
DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html><body>
<h1>My To-Do List</h1>
<form method="POST">
<input type="text" name="task" placeholder="New task..." required>
<button>Add</button>
</form>
<ul>
<?php foreach ($todos as $t): ?>
<li>
<?= htmlspecialchars($t["task"]) ?>
<a href="?delete=<?= $t["id"] ?>">[Delete]</a>
</li>
<?php endforeach; ?>
</ul>
</body></html>