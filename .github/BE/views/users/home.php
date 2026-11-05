<?php /** @var array $users */ ?>

<div class="row row-cols-1 row-cols-md-2 g-3">
    <?php if (!empty($users) && is_array($users)): ?>
        <?php foreach ($users as $user): ?>
            <?php
                $name = htmlspecialchars($user['name'] ?? $user['user_name'] ?? 'Người dùng bí ẩn');
                $email = htmlspecialchars($user['email'] ?? 'chưa có email');
                $createdAt = htmlspecialchars($user['created_at'] ?? 'Không rõ');
                $avatarUrl = !empty($user['image'])
                    ? htmlspecialchars(BASE_ASSETS_UPLOADS . '/' . $user['image'])
                    : 'https://via.placeholder.com/400x220?text=No+Avatar';
            ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    <img style="width: 250px;" src="<?= $avatarUrl ?>" class="card-img-top" alt="Avatar của <?= $name ?>">
                    <div class="card-body">
                        <h5 class="card-title mb-2"><?= $name ?></h5>
                        <p class="card-text mb-1"><strong>Email:</strong> <?= $email ?></p>
                        <p class="card-text mb-1 text-muted"><small>Tham gia: <?= $createdAt ?></small></p>
                        <span class="badge bg-warning text-dark">Meme user</span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="alert alert-info mb-0">
                Chưa có user nào để hiển thị. Thử thêm dữ liệu user và tải lại trang nhé.
            </div>
        </div>
    <?php endif; ?>
</div>
