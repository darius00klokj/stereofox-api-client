<?php

namespace SFAPI\Models;

/**
 * Description of UserAccount
 *
 * @author darius
 */
class UserAccount {

    public $account_id;
    public $type;
    public $user_id;
    public $email;
    public $name;
    public $image;

    public function __construct(mixed $accountData) {
        if ($accountData) {
            $this->populate($accountData);
        }
    }

    /**
     * Fills genre object with the response data.
     *
     * @param array $accountData  API JSON response
     * @return boolean
     */
    public function populate(mixed $accountData) {

        $accountData = is_array($accountData) ? (object) $accountData : $accountData;
        if (!$accountData || !isset($accountData->account_id)) {
            return false;
        }

        foreach ($accountData as $property => $value) {
            if (property_exists(static::class, $property)) {
                $this->{$property} = $value;
            }
        }

    }

    public function getAccount_id() {
        return $this->account_id;
    }

    public function getType() {
        return $this->type;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getName() {
        return $this->name;
    }

    public function getImage() {
        return $this->image;
    }

    public function setAccount_id($account_id): void {
        $this->account_id = $account_id;
    }

    public function setType($type): void {
        $this->type = $type;
    }

    public function setUser_id($user_id): void {
        $this->user_id = $user_id;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function setName($name): void {
        $this->name = $name;
    }

    public function setImage($image): void {
        $this->image = $image;
    }


}