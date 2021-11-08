<?php


namespace Tomeet\Certification\Traits;


use Tomeet\Certification\Models\CertificationOfficial;

trait HasOfficial
{
    public function official()
    {
        return $this->hasOne(CertificationOfficial::class, config('certification.user_foreign_key'));
    }
}
