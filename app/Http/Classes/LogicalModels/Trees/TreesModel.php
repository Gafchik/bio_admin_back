<?php

namespace App\Http\Classes\LogicalModels\Trees;

use App\Http\Facades\UserInfoFacade;
use  \App\Models\MySql\Biodeposit\Trees as TreesTable;
use App\Models\MySql\Biodeposit\Users;

class TreesModel
{
    public function __construct(
        private TreesTable $trees,
        private Users $users,
    ){}

    public function getPlantingDates(): array
    {
        return $this->trees
            ->selectRaw('YEAR(planting_date) as planting_year')
            ->distinct()
            ->pluck('planting_year')
            ->toArray();
    }
    public function getTress(array $data): array
    {
        $query = $this->trees
            ->from($this->trees->getTable() . ' as trees')
            ->leftJoin($this->users->getTable() . ' as users',
                'users.id',
                '=',
                'trees.user_id'
            )
            ->select([
                'trees.id',
                'trees.uuid',
                'users.email as owner_mail',
                'trees.season',
                'trees.initial_price',
                'trees.current_price',
            ])
            ->selectRaw('DATE_FORMAT(trees.sale_frozen_to, "%Y/%m/%d") as sale_frozen_to')
            ->selectRaw('DATE_FORMAT(trees.dividend_frozen_to, "%Y/%m/%d") as dividend_frozen_to')
            ->selectRaw('YEAR(trees.planting_date) as year');

            if(isset($data['uuid'])){
                $query->where('trees.uuid', $data['uuid']);
            }else{
                if(isset($data['email'])){
                    $query->where('users.email', $data['email']);
                }
                if(isset($data['plantingDate'])){
                    $query->whereYear('trees.planting_date', $data['plantingDate']);
                }
                if(!isset($data['email']) && !isset($data['plantingDate'])){
                    $query->limit(5000);
                }
            }
            return $query->orderByDesc('trees.id',)->get()->toArray();
    }
    public function editTrees(array $data): void
    {
        $newUser = $user = UserInfoFacade::getUserInfo('email',$data['owner_mail']);
        $this->trees
            ->where('id', $data['id'])
            ->update([
                'user_id' => $newUser['id'],
                'sale_frozen_to' => $data['sale_frozen_to'],
                'dividend_frozen_to' => $data['dividend_frozen_to'],
            ]);
    }
}
