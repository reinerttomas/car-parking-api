<?php
declare(strict_types=1);

namespace App\Http\Requests;

/**
 * @template T of FormData
 */
interface DataPassedValidation
{
    /**
     * @return T
     */
    public function data();
}
