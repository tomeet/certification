<?php

namespace Tomeet\Certification\Models;

use Illuminate\Database\Eloquent\Model;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tomeet\Certification\ModelFilters\CertificationPersonalFilter;
use Tomeet\Review\Traits\HasReviews;

class CertificationPersonal extends Model
{
    use HasFactory, Filterable, HasReviews;

    protected $guarded = ['id'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:00',
        'updated_at' => 'datetime:Y-m-d H:i:00',
    ];


    /**
     * EloquentFilter
     *
     * @return string|null
     */
    public function modelFilter()
    {
        return $this->provideFilter(CertificationPersonalFilter::class);
    }


    /**
     * UserModel BelongsTo
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'), config('certification.user_foreign_key'));
    }


    /**
     * 处理创建
     *
     * @param $request
     * @param $user
     * @return CertificationPersonal
     * @throws Exception
     */
    public static function handleCreate($request, $user)
    {
        $personal = $user->personal;
        if ($personal) {
            throw new Exception('请勿重复提交认证!');
        }

        $personal = $user->personal()->create($request->all());
        return $personal;
    }


    /**
     * 处理更新
     *
     * @param $request
     * @param $user
     * @throws Exception
     */
    public static function handleUpdate($request, $user)
    {
        $personal = $user->personal;
        if ($personal && $personal->status >= 0) {
            throw new Exception('请求错误!');
        }

        $personal->fill($request->all());
        $personal->save();
    }


    /**
     * 处理审核
     *
     * @param $personal_id
     * @param $status
     * @param string $suggestion
     */
    public static function handleReview($personal_id, $status, $suggestion = '')
    {
        $personal = CertificationPersonal::find($personal_id);
        $personal->status = $status;
        $personal->save();

        // 添加审核记录
        $personal->setReview([
            'status' => $status,
            'suggestion' => $suggestion
        ]);

        // TODO::发送站内消息通知
    }
}
