<?php
require_once __DIR__ . '/../includes/functions.php';
require_admin();
$totalStudents = db()->query("SELECT COUNT(*) AS total FROM users WHERE role='student'")->fetch()['total'];
$pending = db()->query("SELECT COUNT(*) AS total FROM applications WHERE status='pending_review'")->fetch()['total'];
$validated = db()->query("SELECT COUNT(*) AS total FROM applications WHERE status='validated'")->fetch()['total'];
$paid = db()->query("SELECT COUNT(*) AS total FROM applications WHERE payment_status='paid'")->fetch()['total'];
$applications = db()->query("SELECT applications.*, users.full_name, users.email FROM applications JOIN users ON users.id = applications.user_id ORDER BY applications.id DESC LIMIT 10")->fetchAll();
require_once __DIR__ . '/../partials/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><h2 class="fw-bold mb-1">Tableaux de Bord Administrateur </h2><p class="text-secondary mb-0">Gestion de vérification des documents d'inscription</p></div>
    <a href="<?= e(url('admin/students.php')) ?>" class="btn btn-primary">Liste des étudiants inscrits</a>
</div>
<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><h6>Total étudiants</h6><div class="display-6 fw-bold"><?= e((string) $totalStudents) ?></div></div></div></div>
    <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><h6>En attente</h6><div class="display-6 fw-bold text-warning"><?= e((string) $pending) ?></div></div></div></div>
    <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><h6>Validés</h6><div class="display-6 fw-bold text-info"><?= e((string) $validated) ?></div></div></div></div>
    <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><h6>Payés</h6><div class="display-6 fw-bold text-success"><?= e((string) $paid) ?></div></div></div></div>
</div>
<div class="card border-0 shadow-sm rounded-4"><div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3"><h5 class="fw-bold mb-0">Derniers dossiers</h5><a href="<?= e(url('admin/review.php')) ?>" class="btn btn-outline-primary btn-sm">Vérifier les dossiers</a></div>
    <div class="table-responsive"><table class="table align-middle"><thead><tr><th>Étudiant</th><th>Email</th><th>Dossier</th><th>Statut</th><th>Action</th></tr></thead><tbody>
        <?php foreach ($applications as $app): ?>
            <tr><td><?= e($app['full_name']) ?></td><td><?= e($app['email']) ?></td><td><?= e($app['application_number']) ?></td><td><span class="badge text-bg-<?= application_badge($app['status']) ?>"><?= e($app['status']) ?></span></td><td><a class="btn btn-sm btn-primary" href="<?= e(url('admin/review.php?id=' . $app['id'])) ?>">Ouvrir</a></td></tr>
        <?php endforeach; ?>
    </tbody></table></div>
</div></div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>
