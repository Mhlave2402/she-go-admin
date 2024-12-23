<?php

namespace Modules\PromotionManagement\Service;

use App\Repository\EloquentRepositoryInterface;
use App\Service\BaseService;
use Illuminate\Database\Eloquent\Model;
use Modules\PromotionManagement\Repository\BannerSetupRepositoryInterface;
use Modules\PromotionManagement\Service\Interface\BannerSetupServiceInterface;

class BannerSetupService extends BaseService implements Interface\BannerSetupServiceInterface
{
    protected $bannerSetupRepository;
    public function __construct(BannerSetupRepositoryInterface $baseRepository)
    {
        parent::__construct($baseRepository);
        $this->bannerSetupRepository = $baseRepository;
    }

    public function list($data,$limit,$offset){
        return $this->bannerSetupRepository->list($data,$limit,$offset);
    }

    public function create(array $data): ?Model
    {
        $storeData = [
            'name'=>$data['banner_title'],
            'description'=>$data['short_desc'],
            'display_position'=>$data['display_position'] ?? null,
            'time_period'=>$data['time_period'],
            'redirect_link'=>$data['redirect_link'],
            'banner_group'=>$data['banner_group'] ?? null,
            'start_date'=>$data['start_date'] ?? null,
            'end_date'=>$data['end_date'] ?? null,
            'image'=>fileUploader('promotion/banner/', 'png', $data['banner_image']),
        ];
        return parent::create($storeData);
    }

    public function update(int|string $id, array $data = []): ?Model
    {
        $model = $this->findOne(id: $id);
        $updateData = [
            'name'=>$data['banner_title'],
            'description'=>$data['short_desc'],
            'display_position'=>$data['display_position'] ?? null,
            'time_period'=>$data['time_period'],
            'redirect_link'=>$data['redirect_link'],
            'banner_group'=>$data['banner_group'] ?? null,
            'start_date'=>$data['start_date'] ?? null,
            'end_date'=>$data['end_date'] ?? null,
        ];
        if (array_key_exists('banner_image', $data)) {
            $updateData = array_merge($updateData,[
                'image'=>fileUploader('promotion/banner/', 'png', $data['banner_image'], $model->image),
            ]);
        }
        return parent::update($id, $updateData);
    }
}
