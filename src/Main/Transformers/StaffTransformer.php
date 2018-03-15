
<?php

namespace Main\Transformers;

use Main\Models\Staff;
use League\Fractal\TransformerAbstract;

class StaffTransformer extends TransformerAbstract
{

    public function transform(Staff $staff)
    {
        return [
            'id'            => (int)$staff->id,
            'email'         => $staff->email,
            'createdAt'     => optional($staff->created_at)->toIso8601String(),
            'updatedAt'     => optional($staff->update_at)->toIso8601String(),
            'username'      => $staff->username,
            'bio'           => $staff->bio,
            'moto'          => $staff->moto,
            'address'       => $staff->address,
            'mission'       => $staff->mission,
            'vision'        => $staff->vision,
            'about'         => $staff->about,
            'search_term'   => $staff->search_term,
            'image'         => $staff->image,
            'token'         => $staff->token,

        ];
    }
}