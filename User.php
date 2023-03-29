<?php

class User
{
    // email, username, password, date, profile_picture
    public string $email;
    public string $username;
    public string $password;
    public datetime $date;
    public string $profile_picture;

    public function __construct(array $row){
        $this->email = isset($row['email']) ? $row['email'] : null;
        $this->username = $row['username'] ?? null;
        $this->date = isset($row['date'])  ? $row['date'] : null;
        $this->profile_picture = isset($row['profile_picture'])  ? $row['profile_picture'] : null;
    }

    public function __call($name, $arguments)
    {
        // TODO: understand this
        $prefix = substr($name, 0, 3);
        $property = substr($name, 3);
        if ($prefix === 'get') {
            return $this->$property;
        }
        if ($prefix === 'set') {
            $this->$property = $arguments[0];
        }
        return null;
    }


    public function toArray(){
        return [
            'email' => $this->email,
            'username' => $this->username,
            'password' => $this->password,
            'date' => $this->date,
            'profile_picture' => $this->profile_picture,
        ];
    }
}