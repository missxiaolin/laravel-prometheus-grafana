<?php
/**
 * Created by PhpStorm.
 * User: gb
 * Date: 2019-01-15
 * Time: 09:55
 */

namespace App\Src\Model;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

/**
 * Class User
 * @package App\Src\Model
 */
class User extends Model
{
    use Searchable;

    /**
     * 索引的字段
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return $this->only('id', 'password', 'username', 'email');
    }
}