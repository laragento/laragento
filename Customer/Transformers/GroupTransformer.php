<?php

namespace Laragento\Customer\Transformers;

use Laragento\Customer\Models\Group;
use League\Fractal;

class GroupTransformer extends Fractal\TransformerAbstract
{
    public function transform(Group $group)
    {
        return [
            'id' => (int)$group->customer_group_id,
            'customer_group_code' => $group->customer_group_code,
        ];
    }
}