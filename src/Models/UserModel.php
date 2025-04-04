<?php

namespace Framework\Models;

/**
 * Class UserModel
 *
 * A model class specifically for the 'users' table.
 * Extends the base Model class to inherit common database operations.
 *
 * @package Framework\Models
 */
class UserModel extends Model {
    /**
     * UserModel constructor.
     *
     * Initializes the model to use the 'users' table.
     */
    public function __construct() {
        parent::__construct('users');
    }
}
