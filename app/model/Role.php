<?php

namespace Teambuilder\model;

use Teambuilder\core\model\DB;
use Teambuilder\core\model\Model;

class Role extends Model
{
    public $id;
    public $slug;
    public $name;

    const MODO = 2;

    static function make(array $fields): Role // create object, but no db record
    {
        $role = new Role();
        $role->id = (isset($fields['id'])) ? $fields['id'] : null;
        $role->slug = $fields["slug"];
        $role->name = $fields["name"];
        return $role;
    }

    /**
     * get all members with current role inctence
     *
     * @return void
     */
    public function members()
    {
        $query = 'SELECT members.id, members.name, members.role_id FROM members WHERE members.role_id = :id ORDER BY members.name ASC';
        return DB::selectMany($query, ['id' => $this->id], Member::class);
    }
}
