<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditLogModel extends Model
{
    protected $table      = 'audit_log';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'user_id', 'username', 'aksi', 'modul', 'data_id', 'keterangan', 'ip_address', 'created_at',
    ];

    /**
     * Catat aktivitas ke audit log
     */
    public static function catat(string $aksi, string $modul = '', int $dataId = null, string $keterangan = ''): void
    {
        $session = session();
        $request = \Config\Services::request();

        $model = new self();
        $model->insert([
            'user_id'    => $session->get('user_id'),
            'username'   => $session->get('username'),
            'aksi'       => $aksi,
            'modul'      => $modul,
            'data_id'    => $dataId,
            'keterangan' => $keterangan,
            'ip_address' => $request->getIPAddress(),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function getRecent(int $limit = 20): array
    {
        return $this->orderBy('created_at', 'DESC')->findAll($limit);
    }
}
