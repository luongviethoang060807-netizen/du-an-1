<?php
class Banner extends BaseModel
{
    protected $table = 'banners';

    public function getAllBanners()
    {
        $sql = "SELECT * FROM `banners` ORDER BY `id` ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}