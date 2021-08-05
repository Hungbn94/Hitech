<?php

    namespace App;

    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Tymon\JWTAuth\Contracts\JWTSubject;

    class users extends Authenticatable implements JWTSubject
    {
        use Notifiable;
        protected $primaryKey = 'UserID';

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = ['UserName','password','Name','email','UserNumber','UserAdress','Permission','Active'];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'password', 'remember_token',
        ];

        public function getJWTIdentifier()
        {
            return $this->getKey();
        }
        public function getJWTCustomClaims()
        {
            return [];
        }
    }
    
