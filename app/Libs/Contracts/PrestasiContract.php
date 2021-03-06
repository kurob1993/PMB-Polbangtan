<?php

namespace App\Libs\Contracts;

interface PrestasiContract
{
    public function createPrestasi(array $data);

    public function getPrestasiByPendaftaran(int $pendaftaranId);

    public function updatePrestasi(int $id, array $data);

    public function deletePrestasi(int $id);
}