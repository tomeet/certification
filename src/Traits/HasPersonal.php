<?php


namespace Tomeet\Certification\Traits;


use Tomeet\Certification\Models\CertificationPersonal;

trait HasPersonal
{
    public function personal()
    {
        return $this->hasOne(CertificationPersonal::class, config('certification.user_foreign_key'));
    }


}
