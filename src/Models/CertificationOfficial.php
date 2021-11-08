<?php

namespace Tomeet\Certification\Models;

use Illuminate\Database\Eloquent\Model;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tomeet\Certification\ModelFilters\CertificationOfficialFilter;
use Tomeet\Reviews\Traits\HasReviews;

class CertificationOfficial extends Model
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
        return $this->provideFilter(CertificationOfficialFilter::class);
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
     * @return CertificationOfficial
     * @throws Exception
     */
    public static function handleCreate($request, $user)
    {
        if ($user->official) {
            throw new Exception('请勿重复提交认证！');
        }

        $official = new CertificationOfficial();
        $official->fill($request->all());
        $official->user_id = $user->id;
        $official->save();

        return $official;
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
        $official = $user->official;
        if ($official && $official->status >= 0) {
            throw new Exception('请求错误！');
        }

        $official->fill($request->all());
        $official->save();
    }


    /**
     * 处理审核
     *
     * @param $id
     * @param int $status
     * @param string $suggestion
     */
    public static function handleReview($id, $status = 0, $suggestion = '')
    {
        $official = CertificationOfficial::find($id);
        $official->status = (int)$status;
        $official->save();

        // 添加审核记录
        $official->setReview([
            'status' => $status,
            'suggestion' => $suggestion
        ]);
    }
}
